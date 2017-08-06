<?php

namespace System\Libraries\View;

use ArrayAccess;
use Exception;
use System\Libraries\View\Exception\FileNotFoundException;

class Template implements ArrayAccess
{

    /** @var string */
    protected $file = '';

    /** @var array */
    protected $data = [];

    /**
     * 
     * @param string $file
     * @param array $data
     * @throws \RuntimeException
     */
    public function __construct($file, $data = [])
    {
        $this->file = $file;
        $this->data = $data;
    }

    /** @return string */
    public function getFilePath()
    {
        return $this->file;
    }

    /* @return array */

    public function getData()
    {
        return $this->data;
    }

    /**
     * 
     * @return string
     */
    public function render()
    {
        foreach ((array) $this->data as $variable => $value)
        {
            $$variable = ($value instanceof self ? $value->render() : $value);
        }

        ob_start();

        try
        {
            eval('?>' . file_get_contents($this->file));
        }
        catch (Exception $ex)
        {
            throw new FileNotFoundException($ex->getMessage(), $ex->getCode());
        }

        return ob_get_clean();
    }

    /**
     * 
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

}
