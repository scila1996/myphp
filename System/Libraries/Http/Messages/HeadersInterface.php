<?php

namespace System\Libraries\Http\Messages;

interface HeadersInterface extends CollectionInterface
{

    public function add($key, $value);

    public function normalizeKey($key);
}
