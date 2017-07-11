<?php

namespace System\Core;

use System\Libraries\View\View;
use BadMethodCallException;

class Controller
{

	/** @var \System\Libraries\Http\Messages\Request */
	public $request = null;

	/** @var \System\Libraries\Http\Messages\Response */
	public $response = null;

	/** @var View */
	public $view = null;

	final public function __call($name, $arguments)
	{

		if (!method_exists($this, $name))
		{
			throw new BadMethodCallException(sprintf("Method <b>[%s::%s]</b> does not exists.", get_class($this), $name));
		}

		$this->__init();
		$ret = call_user_func_array([$this, $name], $arguments);
		$this->__process();

		if ($ret)
		{
			return $ret;
		}
		if ($this->view instanceof View)
		{
			return $this->view->getContent();
		}
	}

	protected function __init()
	{
		return $this;
	}

	protected function __process()
	{
		return $this;
	}

}
