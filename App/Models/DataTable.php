<?php

namespace App\Models;

use System\Libraries\Database\DB;
use System\Libraries\Http\Messages\Request;

abstract class DataTable
{

    /** @var \System\Libraries\Database\Query\Builder */
    protected $query = null;

    /** @var Request */
    protected $ajax = [];

    public function __construct(Request $request, $table)
    {
        $this->query = DB::query()->table($table);
        $this->ajax = $request;
        $this->query->limit($request->getQueryParam('length'));
        $this->query->offset($request->getQueryParam('start'));
    }

    /**
     * 
     * @param type $map
     * @return $this
     */
    public function sort($map)
    {
        foreach ($this->ajax->getQueryParam('order') as $order)
        {
            $this->query->orderBy($map[$order['column']], $order['dir']);
        }

        return $this;
    }

    /**
     * 
     * @return \System\Libraries\Database\Query\Builder
     */
    public function query()
    {
        return $this->query;
    }

    /**
     * 
     * @return \System\Libraries\Database\Collection
     */
    public function get()
    {
        $data = DB::execute($this->query, true);
        $no = $this->ajax->getQueryParam('start') + 1;

        return [
            "data" => array_map(function ($row) use (&$no) {
                        return $this->rowData($no++, $row);
                    }, iterator_to_array($data, false)),
            "recordsTotal" => $data->getNumRows(),
            "recordsFiltered" => $data->getNumRows(),
        ];
    }

    /**
     * 
     * @return integer
     */
    public function exec()
    {
        return DB::execute($this->query);
    }

    /**
     * @param integer $number_order
     * @param \stdClass $rowObj
     * @return array
     */
    abstract public function rowData($number_order, $rowObj);
}
