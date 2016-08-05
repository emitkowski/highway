<?php

namespace Larablocks\Highway;

use Illuminate\Database\Eloquent\Model;

class EloquentWriter extends Writer implements WriterInterface
{
    /**
     * Eloquent Model
     *
     * @var Model
     */
    protected $model;

    /**
     * EloquentWriter constructor.
     */
    public function __construct()
    {
    }

    /**
     * Open Eloquent Source
     *
     * @return bool
     */
    public function openSource()
    {


        return true;
    }

    /**
     * Close Eloquent Source
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
     * @return array
     */
    public function writeColumns(array $columns)
    {

    }

    /**
     * Write Data Row
     *
     * @param array $data
     * @return array
     */
    public function writeDataRow(array $data)
    {

    }

    /**
     * Set Config
     *
     * @param array $settings
     * @return bool
     */
    public function setConfig(array $settings)
    {
        if (!isset($settings['model'])) {
            return false;
        }

        $this->setModel($settings['model']);

        return true;
    }

    /**
     * Get Config
     *
     * @return mixed
     */
    public function getConfig()
    {
        $config['model'] = $this->model;

        return $config;
    }

    /**
     * Set Model
     *
     * @param $model
     * @return bool
     */
    private function setModel($model)
    {
        $this->model = $model;

        return true;
    }

}