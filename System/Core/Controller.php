<?php

namespace System\Core;

use System\Core\Container;

/**
 * @property-read \System\Libraries\Http\Messages\Request $request
 * @property-read \System\Libraries\Http\Messages\Response $response
 * @property-read View $view
 */
class Controller
{

    /** @var \System\Libraries\Http\Messages\Request */
    protected $request = null;

    /** @var \System\Libraries\Http\Messages\Response */
    protected $response = null;

    /** @var \System\Libraries\View\View */
    protected $view = null;

    /**
     * 
     * @param Container $container
     */
    final public function __construct(Container $container)
    {
        foreach ($container as $prop => $obj)
        {
            $this->{$prop} = $obj;
        }
    }

    /**
     * 
     * @param string $name
     * @return mixed
     */
    final public function __get($name)
    {
        return isset($this->{$name}) ? $this->{$name} : null;
    }

    /**
     * This method can override.
     * 
     * @return $this
     */
    public function __init()
    {
        return $this;
    }

    /**
     * 
     * @param string $link
     * @param object|array $params
     * @return \System\Libraries\Http\Messages\Response
     */
    protected function redirect($link, $params = null)
    {
        if ($params !== null)
        {
            $link .= '?' . http_build_query($params);
        }
        return $this->response = $this->response->withHeader('Location', $link);
    }

}
