<?php

namespace App\Models\Lands;

use System\Core\Controller;
use System\Core\Model;
use System\Libraries\Database\DB;
use System\Libraries\Database\Query\Builder;
use DateTime;

class Lands extends Model
{

	/**
	 * 
	 * @return \System\Libraries\Database\Collection
	 */
	public function getDataTable($type)
	{
		$datatable = new DataTable();
		$datatable->length($this->controller->request->getQueryParam('length'));
		$datatable->sort($this->controller->request->getQueryParam('order')[0]["column"], $this->controller->request->getQueryParam('order')[0]["dir"]);
		$datatable->findByMemberType($type == "cms" ? 1 : null);
		$datatable->findByTitle($this->controller->request->getQueryParam('search')['value']);
		$datatable->findByDate($this->controller->request->getQueryParam('columns')[2]['search']['value']);

		$data = $datatable->get();
		$no = $this->controller->request->getQueryParam('start') + 1;

		return [
			"data" => array_map(function ($row) use (&$no) {
						return [
							$no++, "<a href=\"https://chobatdongsan.com.vn/d{$row->alias}-{$row->id}.html\" target=\"_blank\"> {$row->title} <a/>", (new DateTime($row->land_date_start))->format('d/m/Y'), $row->poster_name, $row->poster_mobile
						];
					}, iterator_to_array($data, false)),
			"recordsTotal" => $data->getNumRows(),
			"recordsFiltered" => $data->getNumRows()
		];
	}

	/**
	 * 
	 * @param string $day
	 * @return integer
	 */
	public function countByDay()
	{
		return DB::execute($this->query->count())->fetch()->aggregate;
	}

	/**
	 * 
	 * @return integer
	 */
	public function updateLands($old, $new)
	{
		$time = (object) ['old' => $old, 'new' => $new];
		$this->query->update([
			'land_date_start' => $this->query->raw('land_date_start + INTERVAL DATEDIFF(?, ?) DAY'),
			'land_date_finish' => $this->query->raw('land_date_finish + INTERVAL DATEDIFF(?, ?) DAY'),
		])->setBindings([$time->new, $time->old, $time->new, $time->old]);
		$this->setDate($time->old);
		return DB::execute($this->query);
	}

}
