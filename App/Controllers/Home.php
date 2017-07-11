<?php

namespace App\Controllers;

use App\Models\Lands;
use DateInterval;
use DateTime;

class Home extends MainCtrl
{

	public function index()
	{
		$this->view['content'] = $this->view->template('home');
	}

	public function viewArticle($type = 'cms')
	{
		$this->view['menu']->{$type} = 'active';
		$table = new Lands($this);
		$table->setType($type);
		$table->setDate($this->request->getQueryParam('date', null));
		$this->view['content'] = $this->view->template('analytic');
		$this->view['content']['table'] = $table->getHtmlTable();
	}

	public function updateArticle()
	{
		$this->view['menu']->update = 'active';
		$this->view['content'] = $this->view->template('update', [
			'old' => (new DateTime())->sub(new DateInterval('P5D'))->format('Y-m-d'),
			'new' => (new DateTime())->format('Y-m-d')
		]);
	}

	/**
	 * 
	 * @return \System\Libraries\Http\Messages\Response
	 */
	public function countArticleByDay()
	{
		$land = new Lands($this);
		$land->setDate($this->request->getParsedBodyParam('old'));
		$land->setType($this->request->getParsedBodyParam('type'));
		return $this->response->withJson($land->countByDay());
	}

	public function processUpdateArticle()
	{
		$land = new Lands($this);
		$this->view['content'] = $land->test();
	}

}
