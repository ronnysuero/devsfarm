<?php namespace Helpers\CropImage;

use Illuminate\Support\ServiceProvider;

class CropImageServiceProvider extends ServiceProvider 
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Register 'underlyingclass' instance container to our UnderlyingClass object
        $this->app['cropimage'] = $this->app->share(function($app)
        {
            return new Helpers\CropImage\CropImage;
        });

        // Shortcut so developers don't need to add an Alias in app/config/app.php
        $this->app->booting(function()
        {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('CropImage', 'Helpers\CropImage\CropImage');
        });
    }
}