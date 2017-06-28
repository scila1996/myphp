<?php

namespace System\Core;

use System\Libraries\Http\Messages\Interfaces\ServerRequestInterface;
use System\Libraries\Http\Messages\Interfaces\ResponseInterface;

class Controller
{

	/** @var \System\Libraries\Http\Messages\Request */
	public $request = null;

	/** @var \System\Libraries\Http\Messages\Response */
	public $response = null;

	/** @var Container */
	public $container = null;

	public function __construct(ServerRequestInterface $request, ResponseInterface $response)
	{
		$this->request = $request;
		$this->response = $response;
		$this->container = new Container();
	}

	final public function __invoke()
	{
		$this->process();
		header("{$this->request->getServerParam("SERVER_PROTOCOL")} {$this->response->getStatusCode()} {$this->response->getReasonPhrase()}");
		foreach ($this->response->getHeaders() as $name => $values)
		{
			foreach ($values as $value)
			{
				header("{$name}: {$value}", false);
			}
		}
		$this->response->getBody()->rewind();
		$this->response->getBody()->write(strval($this->container['view']));
		$this->response->getBody()->rewind();
		echo $this->response->getBody()->getContents();
	}

	protected function process()
	{
		
	}

}
