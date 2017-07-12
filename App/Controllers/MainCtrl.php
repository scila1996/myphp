<?php

namespace App\Controllers;

use System\Core\Controller;
use System\Libraries\Http\Messages\Session;

class MainCtrl extends Controller
{

	/**
	 *
	 * @var Session
	 */
	protected $session = null;

	public function __init()
	{
		Session::start();
		$this->session = new Session('iland');
		$this->view->set('main');
		$this->view['title'] = 'Analytic';
		$this->view['url'] = (object) [
					'customer' => '/view/customer',
					'cms' => '/view/cms',
					'update' => '/update'
		];
		$this->view['menu'] = (object) array_fill_keys(array_keys((array) $this->view['url']), null);
	}

}
