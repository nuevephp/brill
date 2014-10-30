<?php namespace Brill\Support;

use Brill\Application;

abstract class ServiceProvider
{
    /**
     * The application instance
     *
     * @var \Brill\Application
     */
    protected $app;

    /**
     * @param \Brill\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function boot()
    {}

    abstract public function register();
}
