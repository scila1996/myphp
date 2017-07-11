<?php

namespace App\Controllers;

use App\Models\Lands;
use DateInterval;
use DateTime;
use System\Libraries\Database\SQL;
use PDO;

class Home extends MainCtrl
{

	protected function index()
	{
		echo SQL::connection()->getPDO()->getAttribute(PDO::ATTR_AUTOCOMMIT);
		$this->view['content'] = $this->view->template('home');
	}

	protected function viewArticle($type = 'cms')
	{
		$this->view['menu']->{$type} = 'active';
		$table = new Lands($this);
		$table->setType($type);
		$table->setDate($this->request->getQueryParam('date', null));
		$this->view['content'] = $this->view->template('analytic');
		$this->view['content']['table'] = $table->getHtmlTable();
	}

	protected function updateArticle()
	{
		$this->view['menu']->update = 'active';
		$this->view['content'] = $this->view->template('update', [
			'old' => (new DateTime())->sub(new DateInterval('P5D'))->format('Y-m-d'),
			'new' => (new DateTime())->format('Y-m-d')
		]);
	}

	protected function countArticleByDay()
	{
		return $this->response->withJson(["data" => "php", "var" => 5])->getBody();
	}

	protected function processUpdateArticle()
	{
		$land = new Lands($this);
		$this->view['content'] = $land->test();
	}

}
