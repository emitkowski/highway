<?php

namespace Larablocks\Highway;

class CSVWriter extends Writer implements WriterInterface
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
     * CSVWriter constructor.
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
        $handle = fopen($this->file_path, "w");

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
     * Write Columns
     *
     * @param array $columns
     * @return bool
     */
    public function writeColumns(array $columns)
    {
        return $this->writeCSVData($columns);
    }

    /**
     * Write Data Row
     *
     * @param array $data
     * @return bool
     */
    public function writeDataRow(array $data)
    {
        return $this->writeCSVData($data);
    }

    /**
     * Read CSV Data
     *
     * @param array $data
     * @return bool
     */
    private function writeCSVData(array $data)
    {
        return (bool) fputcsv($this->source, $data, $this->delimiter, $this->enclosure);
    }

    /**
     * Set Config for CSV reader
     *
     * @param array $settings
     * @return bool
     */
    public function setConfig(array $settings)
    {
        if (isset($settings['file_path'])) {
            $this->setFilePath($settings['file_path']);
        } else {
            return false;
        }

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