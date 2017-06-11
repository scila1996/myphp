<?php

namespace System\Core;

use System\Libraries\Http\Interfaces\ServerRequestInterface;
use System\Libraries\Http\Response;
use System\Libraries\View;

class Controller
{

	/** @var System\Libraries\Http\Interfaces\ServerRequestInterface */
	protected $request = null;

	/** @var System\Libraries\Http\Interfaces\ResponseInterface */
	protected $response = null;

	public function __construct(ServerRequestInterface $request)
	{
		$this->request = $request;
		$this->response = new Response();
	}

	final public function __invoke($data = NULL)
	{
		if ($data === NULL)
		{
			$data = $this->output(View::getAll());
		}
		$this->response->getBody()->write($data);
		$this->response->getBody()->rewind();
		http_response_code($this->response->getStatusCode());
		foreach ($this->response->getHeaders() as $name => $values)
		{
			foreach ($values as $value)
			{
				header("{$name}: {$value}", false);
			}
		}
		echo $this->response->getBody()->getContents();
		exit;
	}

	protected function output($html)
	{
		return $html;
	}

}
