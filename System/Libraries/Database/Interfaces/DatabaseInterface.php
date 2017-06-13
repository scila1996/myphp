<?php

namespace System\Libraries\Database\Interfaces;

interface DatabaseInterface
{

	const MYSQL = "mysql";
	const SQLSRV = "sqlsrv";
	const ODBC = "odbc";
	const SQLITE = "sqlite";
	const PGSQL = "pgsql";

	/** @var boolean */
	public function begin();

	/** @var boolean */
	public function commit();

	/** @var boolean */
	public function rollback();

	public function getBuilder();

	/** @var integer|\Traversable */
	public function query($str, $param = NULL);
}
