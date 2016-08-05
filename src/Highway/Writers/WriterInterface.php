<?php

namespace Larablocks\Highway;


interface WriterInterface
{

    /**
     * Open Data Source
     *
     * @return bool
     */
    public function openSource();

    /**
     * Close Data Source
     *
     * @return bool
     */
    public function closeSource();

    /**
     * Write Columns to source
     *
     * @param array $columns
     * @return bool
     */
    public function writeColumns(array $columns);

    /**
     * Write Data Row to source
     *
     * @param array $data
     * @return bool
     */
    public function writeDataRow(array $data);

    /**
     * Set Source Config
     *
     * @param array $settings
     * @return bool
     */
    public function setConfig(array $settings);

    /**
     * Get Source Config
     *
     * @return array
     */
    public function getConfig();

    /**
     * Get Write Count
     *
     * @return int
     */
    public function getWriteCount();

    /**
     * Set Write Count
     *
     * @param int $write_count
     * @return bool
     */
    public function setWriteCount($write_count);
}