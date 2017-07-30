<?php

namespace System\Libraries\Router;

/**
 * Interface RouteDataInterface
 * @package System\Libraries\Router
 */
interface RouteDataInterface
{

    /**
     * @return array
     */
    public function getStaticRoutes();

    /**
     * @return array
     */
    public function getVariableRoutes();

    /**
     * @return array
     */
    public function getFilters();
}
