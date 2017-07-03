<?php

namespace System\Libraries\View;

class View
{

	/** @var string */
	protected $dir = '.';

	/** @var string */
	protected $fileExt = '.php';

	/** @var Template */
	protected $layout = null;

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
	public function set($file, $data = [])
	{
		$this->layout = $this->template($file, $data);
		return $this;
	}

	/**
	 * @param Template
	 * @return $this
	 */
	public function layout($name, $file, $data = [])
	{
		$this->layout[$name] = $this->template($file, $data);
	}

	/** @return string */
	public function getContent()
	{
		return $this->layout->render();
	}

}
