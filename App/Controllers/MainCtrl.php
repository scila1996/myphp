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
					'cms' => '/view/cms'
		];
	}

}
