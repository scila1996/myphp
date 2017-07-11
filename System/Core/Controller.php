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
	 * @return $this
	 */
	public function __process()
	{
		return $this;
	}

}
