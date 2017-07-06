<?php

namespace System\Libraries\View;

use ArrayObject;
use ArrayAccess;

class View implements ArrayAccess
{

	/** @var string */
	protected $dir = '.';

	/** @var string */
	protected $fileExt = '.php';

	/** @var Template */
	protected $layout = null;

	public function __construct()
	{
		$this->layout = new Template('php://memory');
	}

	/**
	 * 
	 * @param string $directory
	 * @return $this
	 */
	public function setTemplateDir($directory)
	{
		$this->dir = $directory;
		return $this;
	}

	/**
	 * 
	 * @param string $extension
	 * @return $this
	 */
	public function setFileExtension($extension)
	{
		$this->fileExt = $extension;
		return $this;
	}

	/**
	 * 
	 * @param string $file
	 * @param array $data
	 * @return Template
	 */
	public function template($file, $data = [])
	{
		$file = $this->dir . DIRECTORY_SEPARATOR . $file . $this->fileExt;
		return new Template($file, $data);
	}

	/**
	 * 
	 * @param string $file
	 * @param array $data
	 * @return $this
	 */
	public function set($file)
	{
		$this->layout = $this->template($file, new ArrayObject());
		return $this;
	}

	/** @return string */
	public function getContent()
	{
		return $this->layout->render();
	}

	public function offsetExists($offset)
	{
		return isset($this->layout->getData()[$offset]);
	}

	public function offsetGet($offset)
	{
		return $this->layout->getData()[$offset];
	}

	public function offsetSet($offset, $value)
	{
		$this->layout->getData()[$offset] = $value;
	}

	public function offsetUnset($offset)
	{
		unset($this->layout->getData()[$offset]);
	}

}
