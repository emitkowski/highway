<?php

namespace Larablocks\Highway;

/**
 * Interface ReaderInterface
 * @package Larablocks\Highway
 */
interface ReaderInterface
{
    /**
     * Open Data Source
     *
     * @return mixed
     */
    public function openSource();

    /**
     * Close Data Source
     *
     * @return mixed
     */
    public function closeSource();

    /**
     * Read Columns from source
     *
     * @return mixed
     */
    public function readColumns();

    /**
     * Read Data Row from source
     *
     * @return mixed
     */
    public function readDataRow();


    /**
     * Check if more data exists for reader
     *
     * @return mixed
     */
    public function moreDataExists();

    /**
     * Set Source Config
     *
     * @param array $settings
     * @return mixed
     */
    public function setConfig(array $settings);

    /**
     * Get Source Config
     *
     * @return mixed
     */
    public function getConfig();
}