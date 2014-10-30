<?php namespace Brill;

use Brill\Resolvers\CallableResolver;

class Application extends \Slim\App
{
    public function __construct(array $userSettings = array())
    {
        parent::__construct();

        // Route Callable Manager
        $this['resolver'] = function($c) {
            return new CallableResolver();
        };

        $this['router'] = function () {
            return new Router();
        };
    }

    protected function mapRoute($args)
    {
        $pattern = array_shift($args);
        $callable = $this['resolver']->build(array_pop($args));
        
        $route = new Route($pattern, $callable, $this['settings']['routes.case_sensitive']);
        $this['router']->map($route);
        if (count($args) > 0) {
            $route->setMiddleware($args);
        }

        return $route;
    }
}