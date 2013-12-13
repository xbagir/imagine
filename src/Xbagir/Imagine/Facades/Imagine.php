<?php namespace Xbagir\Imagine\Facades;

use Illuminate\Support\Facades\Facade;

class Imagine extends Facade {

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'imagine'; }
}