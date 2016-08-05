<?php

namespace Larablocks\Highway;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Class DatabaseReader
 *
 * @package Larablocks\Highway
 */
class DatabaseReader extends Reader implements ReaderInterface
{

    /**
     * Database Table
     *
     * @var string
     */
    protected $table;


    /**
     * Database Results
     *
     * @var array
     */
    protected $results;

    /**
     * EloquentReader constructor.
     */
    public function __construct()
    {

    }

    /**
     * Open Database Source
     *
     * @return bool
     */
    public function openSource()
    {
        $this->source = DB::table($this->table);

        // If specific results from call not set then load all from table
        if (!isset($this->results)) {
            $this->results = $this->source->get();
        }

        return true;
    }

    /**
     * Close Database Source
     *
     * @return bool
     */
    public function closeSource()
    {
        return true;
    }

    /**
     * Read Columns
     *
     * @return array
     */
    public function readColumns()
    {
        return Schema::getColumnListing($this->table);
    }

    /**
     * Read Data Row
     *
     * @return array
     */
    public function readDataRow()
    {
        $element = array_shift($this->results);

        return (array) $element;
    }

    /**
     * Check if more data exists at reader
     *
     * @return mixed
     */
    public function moreDataExists()
    {
        return count($this->results) > 0 ? true : false;
    }

    /**
     * Set Config
     *
     * @param array $settings
     * @return bool
     */
    public function setConfig(array $settings)
    {
        if (!isset($settings['table'])) {
            return false;
        }

        $this->setTable($settings['table']);

        if (isset($settings['results'])) {
            $this->setResults($settings['results']);
        }

        return true;
    }

    /**
     * Get Config
     *
     * @return mixed
     */
    public function getConfig()
    {
        $config['table'] = $this->table;
        $config['results'] = $this->results;

        return $config;
    }

    /**
     * Set Table
     *
     * @param $table
     * @return bool
     */
    private function setTable($table)
    {
        $this->table = $table;

        return true;
    }

    /**
     * Set Results
     *
     * @param array $results
     * @return bool
     */
    private function setResults($results)
    {
        $this->results = $results;

        return true;
    }
}