<?php

namespace System\Core;

use System\Libraries\Router\HandlerResolverInterface;
use Closure;

class Handler implements HandlerResolverInterface
{

    /** @var Container */
    protected $container = null;

    /** @var string */
    protected $namespace = '';

    /** @var Controller */
    protected $controller = null;

    public function __construct(Container $container, $namespace = '')
    {
        $this->container = $container;
        $this->namespace = $namespace;
    }

    /**
     * 
     * @param array|Closure $handler
     * @return array|Closure
     */
    public function resolve($handler)
    {
        if (is_array($handler) && is_string($handler[0]))
        {
            $class = "{$this->namespace}\\{$handler[0]}";
            $this->controller = ($handler[0] = new $class($this->container));
            $this->controller->__init();
        }

        return $handler;
    }

}
