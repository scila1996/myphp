<?php

namespace App\Models\Lands;

use System\Core\Model;
use System\Libraries\Database\DB;
use System\Libraries\Database\Query\Builder;

class Lands extends Model
{

    /**
     * 
     * @return \System\Libraries\Database\Collection
     */
    public function getDataTable()
    {
        $datatable = new DataTable($this->controller->request);
        return $datatable->sort()->findDate()->findTitle()->findMemberType()->get();
    }

    /**
     * 
     * @return integer
     */
    public function updateLands()
    {
        $days = $this->controller->request->getParsedBodyParam('day');
        $type = $this->controller->request->getParsedBodyParam('type');
        $add = $this->controller->request->getParsedBodyParam('add');

        $update = DB::query()->table('fs_lands');

        $update->update([
            'land_date_finish' => $update->raw("DATE_ADD(land_date_finish, INTERVAL ? DAY)")
        ]);
        $update->addBinding($add);

        $update->whereRaw('DATE(FROM_UNIXTIME(created_time)) = ?')->addBinding($days);
        
        switch ($type)
        {
            case "1":
                $update->where('outweb', 1)->where(function (Builder $where) {
                    $where->where('poster_id', 0)->orWhereNull('poster_id');
                });
                break;
            case "2":
                $update->where(function(Builder $where) {
                    $where->where('outweb', 1)->whereNotNull('poster_id')->where('poster_id', '!=', 0);
                });
                break;
            case "3":
                $update->whereNull('outweb');
                break;
        }

        return DB::execute($update);
    }

}
