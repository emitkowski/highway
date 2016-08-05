<?php

namespace Larablocks\Highway;

use InvalidArgumentException;

/**
 * Class ReaderFactory
 * @package Larablocks\Highway
 */
class ReaderFactory
{


    public function __construct()
    {

    }

    /**
     * Create Reader based on type
     *
     * @param $type
     * @return ReaderInterface
     */
    public function createReader($type)
    {

        switch ($type) {
            case 'csv':
                return new CSVReader();
            case 'database':
                return new DatabaseReader();
            case 'eloquent':
                return new EloquentReader();
        }

        throw new InvalidArgumentException("Unsupported Reader: [{$type}]");
    }

}