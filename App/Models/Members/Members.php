<?php

namespace App\Models\Members;

use System\Core\Model;

class Members extends Model
{

    public function getDataTable()
    {
        $datatable = new DataTable($this->controller->request);
        return $datatable->findMembersByUserName()->sort()->get();
    }

}
