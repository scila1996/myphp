<?php

namespace System\Database\Interfaces;

use Iterator;

interface CollectionInterface extends Iterator
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
