<?php namespace Brill;

class Route extends \Slim\Route
{
    protected $controllerDependencies;

    public function getControllerDependencies()
    {
        return $this->controllerDependencies;
    }

    public function setControllerDependencies($controllerDependencies)
    {
        $this->controllerDependencies = $controllerDependencies;
    }

    /**
     * Get route callable
     * @return callable
     * @api
     */
    public function getCallable()
    {
        return $this->callable;
    }

    /**
     * Set route callable
     * @param callable $callable
     * @api
     */
    public function setCallable($callable)
    {
        if (!is_callable($callable)) {
            echo "not callable";
        }

        $this->callable = $callable;
    }
}