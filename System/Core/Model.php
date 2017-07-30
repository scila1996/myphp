<?php

namespace System\Core;

class Model
{

    /**
     *
     * @var Controller
     */
    protected $controller = null;

    public function __construct(Controller $controller)
    {
        $this->controller = $controller;
    }

}
