<?php

namespace System\Libraries\Database;

use System\Libraries\Database\Query\Builder;
use System\Libraries\Database\Connectors\Factory;

class DB
{

    /** @var array */
    public static $database = [];

    /** @var self */
    private static $instance = null;

    /** @var Connection */
    private $connect = null;

    protected function __construct()
    {
        $factory = new Factory();
        $connector = $factory->createConnector(self::$database);
        $pdo = $connector->connect(self::$database);
        $this->connect = new Connection($pdo);
    }

    /** @return self */
    public static function getInstance()
    {
        if (self::$instance === null)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /** @return Connection */
    public static function connection()
    {
        return self::getInstance()->connect;
    }

    /** @return integer */
    public static function begin()
    {
        return self::connection()->getPdo()->beginTransaction();
    }

    /** @return integer */
    public static function commit()
    {
        return self::connection()->getPdo()->commit();
    }

    /** @return integer */
    public static function rollback()
    {
        return self::connection()->getPdo()->rollBack();
    }

    /** @return \System\Libraries\Database\Query\Builder */
    public static function query()
    {
        return self::connection()->getBuilder();
    }

    /**
     * 
     * @param Builder $query
     * @param boolean $count
     * @return Collection
     */
    public static function execute(Builder $query, $count = false)
    {
        return self::connection()->query($query, $count);
    }

}
