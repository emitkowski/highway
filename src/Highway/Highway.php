<?php

namespace Larablocks\Highway;

use RuntimeException;

/**
 * Class Highway
 *
 * @package Larablocks\Highway
 */
class Highway
{
    /**
     * Reader factory instance
     *
     * @var ReaderFactory
     */
    protected $reader_factory;


    /**
     * Writer factory instance
     *
     * @var WriterFactory
     */
    protected $writer_factory;


    /**
     * Reader Object
     *
     * @var ReaderInterface
     */
    protected $reader;


    /**
     * Writer Objects
     *
     * @var array
     */
    protected $writers = [];


    /**
     * Highway constructor.
     *
     * @param ReaderFactory $reader_factory
     * @param WriterFactory $writer_factory
     */
    public function __construct(ReaderFactory $reader_factory, WriterFactory $writer_factory)
    {
        $this->reader_factory = $reader_factory;
        $this->writer_factory = $writer_factory;
    }

    /**
     * Add New Reader
     *
     * @param $reader
     * @param array $config
     * @return ReaderInterface
     */
    public function addReader($reader, array $config = [])
    {
        if ($reader instanceof ReaderInterface) {
            return $this->loadReader($reader);
        }

        return $this->makeReader($reader, $config);
    }

    /**
     * Add New Writer
     *
     * @param $writer
     * @param array $config
     * @return WriterInterface
     */
    public function addWriter($writer, array $config = [])
    {
        if ($writer instanceof WriterInterface) {
            return $this->loadWriter($writer);
        }

        return $this->makeWriter($writer, $config);
    }

    /**
     * Reset Readers and Writers for Highway
     *
     * @return bool
     */
    public function reset()
    {
        $this->reader = null;
        $this->writers = [];

        return true;
    }


    /**
     * Execute reading and writing transfer
     */
    public function run()
    {
        // Check that reader loaded
        if (is_null($this->getReader())) {
            throw new RuntimeException("No reader loaded");
        }

        // Check that writer loaded
        if (empty($this->getWriters())) {
            throw new RuntimeException("No writer loaded");
        }

        // Open Reader Source
        $this->openReaderSource();

        // Run Data Writers
        $this->executeWriters();

        // Close Reader Source
        $this->closeReaderSource();
    }

    /**
     * Make reader using factory
     *
     * @param $type
     * @param array $config
     * @return ReaderInterface
     */
    private function makeReader($type, array $config = [])
    {
        $this->reader = $this->getReaderFactory()->createReader($type);
        $this->reader->setConfig($config);

        return $this->reader;
    }

    /**
     * Make writer using factory
     *
     * @param $type
     * @param array $config
     * @return WriterInterface
     */
    private function makeWriter($type, array $config = [])
    {
        $writer = $this->getWriterFactory()->createWriter($type);
        $writer->setConfig($config);

        $this->writers[] = $writer;

        return $writer;
    }

    /**
     * Load Reader Object
     *
     * @param ReaderInterface $reader
     * @return ReaderInterface
     */
    private function loadReader(ReaderInterface $reader)
    {
        $this->reader = $reader;

        return $reader;
    }

    /**
     * Load Writer Object
     *
     * @param WriterInterface $writer
     * @return WriterInterface
     */
    private function loadWriter(WriterInterface $writer)
    {
        $this->writers[] = $writer;

        return $writer;
    }

    /**
     * Reader Getter
     *
     * @return ReaderInterface
     */
    public function getReader()
    {
        return $this->reader;
    }

    /**
     * Writers Getter
     *
     * @return array
     */
    public function getWriters()
    {
        return $this->writers;
    }

    /**
     * Execute Data Writing for all sources
     *
     * @return bool
     */
    private function executeWriters()
    {
        // Open Writer Sources
        $this->openWriterSources();

        // Write Columns
        $this->writeColumns();

        // Write Data Rows
        $this->writeDataRows();

        // Close Writer Sources
        $this->closeWriterSources();

        return true;
    }

    /**
     * Open Writing Sources
     *
     * @return bool
     */
    private function openWriterSources()
    {
        foreach ($this->getWriters() as $writer) {
            $this->openWriterSource($writer);
        }

        return true;
    }

    /**
     * Write Columns for all sources
     *
     * @return bool
     */
    private function writeColumns()
    {
        $columns = $this->getReader()->readColumns();

        foreach ($this->getWriters() as $writer) {
            $writer->writeColumns($columns);
        }

        return true;
    }


    /**
     * Write Data Rows for all sources
     *
     * @return bool
     */
    private function writeDataRows()
    {
        // Set counts to zero
        foreach ($this->getWriters() as $writer) {
            $writer->setWriteCount(0);
        }

        // loop read data and write
        while ($this->getReader()->moreDataExists()) {

            $data = $this->getReader()->readDataRow();

            if (is_array($data)) {
                foreach ($this->getWriters() as $writer) {
                    $writer->writeDataRow($data);
                    $writer->setWriteCount($writer->getWriteCount() + 1);
                }
            } else {
                // no data so line skipped, log?
            }
        }

        return true;
    }

    /**
     * Close Writing Sources
     *
     * @return bool
     */
    private function closeWriterSources()
    {
        foreach ($this->getWriters() as $writer) {
            $this->closeWriterSource($writer);
        }

        return true;
    }

    /**
     * Open Reader Source
     *
     * @return bool
     */
    private function openReaderSource()
    {
        if ($this->getReader()->openSource() === false) {
            throw new RuntimeException("Could not load reader source");
        }

        return true;
    }

    /**
     * Close Reader Source
     *
     * @return bool
     */
    private function closeReaderSource()
    {
        if ($this->getReader()->closeSource() === false) {
            throw new RuntimeException("Could not close reader source");
        }

        return true;
    }

    /**
     * Open Writer Source
     *
     * @param WriterInterface $writer
     * @return bool
     */
    private function openWriterSource(WriterInterface $writer)
    {
        if ($writer->openSource() === false) {
            throw new RuntimeException("Could not load writer source");
        }

        return true;
    }

    /**
     * Close Writer Source
     *
     * @param WriterInterface $writer
     * @return bool
     */
    private function closeWriterSource(WriterInterface $writer)
    {
        if ($writer->closeSource() === false) {
            throw new RuntimeException("Could not close writer source");
        }

        return true;
    }

    /**
     * Reader Getter
     *
     * @return ReaderFactory
     */
    private function getReaderFactory()
    {
        return $this->reader_factory;
    }

    /**
     * Writer Getter
     *
     * @return WriterFactory
     */
    private function getWriterFactory()
    {
        return $this->writer_factory;
    }

}