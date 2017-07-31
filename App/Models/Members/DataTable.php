<?php

namespace App\Models\Members;

use System\Libraries\Http\Messages\Request;

class DataTable extends \App\Models\DataTable
{

    protected function selectMembers()
    {
        $this->query
                ->select('fs_members.*', $this->query->raw('COUNT(fs_lands.poster_id) as ' . $this->query->grammar->wrap('c')))
                ->join('fs_lands', 'fs_lands.poster_id', '=', 'fs_members.id')
                ->whereNotNull('fs_lands.poster_id')->where('fs_lands.poster_id', '!=', 0)
                ->groupBy('fs_lands.poster_id');
    }

    /**
     * 
     * @param Request $ajax
     */
    public function __construct(Request $ajax)
    {
        parent::__construct($ajax, 'fs_members');
        $this->selectMembers();
    }

    public function findMembersByUserName()
    {
        $this->query->where('username', 'like', "%{$this->ajax->getQueryParam('search')['value']}%");
        return $this;
    }

    public function sort($map = [
        '0' => 'id',
        '1' => 'username',
        '4' => 'c'
    ])
    {
        return parent::sort($map);
    }

    public function rowData($number_order, $rowObj)
    {
        return [
            $number_order, $rowObj->username, $rowObj->poster_name, $rowObj->poster_mobile, $rowObj->c
        ];
    }

}
