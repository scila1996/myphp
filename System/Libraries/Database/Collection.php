<?php

namespace System\Libraries\Database;

use System\Libraries\Database\Interfaces\CollectionInterface;
use PDOStatement;

class Collection implements CollectionInterface
{

	/** @var PDOStatement */
	private $pdoStmt = null;

	/** @var array */
	private $columns = [];

	/** @var integer */
	private $numRows = null;

	/** @var \stdClass */
	private $row = null;

	/** @var \stdClass */
	private $firstRow = null;

	/** @var integer */
	private $key = 1;

	/** @return void */
	protected function getColumnsFromPdoStmt()
	{
		for ($i = 0; $i < $this->pdoStmt->columnCount();)
		{
			$this->columns[] = $this->pdoStmt->getColumnMeta($i++);
		}
		return;
	}

	public function __construct(PDOStatement $stmt, $numRows = null)
	{
		$this->pdoStmt = $stmt;
		$this->numRows = $numRows === null ? $stmt->rowCount() : $numRows;
		$this->getColumnsFromPdoStmt();
		$this->next();
	}

	/** @return \stdClass */
	public function first()
	{
		return $this->firstRow;
	}

	/** @return \stdClass */
	public function fetch()
	{
		$r = $this->current();
		$this->next();
		return $r;
	}

	/** @return \stdClass */
	public function current()
	{
		return $this->row;
	}

	/** @return integer */
	public function key()
	{
		return $this->key;
	}

	/** @return void */
	public function next()
	{
		$this->row = $this->pdoStmt->fetchObject();
		if ($this->row !== FALSE)
		{
			$this->key += 1;
			if ($this->firstRow === null)
			{
				$this->firstRow = $this->row;
			}
		}
		else
		{
			$this->pdoStmt->closeCursor();
		}
	}

	/** @return void */
	public function rewind()
	{
		return;
	}

	/** @return boolean */
	public function valid()
	{
		return $this->row === FALSE ? FALSE : TRUE;
	}

	/** @return integer */
	public function getNumRows()
	{
		return $this->numRows;
	}

	/** @return array */
	public function getColumns()
	{
		return $this->columns;
	}

	public function count()
	{
		return $this->getNumRows();
	}

}
