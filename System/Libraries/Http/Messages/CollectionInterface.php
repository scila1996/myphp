<?php

namespace System\Libraries\Http\Messages;

interface CollectionInterface extends \ArrayAccess, \Countable, \IteratorAggregate
{

    public function set($key, $value);

    public function get($key, $default = null);

    public function replace(array $items);

    public function all();

    public function has($key);

    public function remove($key);

    public function clear();
}
