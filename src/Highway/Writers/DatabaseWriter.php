<?php

namespace Larablocks\Highway;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseWriter extends Writer implements WriterInterface
{
    /**
     * Database Table
     *
     * @var string
     */
    protected $table;

    /**
     * Database Columns
     *
     * @var array
     */
    protected $columns;

    /**
     * DatabaseWriter constructor.
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
        // If tables exists then data will be attempt to insert into current table and columns
        if (Schema::hasTable($this->table)) {
            $this->source = DB::table($this->table);
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
     * Write Columns
     *
     * @param array $columns
     * @return bool
     */
    public function writeColumns(array $columns)
    {
        $this->columns = $columns;

        // Create table with columns if no source set
        if (!isset($this->source)) {

            // Create table schema
            Schema::create($this->table, function($table) use ($columns)
            {
                // Add all columns default as string
                foreach($columns as $column) {
                    $table->string($column);
                }
            });

            $this->source = DB::table($this->table);
        }

        return true;
    }

    /**
     * Write Data Row
     *
     * @param array $data
     * @return bool
     */
    public function writeDataRow(array $data)
    {
        $data = $this->addColumnNames($data);

        return $this->source->insert($data);
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

        if (isset($settings['columns'])) {
            $this->setColumns($settings['columns']);
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
        $config['columns'] = $this->columns;

        return $config;
    }

    private function addColumnNames(array $data)
    {
        return array_combine($this->columns, $data);
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
     * Set Columns
     *
     * @param $columns
     * @return bool
     */
    private function setColumns($columns)
    {
        $this->columns = $columns;

        return true;
    }


}