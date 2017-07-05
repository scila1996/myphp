<?php

namespace App\Models;

use System\Core\Model;
use System\Libraries\Database\SQL;
use System\Libraries\Datatable\SQLTable;

class Category extends Model
{

	public function table()
	{
		$query = SQL::query()->table('category');
		$table = new SQLTable($query, $this->controller->request->getParam('page', 1), 10);
		//$table->getPaginator()->setUrlPattern($urlPattern)
		$table->setColumns(1, 2, 3);
		return $table->toHtml();
	}

}
