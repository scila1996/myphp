<?php

namespace System\Libraries\Database;

use System\Libraries\Database\Interfaces\CollectionInterface;
use PDOStatement;

class Collection implements CollectionInterface
{

	/** @var PDOStatement */
	private $pdo_stmt = NULL;

	/** @var array */
	private $fields = array();

	/** @var integer */
	private $num_rows = NULL;

	/** @var \stdClass */
	private $row = NULL;

	/** @var \stdClass */
	private $first_row = NULL;

	/** @var integer */
	private $key = 1;

	private function _fields()
	{
		for ($i = 0; $i < $this->pdo_stmt->columnCount(); $i++)
		{
			$field = $this->pdo_stmt->getColumnMeta($i);
			if ($field)
			{
				array_push($this->fields, $field["name"]);
			}
		}
	}

	public function __construct(PDOStatement $stmt, $num_rows = null)
	{
		$this->pdo_stmt = $stmt;
		$this->num_rows = $num_rows === null ? $stmt->rowCount() : $num_rows;
		$this->_fields();
		$this->next();
	}

	/** @return \stdClass */
	public function first()
	{
		return $this->first_row;
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
		$this->row = $this->pdo_stmt->fetchObject();
		if ($this->row !== FALSE)
		{
			$this->key += 1;
			if ($this->first_row === NULL)
			{
				$this->first_row = $this->row;
			}
		}
		else
		{
			$this->pdo_stmt->closeCursor();
		}
	}

	/** @return void */
	public function rewind()
	{
		// Not Available */
	}

	/** @return boolean */
	public function valid()
	{
		return $this->row === FALSE ? FALSE : TRUE;
	}

	/** @return integer */
	public function getNumRows()
	{
		return $this->num_rows;
	}

	/** @return array */
	public function getFields()
	{
		return $this->fields;
	}

}
