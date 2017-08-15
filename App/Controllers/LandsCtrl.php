<?php

namespace App\Controllers;

use System\Core\Controller;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class LandsCtrl extends Controller
{

    public function __init()
    {
        require_once 'App/Package/Goutte/vendor/autoload.php';
    }

    public function index()
    {
        $this->view->set('lands/page');
    }

    public function getHtml($page)
    {
        $client = new Client();
        $data = $client->request('GET', "https://chobatdongsan.com.vn/nha-dat-ban/p{$page}");
        $data->filter('[onerror]')->each(function(Crawler $node) {
            $node->getNode(0)->setAttribute('onerror', "this.src='https://chobatdongsan.com.vn/images/config/_1502436069.png'");
        });
        return $data->filter('#form1 > div.col-lg-9.col-content-bgs.content-bds-video.cf')->html();
    }

}
