<?php

namespace System\Database;

use System\Database\Interfaces\ResultInterface;
use PDOStatement;

class Result implements ResultInterface
{

	/** @var PDOStatement */
	private $pdo_stmt = NULL;

	/** @var integer */
	private $num_rows = NULL;

	/** @var mixed */
	private $row = NULL;

	/** @var mixed */
	private $key = -1;

	public function __construct(PDOStatement $stmt, $num_rows)
	{
		$this->pdo_stmt = $stmt;
		$this->num_rows = $num_rows;
		$this->next();
	}

	public function first()
	{
		$this->rewind();
		return $this->current();
	}

	public function getNumRows()
	{
		return $this->num_rows;
	}

	public function fetch()
	{
		$r = $this->current();
		$this->next();
		return $r;
	}

	public function current()
	{
		return $this->row;
	}

	public function key()
	{
		return $this->key;
	}

	public function next()
	{
		if ($this->row = $this->pdo_stmt->fetchObject())
		{
			$this->key += 1;
		}
		else
		{
			$this->pdo_stmt->closeCursor();
		}
	}

	public function rewind()
	{
		$this->pdo_stmt->execute();
		$this->next();
	}

	public function valid()
	{
		return $this->row === FALSE ? FALSE : TRUE;
	}

}
