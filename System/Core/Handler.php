<?php

namespace System\Core;

use System\Libraries\Router\HandlerResolverInterface;

class Handler implements HandlerResolverInterface
{

	/** @var Container */
	protected $container = null;

	/** @var Controller */
	protected $controller = null;

	public function __construct(Container $container)
	{
		$this->container = $container;
	}

	/** @return Controller */
	public function resolve($handler)
	{
		if (is_array($handler) && is_string($handler[0]))
		{
			$this->controller = new $handler[0]();

			foreach ($this->container->getIterator() as $prop => $obj)
			{
				$this->controller->{$prop} = $obj;
			}
		}

		$this->controller->__init();
		$handler[0] = $this->controller;

		return $handler;
	}

	public function getController()
	{
		return $this->controller;
	}

}
