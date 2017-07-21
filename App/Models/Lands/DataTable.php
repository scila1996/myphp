<?php

namespace App\Models\Lands;

use System\Libraries\Database\DB;
use System\Libraries\Database\Query\Builder;

class DataTable
{

	/** @var \System\Libraries\Database\Query\Builder */
	protected $query = null;

	public function __construct()
	{
		$this->query = DB::query()->table('fs_lands');
	}

	/**
	 * 
	 * @param integer|null $type
	 * @return $this
	 */
	public function findByMemberType($type)
	{
		$this->query->where(function (Builder $where) use ($type) {
			foreach ((array) $type as $t)
			{
				if ($t === null)
				{
					$where->orWhereNull('outweb');
				}
				else
				{
					$where->orWhereNotNull('outweb');
				}
			}
		});
		return $this;
	}

	/**
	 * 
	 * @param string $date
	 * @return $this
	 */
	public function findByDate($date)
	{
		if ($date)
		{
			$this->query->whereDate('land_date_start', $date);
		}
		return $this;
	}

	public function findByTitle($title)
	{
		if ($title)
		{
			$this->query->where('title', 'like', "%{$title}%");
		}
		return $this;
	}

	public function length($n, $o)
	{
		$this->query->limit($n)->offset($o);
		return $this;
	}

	public function sort($col, $dir)
	{
		$map = [
			"0" => "id",
			"1" => "title",
			"2" => "land_date_start"
		];
		$this->query->orderBy($map[strval($col)], $dir);
		return $this;
	}

	/**
	 * 
	 * @return \System\Libraries\Database\Collection
	 */
	public function get()
	{
		return DB::execute($this->query, true);
	}

	/**
	 * 
	 * @return integer
	 */
	public function count()
	{
		return $this->get()->first()->aggregate;
	}

	/**
	 * 
	 * @return integer
	 */
	public function updateDate($old, $new)
	{
		$this->findByDate($old);
		$this->query->update([
			'land_date_start' => $this->query->raw('land_date_start + INTERVAL DATEDIFF(?, ?) DAY'),
			'land_date_finish' => $this->query->raw('land_date_finish + INTERVAL DATEDIFF(?, ?) DAY'),
		]);
		$this->query->setBindings([$new, $old, $new, $old]);
		return DB::execute($this->query);
	}

}
