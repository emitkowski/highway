<?php

namespace Larablocks\Highway;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

/**
 * Class EloquentReader
 *
 * @package Larablocks\Highway
 */
class EloquentReader extends Reader implements ReaderInterface
{

    /**
     * Eloquent Model
     *
     * @var Model
     */
    protected $model;


    /**
     * Eloquent Collection
     *
     * @var Collection
     */
    protected $collection;

    /**
     * EloquentReader constructor.
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
        $this->source = $this->model;

        // If specific collection not set then load all from table
        if (!isset($this->collection)) {
            $this->collection = $this->model->all();
        }

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
     * Read Columns
     *
     * @return array
     */
    public function readColumns()
    {
        return Schema::getColumnListing($this->source->getTable());
    }

    /**
     * Read Data Row
     *
     * @return array
     */
    public function readDataRow()
    {
        $element = $this->collection->shift();

        if (is_object($element) || !is_array($element)) {
            $element = $element->toArray();
        }

        return $element;
    }

    /**
     * Check if more data exists at reader
     *
     * @return mixed
     */
    public function moreDataExists()
    {
        return $this->collection->count() > 0 ? true : false;
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

        if (isset($settings['collection'])) {
            $this->setCollection($settings['collection']);
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
        $config['model'] = $this->model;
        $config['collection'] = $this->collection;

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

    /**
     * Set Collection
     *
     * @param $collection
     * @return bool
     */
    private function setCollection($collection)
    {
        if (!$collection instanceof Collection) {
            $collection = collect([$collection]);
        }

        $this->collection = $collection;

        return true;
    }
}