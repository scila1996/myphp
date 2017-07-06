<?php

namespace App\Controllers;

use System\Core\Controller;
use App\Models\User;
use System\Libraries\Http\Messages\Session;

class Home extends Controller
{

	protected function index($id = null)
	{
		if ($this->request->isPost())
		{
			echo $this->request->getParam('data');
			exit;
		}
		else
		{
			$this->view->set('home');
			$this->view['table'] = $this->view->template('form');
		}
	}

	protected function table()
	{
		$this->view->set('home');
		$user = new User($this);
		$this->view['table'] = $user->table();
	}

	protected function ss($a)
	{
		Session::start();
		$ss = new Session('php');
		switch ($a)
		{
			case 'set':
				$ss->set('a', 10);
				break;
			case 'get':
				echo $ss->get('a', 'no session data');
				break;
			default:
				$ss->delete('a');
				break;
		}
	}

}
