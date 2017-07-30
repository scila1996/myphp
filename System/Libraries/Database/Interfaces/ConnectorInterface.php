<?php

namespace System\Libraries\Database\Interfaces;

interface ConnectorInterface
{

    /**
     * Establish a database connection.
     *
     * @param  array  $config
     * @return \PDO
     */
    public function connect(array $config);
}
