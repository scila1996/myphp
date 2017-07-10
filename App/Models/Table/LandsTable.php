<?php

namespace App\Models\Table;

class LandsTable extends Table
{

	/**
	 * 
	 * @return array
	 */
	public function getColumns()
	{
		return ["No.", "Tiêu đề", "Người đăng", "Phone"];
	}

	/**
	 * 
	 * @param object $row
	 * @return string
	 */
	public function renderRow($row, $n)
	{
		return <<<row
<tr>
<td> {$n} </td>
<td> {$row->title} </td>
<td> {$row->poster_name} </td>
<td> {$row->poster_mobile} </td>
</tr>
row;
	}

}
