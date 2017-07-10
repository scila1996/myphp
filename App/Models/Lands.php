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

}
