<?php

namespace App\Models\Lands;

use System\Core\Model;
use System\Libraries\Database\DB;
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
		$datatable->length($this->controller->request->getQueryParam('length'), $this->controller->request->getQueryParam('start'));
		$datatable->sort($this->controller->request->getQueryParam('order')[0]["column"], $this->controller->request->getQueryParam('order')[0]["dir"]);
		$datatable->findByMemberType($type == "cms" ? null : 1);
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
		return (new DataTable())->findByDate($this->controller->request->getParsedBodyParam('date'))->count();
	}

	/**
	 * 
	 * @return integer
	 */
	public function updateLands($old, $new)
	{
		return (new DataTable())->updateDate($old, $new);
	}

}
