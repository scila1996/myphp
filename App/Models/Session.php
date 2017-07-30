<?php

namespace App\Models;

use System\Libraries\Http\Messages\Session as SessionLibrary;

class Session extends SessionLibrary
{

    public function __construct()
    {
        self::start();
        parent::__construct('iland');
    }

}
