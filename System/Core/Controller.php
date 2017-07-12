<?php

namespace System\Core;

use System\Libraries\View\View;

class Controller
{

	/** @var \System\Libraries\Http\Messages\Request */
	public $request = null;

	/** @var \System\Libraries\Http\Messages\Response */
	public $response = null;

	/** @var View */
	public $view = null;

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
