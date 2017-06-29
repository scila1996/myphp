<?php

namespace System\Core;

class Model
{

	protected $controller = null;

	public function __construct(Controller $controller = null)
	{
		$this->controller = $controller;
	}

}
