<?php

namespace App\Controllers;

use System\Core\Controller;
use System\Libraries\Datatable\SQLTable;
use System\Libraries\Database\SQL;

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
		$this->view->set('home');
		$query = SQL::query()->table('category');
		$table = new SQLTable($query);
		$table->getPaginator()->setUrlPattern('/get/(:num)');
		$this->view['table'] = $this->view->template('table', ['data' => $table]);
	}

}
