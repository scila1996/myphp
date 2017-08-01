<?php

namespace App\Models\Lands;

use System\Libraries\Http\Messages\Request;
use System\Libraries\Database\Query\Builder;
use DateTime;

class DataTable extends \App\Models\DataTable
{

    /**
     * 
     * @param Request $ajax
     */
    public function __construct(Request $ajax)
    {
        parent::__construct($ajax, 'fs_lands');
    }

    /** @return $this */
    public function findMemberType()
    {
        switch ($this->ajax->getQueryParam('columns')[5]['search']['value'])
        {
            case "1":
                $this->query->where('outweb', 1)->where(function (Builder $where) {
                    $where->where('poster_id', 0)->orWhereNull('poster_id');
                });
                break;
            case "2":
                $this->query->where(function(Builder $where) {
                    $where->where('outweb', 1)->whereNotNull('poster_id')->where('poster_id', '!=', 0);
                });
                break;
            case "3":
                $this->query->whereNull('outweb');
                break;
        }
        return $this;
    }

    /** @return $this */
    public function findDate()
    {
        $date = $this->ajax->getQueryParam('columns')[2]['search']['value'];
        if ($date)
        {
            $this->query->whereDate('land_date_start', $date);
        }
        return $this;
    }

    /** @return $this */
    public function findTitle()
    {
        $title = $this->ajax->getQueryParam('search')['value'];
        if ($title)
        {
            $this->query->where('title', 'like', "%{$title}%");
        }
        return $this;
    }

    public function sort($map = [
        "0" => "id",
        "1" => "title",
        "2" => "land_date_start"
    ])
    {
        return parent::sort($map);
    }

    public function rowData($number_order, $rowObj)
    {

        return [
            $number_order,
            [
                "link" => "https://chobatdongsan.com.vn/d{$rowObj->alias}-{$rowObj->id}.html",
                "text" => $rowObj->title
            ],
            [
                "start" => (new DateTime($rowObj->land_date_start))->format('d/m/Y'),
                "finish" => (new DateTime($rowObj->land_date_finish))->format('d/m/Y'),
            ],
            $rowObj->poster_name, $rowObj->poster_mobile,
            $rowObj->outweb === null ? 'Quản trị viên' : ($rowObj->poster_id ? 'Thành viên' : 'Khách')
        ];
    }

}
