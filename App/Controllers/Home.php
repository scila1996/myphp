<?php

namespace App\Controllers;

use App\Models\Lands;
use System\Libraries\Database\SQL;
use PDO;

class Home extends MainCtrl
{

	protected function index()
	{
		$this->view['content'] = $this->view->template('home');
	}

	protected function viewArticle($type = 'cms')
	{
		$table = new Lands($this);
		$table->setType($type);
		$table->setDate($this->request->getParsedBodyParam('date', null));
		$this->view['content'] = $this->view->template('analytic');
		$this->view['content']['table'] = $table->getHtmlTable();		
	}

}
