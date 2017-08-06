<?php

namespace System\Libraries\Database\Interfaces;

use Iterator;
use Countable;

interface CollectionInterface extends Iterator, Countable
{

    /** @return mixed */
    public function first();

    /** @return mixed */
    public function fetch();

    /** @param string $class */
    public function setObjectClass($class);

    /** @return integer */
    public function getNumRows();

    /** @return array */
    public function getColumns();
}
