<?php

namespace System\Libraries\Database;

use System\Libraries\Database\Interfaces\DatabaseInterface;
use System\Libraries\Database\Query\Builder;
use System\Libraries\Database\Query\Grammars\MySqlGrammar;
use System\Libraries\Database\Query\Grammars\SqlServerGrammar;
use System\Libraries\Database\Query\Grammars\PostgresGrammar;
use System\Libraries\Database\Query\Grammars\SQLiteGrammar;
use PDO;

class Connection implements DatabaseInterface
{

    /**
     *
     * @var PDO
     */
    protected $pdo = null;

    /**
     *
     * @var Builder
     */
    protected $query = null;

    /**
     * 
     * @param string $driver
     * @return Builder
     */
    protected function getQueryBuilder($driver)
    {
        switch ($driver)
        {
            case self::MYSQL:
                return new Builder(new MySqlGrammar());
            case self::SQLSRV:
                return new Builder(new SqlServerGrammar());
            case self::SQLITE:
                return new Builder(new SQLiteGrammar());
            case self::PGSQL:
                return new Builder(new PostgresGrammar());
        }
        return new Builder();
    }

    /**
     * 
     * @param Builder $query
     * @return integer
     */
    protected function getCountQuery(Builder $query)
    {
        $select = clone $query;
        $count = $query->newQuery();

        $select->offset = null;
        $select->limit = null;
        $select->orders = null;

        return intval($this->query($count->count()->from($select, __FUNCTION__), false)->first()->aggregate);
    }

    /**
     * 
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->query = $this->getQueryBuilder($pdo->getAttribute(PDO::ATTR_DRIVER_NAME));
    }

    /**
     * 
     * @param Builder $query
     * @param integer $count
     * @return \System\Libraries\Database\Collection
     */
    public function query(Builder $query, $count = false)
    {
        $stmt = $this->runQuery($query->toSql(), $query->getBindings());

        if ($stmt->columnCount())
        {
            if ($count)
            {
                return new Collection($stmt, $this->getCountQuery($query));
            }
            else
            {
                return new Collection($stmt);
            }
        }
        else
        {
            return $stmt->rowCount();
        }
    }

    /** @return PDO */
    public function getPdo()
    {
        return $this->pdo;
    }

    /** @return Builder */
    public function getBuilder()
    {
        return $this->query;
    }

    /**
     * 
     * @param string $str
     * @param array $param
     * @return \PDOStatement
     */
    public function runQuery($str, array $param = null)
    {
        $stmt = $this->getPdo()->prepare($str);

        if ($param)
        {
            foreach (array_keys($param) as $p => $key)
            {
                $stmt->bindParam($p + 1, $param[$key]);
            }
        }

        $stmt->execute();
        return $stmt;
    }

}
