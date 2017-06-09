<?php

namespace System\Libraries\Routing;

class MiddleWare
{

	private $handler = null;

	public function __construct($handler)
	{
		$this->handler = $handler;
	}

	public function __invoke(Request $request)
	{
		$closure = $this->handler;
		$closure($request);
	}

}
