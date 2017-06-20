<?php

namespace System\Libraries\View;

class Layout
{

	/**
	 *
	 * @var string
	 */
	private $file = '';

	/**
	 *
	 * @var array
	 */
	private $data = array();

	/**
	 * 
	 * @param string $file
	 * @param array $data
	 */
	public function __construct($file, $data)
	{
		$this->file = $file;
		$this->data = $data;
	}

	/**
	 * 
	 * @return string
	 */
	public function getText()
	{
		ob_start();
		foreach (array_keys($this->data) as $__name)
		{
			$$__name = &$this->data[$__name];
		}
		$pattern = '/(\{{2}\s*)([^\{\}]+)(\s*\}{2})/';
		$replace = "<?php try { echo $2; } catch (\Exception \$e) { echo ''; } ?>";
		eval('?>' . preg_replace($pattern, $replace, file_get_contents($this->_file)));
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
		return $this->getText();
	}

}
