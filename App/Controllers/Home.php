<?php

namespace App\Controllers;

use App\Models\Lands;
use DateInterval;
use DateTime;
use System\Libraries\Database\SQL;

class Home extends MainCtrl
{

	protected function index()
	{
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

	protected function processUpdateArticle()
	{
		$old = $this->request->getParam('old');
		$new = $this->request->getParam('new');
		$query = SQL::query()->table('fs_lands');
		$query->update([
			'land_date_start' => $query->raw('land_date_start + INTERVAL DATEDIFF(?, ?) DAY')
		])->setBindings([$new, $old])->whereDate('land_date_start', $old);
		echo "{$query->toSql()} <br />";
		var_dump($query->getRawBindings());
		exit;
	}

}
