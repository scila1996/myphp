<?php

namespace App\Controllers;

use App\Models\Lands\Lands;
use DateInterval;
use DateTime;

class HomeCtrl extends MainCtrl
{

	public function index()
	{
		$this->view['content'] = $this->view->template('home');
	}

	public function viewArticle($type = 'cms')
	{
		$this->view['menu']->{$type} = 'active';
		$this->view['content'] = $this->view->template('analytic');
	}

	public function updateArticle()
	{
		$this->view['menu']->update = 'active';
		$this->view['content'] = $this->view->template('update', [
			'old' => (new DateTime())->sub(new DateInterval('P5D'))->format('Y-m-d'),
			'new' => (new DateTime())->format('Y-m-d'),
			'message' => $this->session->splice('message')
		]);
	}

	/**
	 * 
	 * @return \System\Libraries\Http\Messages\Response
	 */
	public function countArticleByDay()
	{
		//return $this->response->withJson($this->request->getQueryParam('type'));
		$land = new Lands($this);
		$land->setDate($this->request->getQueryParam('old'));
		$land->setType($this->request->getQueryParam('type', []));
		return $this->response->withJson($land->countByDay());
	}

	public function processUpdateArticle()
	{
		$land = new Lands($this);
		if ($land->updateLands(
						$this->request->getParam('old'), $this->request->getParam('new')
				))
		{
			$this->session->set('message', ["type" => "success", "str" => "Đã cập nhật thành công"]);
		}
		else
		{
			$this->session->set('message', ["type" => "info", "str" => "Không có tin nào để cập nhật"]);
		}
		return $this->response->withHeader('Location', $this->request->getUri()->getPath());
	}

	public function ajaxTable()
	{
		return $this->response->withJson((new Lands($this))->getDataTable());
	}

	public function logout()
	{
		$this->session->delete('login');
		return $this->response->withHeader('Location', '/login');
	}

}
