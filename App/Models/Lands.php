<?php

namespace App\Models;

use System\Core\Controller;
use System\Core\Model;
use System\Libraries\Database\SQL;

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
		switch ($type)
		{
			case 'customer':
				$this->query->where('outweb', 1);
				break;
			case 'cms':
				$this->query->whereNull('outweb');
				break;
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
	public function countByDay($day)
	{
		$this->setDate($day);
		return SQL::execute($this->query->count())->fetch()->arregate;
	}

	/**
	 * 
	 * @return integer
	 */
	public function updateLands()
	{
		SQL::begin();
		$time = (object) [
					'old' => $this->controller->request->getParam('old'),
					'new' => $this->controller->request->getParam('new')
		];
		$this->query->update([
			'land_date_start' => $this->query->raw('land_date_start + INTERVAL DATEDIFF(?, ?) DAY')
		])->setBindings([$time->new, $time->old]);
		$this->setDate($time->old);
		$r = SQL::execute($this->query);
		return $r;
	}

}
