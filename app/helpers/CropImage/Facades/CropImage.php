<?php namespace Helpers\CropImage\Facades;

use Illuminate\Support\Facades\Facade;

class CropImage extends Facade 
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'cropimage'; }

}