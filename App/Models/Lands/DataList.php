<?php

namespace App\Models\Lands;

use System\Core\Model;
use System\Libraries\Database\DB;

class DataList extends Model
{

    public function get()
    {
        $query = DB::query()
                ->table('fs_lands')
                ->limit(25)
                ->where([
                    ['title', '!=', ''],
                    ['published', '=', 1]
                ])
                ->orderBy('created_time', 'desc');
        return DB::execute($query);
    }

}
