<?php

namespace App\Controllers;

use App\Models\Lands\Lands;
use App\Models\Members\Members;
use DateInterval;
use DateTime;

class HomeCtrl extends MainCtrl
{

    public function index()
    {
        $this->view['content'] = $this->view->template('home');
    }

    public function viewArticle()
    {
        $this->view['menu']->lands = 'active';
        $this->view['content'] = $this->view->template('analytic');
    }

    public function viewMembers()
    {
        $this->view['menu']->members = 'active';
        $this->view['content'] = $this->view->template('members');
    }

    public function updateArticle()
    {
        $this->view['menu']->update = 'active';
        $this->view['content'] = $this->view->template('update', [
            'day' => (new DateTime())->sub(new DateInterval('P5D'))->format('Y-m-d'),
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
        if (($result = $land->updateLands()))
        {
            $this->session->set('message', [
                "type" => "success",
                "str" => "Đã cập nhật thành công, có $result tin đã được cập nhật"
            ]);
        }
        else
        {
            $this->session->set('message', ["type" => "info", "str" => "Không có tin nào để cập nhật"]);
        }
        return $this->response->withHeader('Location', $this->request->getUri()->getPath());
    }

    public function ajaxLands()
    {
        return $this->response->withJson((new Lands($this))->getDataTable());
    }

    public function ajaxMembers()
    {
        return $this->response->withJson((new Members($this))->getDataTable());
    }

    public function logout()
    {
        $this->session->delete('login');
        return $this->response->withHeader('Location', '/login');
    }

}
