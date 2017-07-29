<?php

namespace App\Models\Members;

use System\Libraries\Http\Messages\Request;

class DataTable extends \App\Models\DataTable
{

	/**
	 * 
	 * @param Request $ajax
	 */
	public function __construct(Request $ajax)
	{
		parent::__construct($ajax, 'fs_members');
		$this->selectMembers();
	}

	protected function selectMembers()
	{

		/*
		 * SELECT facebook_id, username, COUNT(fs_lands.`poster_id`) AS `c` FROM fs_members
		  JOIN fs_lands ON fs_lands.`poster_id` = `fs_members`.`id`
		  WHERE poster_id IS NOT NULL AND poster_id != 0
		  GROUP BY fs_lands.`poster_id`
		  ORDER BY C DESC
		 */

		$this->query->select();
	}

}
