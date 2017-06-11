<?php

namespace System\Libraries;

class View
{

	private $_file = '';
	private $_data = array();
	public static $path = "";
	public static $data = array();
	private static $list = array();

	private function __construct($file, $data)
	{
		$this->_file = preg_replace('/\/{2,}/', '/', self::$path . '/' . $file);
		$this->_data = $data;
	}

	public static function add($file, $data = array())
	{
		array_push(self::$list, new self($file, $data));
	}

	public static function get($file, $data = array())
	{
		$obj = new self($file, $data);
		return $obj->getHtml();
	}

	public static function getAll()
	{
		$html = "";
		foreach (self::$list as $view)
		{
			$html .= $view->getHtml();
		}
		return $html;
	}

	public function getHtml()
	{
		ob_start();
		$__vars = array_merge(self::$data, $this->_data);
		foreach (array_keys($__vars) as $__name)
		{
			$$__name = &$__vars[$__name];
		}
		$__pattern = '/(\{{2}\s*)([^\{\}]+)(\s*\}{2})/';
		$__replace = "<?php try { echo $2; } catch (\Exception \$e) { echo ''; } ?>";
		eval('?>' . preg_replace($__pattern, $__replace, file_get_contents($this->_file)));
		$str = ob_get_contents();
		ob_end_clean();
		return $str;
	}

}
