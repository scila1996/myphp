<?php

namespace System\Core;

use System\Core\Container;
use System\Libraries\View\View;

/**
 * @property \System\Libraries\Http\Messages\Request $request
 * @property \System\Libraries\Http\Messages\Response $response
 * @property View $view
 */
class Controller
{

	/**
	 * 
	 * @param Container $container
	 */
	public function __construct(Container $container)
	{
		foreach ($container->getIterator() as $prop => $obj)
		{
			$this->{$prop} = $obj;
		}
	}

	/**
	 * 
	 * @param string $name
	 * @return mixed
	 */
	public function __get($name)
	{
		return isset($this->{$name}) ? $this->{$name} : null;
	}

	/**
	 * 
	 * @return $this
	 */
	public function __init()
	{
		return $this;
	}

	/**
	 * 
	 * @param string $uri
	 * @param array $data
	 */
	protected function redirect($uri = null, $data = [])
	{
		if ($uri === null)
		{
			$uri = $this->request->getUri();
		}
		else if ($data)
		{
			$uri .= "?" . http_build_query($data);
		}
		header("Location: {$uri}");
	}

}
