<?php

namespace System\Core;

use System\Core\Container;
use System\Libraries\View\View;

/**
 * @property-read \System\Libraries\Http\Messages\Request $request
 * @property-read \System\Libraries\Http\Messages\Response $response
 * @property-read View $view
 */
class Controller
{

	/** @var \System\Libraries\Http\Messages\Request */
	protected $request = null;

	/** @var \System\Libraries\Http\Messages\Response */
	protected $response = null;

	/** @var View */
	protected $view = null;

	/**
	 * 
	 * @param Container $container
	 */
	final public function __construct(Container $container)
	{
		foreach ($container as $prop => $obj)
		{
			$this->{$prop} = $obj;
		}
	}

	/**
	 * 
	 * @param string $name
	 * @return mixed
	 */
	final public function __get($name)
	{
		return isset($this->{$name}) ? $this->{$name} : null;
	}

	/**
	 * This method can override.
	 * 
	 * @return $this
	 */
	public function __init()
	{
		return $this;
	}

}
