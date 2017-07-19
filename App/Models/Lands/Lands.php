<?php

namespace App\Models\Lands;

use System\Core\Controller;
use System\Core\Model;
use System\Libraries\Database\SQL;
use System\Libraries\Database\Query\Builder;
use DateTime;

class Lands extends Model
{

	/** @var \System\Libraries\Database\Query\Builder */
	protected $query = null;

	public function __construct(Controller $controller)
	{
		parent::__construct($controller);
		$this->query = SQL::query()->table('fs_lands'); //->select('id', 'title');
	}

	/**
	 * 
	 * @param string $type
	 * @return $this
	 */
	public function setType($type)
	{
		$type = is_array($type) ? $type : [$type];

		if ($type)
		{
			$this->query->where(function (Builder $where) use ($type) {
				foreach ($type as $t)
				{
					switch ($t)
					{
						case 'customer':
							$where->orWhere('outweb', 1);
							break;
						case 'cms':
							$where->orWhereNull('outweb');
							break;
					}
				}
			});
		}
		return $this;
	}

	/**
	 * 
	 * @param string $date
	 * @return $this
	 */
	public function setDate($date = null)
	{
		if ($date)
		{
			$this->query->whereDate('land_date_start', $date);
		}
		return $this;
	}

	/**
	 * 
	 * @return \System\Libraries\Database\Collection
	 */
	public function getDataTable()
	{
		$this->query->limit($this->controller->request->getQueryParam('length'));
		$this->query->orderBy(
				["0" => "id", "1" => "title", "2" => "land_date_start"]
				[$this->controller->request->getQueryParam('order')[0]["column"]], $this->controller->request->getQueryParam('order')[0]["dir"]
		);
		$this->query->limit($this->controller->request->getQueryParam('length'));
		$this->query->offset($this->controller->request->getQueryParam('start'));

		$this->query->where('title', 'like', "%{$this->controller->request->getQueryParam('search')['value']}%");

		$this->setDate($this->controller->request->getQueryParam('columns')[2]['search']['value']);

		$data = SQL::execute($this->query, true);
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
		return SQL::execute($this->query->count())->fetch()->aggregate;
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
		return SQL::execute($this->query);
	}

}
