<?php

namespace System\Core;

use ArrayObject;

class Container extends ArrayObject
{

	public function __construct()
	{
		parent::__construct([]);
	}

}
