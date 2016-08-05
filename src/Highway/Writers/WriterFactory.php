<?php

namespace Larablocks\Highway;

use InvalidArgumentException;

/**
 * Class WriterFactory
 * @package Larablocks\Highway
 */
class WriterFactory
{


    public function __construct()
    {

    }

    /**
     * Create Writer based on type
     *
     * @param $type
     * @return WriterInterface
     */
    public function createWriter($type)
    {

        switch ($type) {
            case 'csv':
                return new CSVWriter();
            case 'database':
                return new DatabaseWriter();
            case 'eloquent':
                return new EloquentWriter();
        }

        throw new InvalidArgumentException("Unsupported Writer: [{$type}]");
    }

}