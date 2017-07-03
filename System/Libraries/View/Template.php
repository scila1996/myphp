<?php

namespace System\Libraries\View;

use ArrayAccess;
use RuntimeException;

class Template implements ArrayAccess
{

	/** @var string */
	protected $file = '';

	/** @var array */
	protected $data = [];

	/** @var self[] */
	protected $layout = [];

	/**
	 * 
	 * @param string $file
	 * @param array $data
	 * @throws RuntimeException
	 */
	public function __construct($file, $data = [])
	{
		$this->file = $file;
		$this->data = $data;
	}

	/**
	 * 
	 * @return string
	 */
	public function render()
	{
		ob_start();
		extract($this->layout, EXTR_SKIP);
		extract($this->data, EXTR_SKIP);
		eval('?>' . file_get_contents($this->file));
		$str = ob_get_contents();
		ob_end_clean();
		return $str;
	}

	public function offsetExists($offset)
	{
		return isset($this->layout[$offset]);
	}

	public function offsetGet($offset)
	{
		return $this->layout[$offset];
	}

	public function offsetSet($offset, $value)
	{
		$this->layout[$offset] = $value;
	}

	public function offsetUnset($offset)
	{
		unset($this->layout[$offset]);
	}
	public function __toString()
	{
		return $this->render();
	}

}
