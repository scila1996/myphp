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
	 * @param string $str
	 * @param array $data
	 */
	public function __construct($file, array $data = [])
	{
		if (!file_exists($file))
		{
			throw new FileNotExistsException("File '{$file}' is not exists.");
		}
		$this->file = $file;
		$this->data = &$data;
	}

	/** @return string */
	public function render()
	{
		ob_start();
		extract($this->data);
		eval('?>' . file_get_contents($this->file));
		$str = ob_get_contents();
		ob_end_clean();
		return $str;
	}

}
