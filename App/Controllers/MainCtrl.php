<?php

namespace App\Controllers;

use System\Core\Controller;
use App\Models\Session;

class MainCtrl extends Controller
{

    /**
     *
     * @var Session
     */
    protected $session = null;

    public function __init()
    {
        $this->session = new Session();
        $this->view->set('main');
        $this->view['admin'] = $this->session->get('login');
        $this->view['title'] = 'Analytic';
        $this->view['url'] = (object) [
                    'lands' => '/view/lands',
                    'members' => '/view/members',
                    'update' => '/update',
                    'logout' => '/logout'
        ];
        $this->view['menu'] = (object) array_fill_keys(array_keys((array) $this->view['url']), null);
    }

}
