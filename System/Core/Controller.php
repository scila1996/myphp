<?php

namespace System\Core;

use System\Libraries\Http\Messages\Interfaces\ServerRequestInterface;
use System\Libraries\Http\Messages\Interfaces\ResponseInterface;
use System\Libraries\View;

class Controller
{

	/** @var \System\Libraries\Http\Messages\Request */
	public $request = null;

	/** @var \System\Libraries\Http\Messages\Response */
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
			$data = $this->renderView(View::getAll());
		}
		$this->response->write($data)->getBody()->rewind();
		echo $this->response->getBody()->getContents();
		exit;
	}

	protected function renderView($html)
	{
		return $html;
	}

}

function view()
{
	echo "123";
}