<?php

namespace App\Models\Lands;

use System\Core\Model;
use DateTime;

class Lands extends Model
{

	/**
	 * 
	 * @return \System\Libraries\Database\Collection
	 */
	public function getDataTable()
	{
		$datatable = new DataTable($this->controller->request);
		$datatable->sort()->findDate()->findTitle()->findMemberType();
		$data = $datatable->get();
		$no = $this->controller->request->getQueryParam('start') + 1;

		return [
			"data" => array_map(function ($row) use (&$no) {
						return [
							$no++,
							["link" => "https://chobatdongsan.com.vn/d{$row->alias}-{$row->id}.html", "text" => $row->title],
							(new DateTime($row->land_date_start))->format('d/m/Y'),
							$row->poster_name, $row->poster_mobile,
							$row->outweb === null ? 'Quản trị viên' : ($row->poster_id ? 'Thành viên' : 'Khách')
						];
					}, iterator_to_array($data, false)),
			"recordsTotal" => $data->getNumRows(),
			"recordsFiltered" => $data->getNumRows(),
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
