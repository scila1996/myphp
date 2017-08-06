<?php

namespace System\Libraries\Database;

use System\Libraries\Database\Interfaces\CollectionInterface;
use PDOStatement;

class Collection implements CollectionInterface
{

    /** @var PDOStatement */
    private $pdo_stmt = null;

    /** @var array */
    private $columns = [];

    /** @var integer */
    private $num_rows = null;

    /** @var \stdClass */
    private $first_row = null;

    /** @var \stdClass */
    private $row = null;

    /** @var integer */
    private $key = 0;

    /** @var string */
    private $class_name = 'stdClass';

    /** @return void */
    protected function getColumnsFromPdoStmt()
    {
        for ($i = 0; $i < $this->pdo_stmt->columnCount();)
        {
            $this->columns[] = $this->pdo_stmt->getColumnMeta($i++);
        }
        return;
    }

    /**
     * 
     * @param PDOStatement $stmt
     * @param integer $numRows
     */
    public function __construct(PDOStatement $stmt, $numRows = null)
    {
        $this->pdo_stmt = $stmt;
        $this->num_rows = $numRows === null ? $stmt->rowCount() : $numRows;
        $this->getColumnsFromPdoStmt();
    }

    /**
     * 
     * @param string $class
     * @return $this
     */
    public function setObjectClass($class)
    {
        $this->class_name = $class;
        return $this;
    }

    /** @return \stdClass */
    public function first()
    {
        if ($this->first_row === null)
        {
            $this->first_row = $this->fetch();
        }
        return $this->first_row;
    }

    /**
     * 
     * @param string $class
     * @return \stdClass
     */
    public function fetch()
    {
        if ($this->valid())
        {
            $this->next();
        }
        return $this->current();
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
        if (($this->row = $this->pdo_stmt->fetchObject($this->class_name)) !== FALSE)
        {
            $this->key += 1;
        }
        else
        {
            $this->pdo_stmt->closeCursor();
        }
    }

    /** @return void */
    public function rewind()
    {
        $this->fetch();
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
    public function getColumns()
    {
        return $this->columns;
    }

    /** @return integer */
    public function count()
    {
        return $this->getNumRows();
    }

}
