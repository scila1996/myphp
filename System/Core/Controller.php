<?php

namespace System\Core;

use System\Libraries\Http\Interfaces\ServerRequestInterface;
use System\Libraries\Http\Interfaces\ResponseInterface;
use System\Libraries\View;

class Controller
{

	/** @var \System\Libraries\Http\Request */
	public $request = null;

	/** @var \System\Libraries\Http\Response */
	public $response = null;

	public function __construct(ServerRequestInterface $request, ResponseInterface $response)
	{
		$this->request = $request;
		$this->response = $response;
	}

	final public function __invoke($data = NULL)
	{
		header("{$this->request->getServerParam("SERVER_PROTOCOL")} {$this->response->getStatusCode()} {$this->response->getReasonPhrase()}");
		foreach ($this->response->getHeaders() as $name => $values)
		{
			foreach ($values as $value)
			{
				header("{$name}: {$value}", false);
			}
		}
		if ($data === NULL)
		{
			$data = $this->output(View::getAll());
		}
		$this->response->getBody()->write($data);
		$this->response->getBody()->rewind();
		echo $this->response->getBody()->getContents();
		exit;
	}

	protected function output($html)
	{
		return $html;
	}

}
