<?php

namespace System\Libraries\View;

class Template
{

	/** @var string */
	protected $file = '';

	/** @var array */
	protected $data = [];

	/**
	 * 
	 * @param string $file
	 * @param array $data
	 * @throws \RuntimeException
	 */
	public function __construct($file, $data = [])
	{
		$this->file = $file;
		$this->data = $data;
	}

	/** @return string */
	public function getFilePath()
	{
		return $this->file;
	}

	/* @return array */

	public function getData()
	{
		return $this->data;
	}

	/**
	 * 
	 * @return string
	 */
	public function render()
	{
		ob_start();
		extract((array) $this->data, EXTR_SKIP);
		eval('?>' . file_get_contents($this->file));
		$str = ob_get_contents();
		ob_end_clean();
		return $str;
	}

	/**
	 * 
	 * @return string
	 */
	public function __toString()
	{
		return $this->render();
	}

}
