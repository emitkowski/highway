<?php

namespace Larablocks\Highway\Facade;

use Illuminate\Support\Facades\Facade;


/**
 * Class Highway
 * @package Larablocks\Highway\Facade
 */
class Highway extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'highway';
    }
}