<?php

namespace App\Models;

use System\Core\Controller;
use System\Core\Model;
use System\Libraries\Database\SQL;
use System\Libraries\Database\Query\Builder;

class Lands extends Model
{

	/** @var \System\Libraries\Database\Query\Builder */
	protected $query = null;

	public function __construct(Controller $controller)
	{
		parent::__construct($controller);
		$this->query = SQL::query()->table('fs_lands');
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
		if ($date !== null)
		{
			$this->query->whereDate('land_date_start', $date);
		}
		return $this;
	}

	/** @return string */
	public function getHtmlTable()
	{
		$table = new Table\LandsTable($this->query, $this->controller->request);
		return $table->toHtml();
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
			'land_date_start' => $this->query->raw('land_date_start + INTERVAL DATEDIFF(?, ?) DAY')
		])->setBindings([$time->new, $time->old]);
		$this->setDate($time->old);
		$r = SQL::execute($this->query);
		return $r;
	}

}
