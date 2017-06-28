<?php

namespace System\Core;

use System\Libraries\View\Template;
use ArrayAccess;

class Container implements ArrayAccess
{

	protected $components = [];

	public function __construct()
	{
		$this->components = [
			'view' => new Template('php://input')
		];
	}

	public function offsetExists($offset)
	{
		return isset($this->components[$offset]);
	}

	public function offsetGet($offset)
	{
		return $this->offsetExists($offset) ? $this->components[$offset] : null;
	}

	public function offsetSet($offset, $value)
	{
		$this->components[$offset] = $value;
	}

	public function offsetUnset($offset)
	{
		unset($this->components[$offset]);
	}

}
