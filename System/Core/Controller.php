<?php

namespace System\Core;

use BadMethodCallException;

class Controller
{

	/** @var \System\Libraries\Http\Messages\Request */
	public $request = null;

	/** @var \System\Libraries\Http\Messages\Response */
	public $response = null;

	/** @var Container */
	public $container = null;

	/** @var string */
	private $__method = '';

	public function __construct()
	{
		$this->container = new Container();
	}

	final public function __invoke()
	{
		call_user_func_array([$this, $this->__method['method']], $this->__method['args']);
		$this->process();

		/*
		  header("{$this->request->getServerParam("SERVER_PROTOCOL")} {$this->response->getStatusCode()} {$this->response->getReasonPhrase()}");
		  foreach ($this->response->getHeaders() as $name => $values)
		  {
		  foreach ($values as $value)
		  {
		  header("{$name}: {$value}", false);
		  }
		  }
		 */

		$this->response->getBody()->rewind();
		$this->response->getBody()->write(strval($this->container['view']));
		$this->response->getBody()->rewind();
		echo $this->response->getBody()->getContents();
	}

	public function __call($name, $arguments)
	{
		if (!method_exists($this, $name))
		{
			throw new BadMethodCallException(sprintf("Method \"%s::%s\" is not exists.", get_class($this), $name));
		}
		$this->__method = ['method' => $name, 'args' => $arguments];
		return $this;
	}

	protected function process()
	{
		
	}

}
