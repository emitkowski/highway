<?php

namespace Larablocks\Highway;

/**
 * Class CSVReader
 * @package Larablocks\Highway
 */
class CSVReader extends Reader implements ReaderInterface
{
    /**
     * CSV Read File Path
     *
     * @var
     */
    protected $file_path;

    /**
     * CSV delimiter
     *
     * @var string
     */
    protected $delimiter = ",";

    /**
     * CSV Field Enclosure
     *
     * @var string
     */
    protected $enclosure = "\"";


    /**
     * CSVReader constructor.
     */
    public function __construct()
    {
    }

    /**
     * Open CSV Source
     *
     * @return bool
     */
    public function openSource()
    {
        $handle = fopen($this->file_path, "r");

        if ($handle === false) {
            return false;
        }

        $this->source = $handle;

        return true;
    }

    /**
     * Close CSV Source
     *
     * @return bool
     */
    public function closeSource()
    {
        return fclose($this->source);
    }

    /**
     * Read Columns
     *
     * @return array
     */
    public function readColumns()
    {
        return $this->readCSVData();
    }

    /**
     * Read Data Row
     *
     * @return array
     */
    public function readDataRow()
    {
       return $this->readCSVData();
    }

    /**
     * Check if more data exists at reader
     *
     * @return mixed
     */
    public function moreDataExists()
    {
        return !feof($this->source);
    }

    /**
     * Set Config for CSV reader
     *
     * @param array $settings
     * @return bool
     */
    public function setConfig(array $settings)
    {
        if (!isset($settings['file_path'])) {
            return false;
        }

        $this->setFilePath($settings['file_path']);

        if (isset($settings['delimiter'])) {
            $this->setDelimiter($settings['delimiter']);
        }

        if (isset($settings['enclosure'])) {
            $this->setEnclosure($settings['enclosure']);
        }

        return true;
    }

    /**
     * Get Config for CSV Reader
     *
     * @return mixed
     */
    public function getConfig()
    {
        $config['file_path'] = $this->file_path;
        $config['delimiter'] = $this->delimiter;
        $config['enclosure'] = $this->enclosure;

        return $config;
    }


    /**
     * Read CSV Data
     *
     * @return array
     */
    private function readCSVData()
    {
        return fgetcsv($this->source, 0, $this->delimiter, $this->enclosure);
    }

    /**
     * Set File Path
     *
     * @param $file_path
     * @return bool
     */
    private function setFilePath($file_path)
    {
        $this->file_path = $file_path;

        return true;
    }

    /**
     * Set Delimiter
     *
     * @param $delimiter
     * @return bool
     */
    private function setDelimiter($delimiter)
    {
        $this->delimiter = $delimiter;

        return true;
    }

    /**
     * Set Enclosure
     *
     * @param $enclosure
     * @return bool
     */
    private function setEnclosure($enclosure)
    {
        $this->enclosure = $enclosure;

        return true;
    }
}