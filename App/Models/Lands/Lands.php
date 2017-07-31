<?php

namespace App\Models\Lands;

use System\Core\Model;
use System\Libraries\Database\DB;

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
    public function updateLands($old, $new)
    {
        /*
          $this->findByDate($old);
          $this->query->update([
          'land_date_start' => $this->query->raw('land_date_start + INTERVAL DATEDIFF(?, ?) DAY'),
          'land_date_finish' => $this->query->raw('land_date_finish + INTERVAL DATEDIFF(?, ?) DAY'),
          ]);
          $this->query->setBindings([$new, $old, $new, $old]);
          return $this->exec();
         * 
         */
    }

}
