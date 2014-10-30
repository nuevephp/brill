<?php namespace Brill\Resolvers;

use Brill\Interfaces\CallableResolverInterface;

class CallableResolver implements CallableResolverInterface
{
    public function build($callable)
    {
        $matches = array();

        if (is_string($callable) && preg_match('!^([^\:]+)\:([a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*)$!', $callable, $matches)) {
            $class = $matches[1];
            $method = $matches[2];
            $callable = function() use ($class, $method) {
                static $obj = null;
                if ($obj === null) {
                    $obj = new $class;
                }
                return call_user_func_array(array($obj, $method), func_get_args());
            };
        }

        if (!is_callable($callable)) {
            throw new \InvalidArgumentException('Route callable must be callable');
        }

        return $callable;
    }
}