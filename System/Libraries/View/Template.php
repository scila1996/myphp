<?php

namespace System\Libraries\View;

use ArrayAccess;

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
        ob_start();

        foreach ((array) $this->data as $variable => $value)
        {
            $$variable = ($value instanceof self ? $value->render() : $value);
        }

        eval('?>' . file_get_contents($this->file));
        $str = ob_get_contents();
        ob_end_clean();
        return $str;
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
