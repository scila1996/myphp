<?php

namespace System\Database\Interfaces;

interface DatabaseInterface
{

	/** @var Traversable */
	public function rawQuery();

	/** @var boolean */
	public function begin();

	/** @var boolean */
	public function commit();

	/** @var boolean */
	public function rollback();

	/** @var Traversable */
	public function query($query_str, $param = NULL);

	/** @var integer */
	public function getAffectedRows();
}
