<?php

namespace App\Controllers;

use System\Core\Controller;

class MainCtrl extends Controller
{

	protected function __init()
	{
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
