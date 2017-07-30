<?php

namespace App\Models\Lands;

use System\Libraries\Http\Messages\Request;
use System\Libraries\Database\Query\Builder;

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

    /**
     * 
     * @return integer
     */
    public function updateDate($old, $new)
    {
        $this->findByDate($old);
        $this->query->update([
            'land_date_start' => $this->query->raw('land_date_start + INTERVAL DATEDIFF(?, ?) DAY'),
            'land_date_finish' => $this->query->raw('land_date_finish + INTERVAL DATEDIFF(?, ?) DAY'),
        ]);
        $this->query->setBindings([$new, $old, $new, $old]);
        return $this->exec();
    }

}
