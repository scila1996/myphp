<?php

namespace System\Database\Interfaces;

use Iterator;

interface ResultInterface extends Iterator
{

	/** @return integer */
	public function getNumRows();

	/** @return mixed */
	public function first();

	/** @return mixed */
	public function fetch();
}
