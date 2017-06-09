<?php

namespace System\Database\Interfaces;

interface DatabaseInterface
{

	public function __construct($db);

	/** @var Traversable */
	public function rawQuery();

	/** @var boolean */
	public function begin();

	/** @var boolean */
	public function commit();

	/** @var boolean */
	public function rollback();

	/** @var QueryInterface */
	public function query($query_str, $param = NULL);

	/** @var integer */
	public function getAffectedRows();
}
