<?php

namespace Dialect\Modlify;

use Dialect\Modlify\Commands\AllCommand;
use Dialect\Modlify\Commands\ControllerCommand;
use Dialect\Modlify\Commands\FactoryCommand;
use Dialect\Modlify\Commands\PolicyCommand;
use Dialect\Modlify\Commands\RouteCommand;
use Dialect\Modlify\Commands\TestsCommand;
use Dialect\Modlify\Commands\ViewsCommand;
use Illuminate\Support\ServiceProvider;

class ModlifyServiceProvider extends ServiceProvider
{

	protected $commands = [
		ControllerCommand::class,
		ViewsCommand::class,
		FactoryCommand::class,
		TestsCommand::class,
		PolicyCommand::class,
		RouteCommand::class,
		AllCommand::class,
	];

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
	    $this->loadViewsFrom(__DIR__ . '/../views', 'modlify');

	    $this->publishes([
		    __DIR__ . '/../views' => base_path('resources/views/vendor/modlify')
	    ]);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
	    $this->commands($this->commands);
	    $this->app->bind('modlify', Modlify::class);
    }
}