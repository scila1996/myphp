<?php

namespace System\Libraries\Database\Interfaces;

use Iterator;
use Countable;

interface CollectionInterface extends Iterator, Countable
{

	/** @return mixed */
	public function first();

	/** @return mixed */
	public function fetch();

	/** @return integer */
	public function getNumRows();

	/** @return array */
	public function getFields();
}
