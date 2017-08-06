<?php

namespace App\Controllers;

use System\Core\Controller;
use App\Models\Users;
use App\Models\Session;

class LoginCtrl extends Controller
{

    /**
     *
     * @var Session
     */
    protected $session = null;

    public function __init()
    {
        $this->session = new Session();
    }

    public function index()
    {
        $this->view->set('login');
        $this->view['message'] = $this->session->splice('message');
    }

    public function submitForm()
    {
        $model = new Users();
        $result = $model->login(
                $this->request->getParam('user'), $this->request->getParam('pass')
        );

        if ($result)
        {
            $this->session->set('login', $result);
        }
        else
        {
            $this->session->set('message', ['type' => 'danger', 'str' => 'Sai tên tài khoản hoặc mật khẩu.']);
        }

        return $this->response->withHeader('Location', $this->request->getUri());
    }

    public function logout()
    {
        $this->session->delete('login');
        return $this->response->withHeader('Location', '/login');
    }

}
