<?php namespace Brill\Support;

use Brill\Application;

class ServiceManager
{
    protected $app;

    protected $services = [];

    /**
     * @param \Brill\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function boot()
    {
        foreach ($this->services as $service) {
            $service->boot();
        }
    }

    public function register(ServiceProvider $service)
    {
        $this->services[] = $service;
        $service->register();
    }

    public function registerServices(array $services)
    {
        foreach ($services as $service) {
            $this->register(new $service($this->app));
        }
    }
}
