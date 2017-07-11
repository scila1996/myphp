<?php

namespace System\Libraries\View;

class View extends Template
{

	/** @var string */
	protected $dir = '.';

	/** @var string */
	protected $fileExt = '.php';

	public function __construct()
	{
		$this->file = 'php://temp';
		$this->data = [];
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
		return new Template($this->getViewPath($file), $data);
	}

	/**
	 * 
	 * @param string $file
	 * @param array $data
	 * @return $this
	 */
	public function set($file)
	{
		$this->file = $this->getViewPath($file);
		return $this;
	}

	/** @return string */
	public function getContent()
	{
		return $this->render();
	}

	private function getViewPath($file)
	{
		return $this->dir . DIRECTORY_SEPARATOR . $file . $this->fileExt;
	}

}
