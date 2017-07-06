<?php

namespace App\Models;

use System\Core\Model;
use System\Libraries\Database\SQL;

class User extends Model
{

	public function table()
	{
		$table = new Table(SQL::query()->table('user'), $this->controller->request);
		$table->setColumns("Mã", "Tên");
		$table->setCallback(function($row) {
			return "<tr><td> {$row->id} </td> <td> {$row->name} </td></tr>";
		});
		return $table->toHtml();
	}

}
