<?php

namespace System\Libraries\Database\Interfaces;

interface DatabaseInterface
{

	const MYSQL = "mysql";
	const SQLSRV = "sqlsrv";
	const ODBC = "odbc";
	const SQLITE = "sqlite";
	const PGSQL = "pgsql";

	/** @return boolean */
	public function begin();

	/** @return boolean */
	public function commit();

	/** @return boolean */
	public function rollback();

	/** @return \System\Libraries\Database\Query\Builder */
	public function getBuilder();

	/** @return integer|\Traversable */
	public function query($str, $param = NULL);
}
