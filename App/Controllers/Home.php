<?php

namespace App\Controllers;

use System\Core\Controller;
use App\Models\Category;

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
			$this->view['form'] = $this->view->template('form');
		}
	}

	protected function table()
	{
		echo $this->request->getUri()->getPath();
		$this->view->set('home');
		$cmodel = new Category($this);
		$this->view['table'] = $cmodel->table();
	}

}
