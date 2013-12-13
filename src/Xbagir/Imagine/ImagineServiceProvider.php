<?php namespace Xbagir\Imagine;

use Illuminate\Support\ServiceProvider;

class ImagineServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */

    public function boot()
    {
        $this->package('xbagir/imagine');
        
        include __DIR__.'/../../routes.php';
    }
        
	public function register()
	{
        $this->app['imagine'] = $this->app->share(function ($app)
        {
            $config = $app['config']->get('imagine') ?: $app['config']->get('imagine::imagine');
            
            return new Factory($config);
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('imagine');
	}

}