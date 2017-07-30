<?php

namespace System\Libraries\Database\Connectors;

use InvalidArgumentException;

class Factory
{

    /**
     * Create a connector instance based on the configuration.
     *
     * @param  array  $config
     * @return \System\Libraries\Database\Interfaces\ConnectorInterface
     *
     * @throws \InvalidArgumentException
     */
    public function createConnector(array $config)
    {
        if (!isset($config['driver']))
        {
            throw new InvalidArgumentException('A driver must be specified.');
        }

        switch ($config['driver'])
        {
            case 'mysql':
                return new MySqlConnector;
            case 'pgsql':
                return new PostgresConnector;
            case 'sqlite':
                return new SQLiteConnector;
            case 'sqlsrv':
                return new SqlServerConnector;
        }

        throw new InvalidArgumentException("Unsupported driver [{$config['driver']}]");
    }

}
