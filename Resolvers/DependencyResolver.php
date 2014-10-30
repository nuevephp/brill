<?php namespace Brill\Resolvers;

use Brill\Interfaces\CallableResolverInterface;

class DependencyResolver implements CallableResolverInterface
{
    private $container;

    public function __construct(\Pimple $container)
    {
        $this->container = $container;
    }

    public function build($callable)
    {
        if (is_string($callable) && preg_match('!^([^\:]+)\:([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)$!', $callable, $matches)) {

            $service = $matches[1];
            $method = $matches[2];

            if (!isset($this->container[$service])) {
                throw new \InvalidArgumentException('Route key does not exist in App');
            }

            $callable =  array($this->container[$service],$method);
        }

        if (!is_callable($callable)) {
            throw new \InvalidArgumentException('Route callable must be callable');
        }

        return $callable;
    }
}