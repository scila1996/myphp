<?php

namespace System\Core;

use System\Libraries\View\View;
use System\Libraries\Http\Messages\Interfaces\ResponseInterface;
use BadMethodCallException;

class Controller
{

	/** @var \System\Libraries\Http\Messages\Request */
	public $request = null;

	/** @var \System\Libraries\Http\Messages\Response */
	public $response = null;

	/** @var View|ResponseInterface */
	public $view = null;

	final public function __call($name, $arguments)
	{

		if (!method_exists($this, $name))
		{
			throw new BadMethodCallException(sprintf("Method \"%s::%s\" is not exists.", get_class($this), $name));
		}

		$ret = call_user_func_array([$this, $name], $arguments);
		$this->__process();

		if ($this->view instanceof View)
		{
			echo $this->view->getContent();
		}
		else if ($this->view instanceof ResponseInterface)
		{
			echo $this->view->getBody();
		}

		return $ret;
	}

	protected function __process()
	{
		return $this;
	}

}
