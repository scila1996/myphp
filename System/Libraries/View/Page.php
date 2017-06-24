<?php

namespace System\Libraries\View;

class Page
{

	/** @var string */
	protected $templateDir = '';

	/** @var string */
	protected $extension = '.php';

	/** @var array */
	protected $templates = [];

	/**
	 * 
	 * @param string $templateDir
	 */
	public function __construct($templateDir = null)
	{
		if ($templateDir === null)
		{
			$templateDir = $_SERVER['DOCUMENT_ROOT'];
		}
		$this->templateDir = $templateDir;
	}

	/**
	 * 
	 * @param string $str
	 * @return $this
	 */
	public function setTemplateDir($str)
	{
		$this->templateDir = $str;
		return $this;
	}

	/**
	 * 
	 * @param string $str
	 * @return $this
	 */
	public function setExtension($str)
	{
		$this->extension = $str;
		return $this;
	}

	/**
	 * 
	 * @param string $file
	 * @param array $data
	 * @return $this
	 */
	public function addTemplate($file, array $data = [])
	{
		$file = $this->templateDir . DIRECTORY_SEPARATOR . $file . $this->extension;
		$this->templates[] = new Template($file, $data);
		return $this;
	}

	/** @return string */
	public function getContent()
	{

		$str = '';
		foreach ($this->templates as $template)
		{
			$str .= $template->render();
		}
		return $str;
	}

}
