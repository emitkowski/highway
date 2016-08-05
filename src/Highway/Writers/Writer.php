<?php

namespace Larablocks\Highway;

/**
 * Class Writer
 *
 * @package Larablocks\Highway
 */
abstract class Writer
{

    /**
     * Source Object
     *
     * @var
     */
    protected $source;

    /**
     * Write Line Count
     *
     * @var int
     */
    protected $write_count;

    /**
     * Get Write Count
     *
     * @return int
     */
    public function getWriteCount()
    {
        return $this->write_count;
    }

    /**
     * Set Write Count
     *
     * @param int $write_count
     */
    public function setWriteCount($write_count)
    {
        $this->write_count = $write_count;
    }
}