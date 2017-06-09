<?php

namespace System\Libraries;

class Pagination
{

	private $total = 1;
	private $page_size = 10;
	private $current_page = 1;
	private $show_page = 5;
	private $last_page = NULL;

	public function __construct($total, $page_size, $current_page)
	{
		$this->total = $total;
		$this->page_size = ($page_size >= $total) ? $total : $page_size;
		$this->current_page = $current_page;
	}

	private function p_link($page)
	{
		if ($page < 1 or $page > $this->last_page or $page == $this->current_page)
		{
			return 'javascript:void(0)';
		}
		return Request::build_get($_GET, array('page' => $page));
	}

	public function get()
	{
		$html = '<div class="pull-left">';
		$html .= "<p> Showing $this->page_size in $this->total rows </p>";
		$html .= '<div class="form-inline">' .
				'<div class="input-group">' .
				'<span class="input-group-addon"> Số dòng </span>' .
				'<select class="form-control" onchange="window.location.href=' . "'?" . http_build_query(array('psize' => '')) . "' + this.value\">";
		$sizes = array_unique(array(10, 20, 50, 100, $this->total, $this->page_size));
		sort($sizes);
		foreach ($sizes as $size)
		{
			$selected = $size == $this->page_size ? ' selected' : '';
			$html .= "<option value=\"$size\"$selected> $size </option>";
			if ($size == $this->total)
			{
				break;
			}
		}
		$html .= '</select></div></div></div>';
		$html .= '<div class="pull-right">';
		$html .= '<ul class="pagination">';
		$this->last_page = ceil($this->total / ($this->page_size ? $this->page_size : 1));
		if (!$this->last_page)
			$this->last_page = 1;
		if ($this->current_page > $this->last_page)
		{
			throw new Exception\Pagination_InvalidPageNumber('Pager error !');
		}
		$show_left = $this->current_page - intval($this->show_page / 2);
		if ($show_left < 1)
		{
			$show_left = 1;
		}
		$show_right = $this->current_page + intval($this->show_page / 2);
		if ($show_right > $this->last_page)
		{
			$show_right = $this->last_page;
		}
		$link = (object) array(
					'first' => $this->p_link(1),
					'next' => $this->p_link($this->current_page + 1),
					'prev' => $this->p_link($this->current_page - 1),
					'last' => $this->p_link($this->last_page),
		);
		$html .= "<li><a href=\"$link->first\" title=\"First\"><span class=\"fa fa-angle-double-left\"></span> </a></li>"; // first
		$html .= "<li><a href=\"$link->prev\" title=\"Previous\"><span class=\"fa fa-angle-left\"></span></a></li>"; // prev
		for ($i = $show_left; $i <= $show_right; $i++)
		{
			$active = $i == $this->current_page ? ' class="active"' : '';
			$addr = $this->p_link($i);
			$html .= "<li$active><a href=\"$addr\"> $i </a></li>";
		}
		$html .= "<li><a href=\"$link->next\" title=\"Next\"><span class=\"fa fa-angle-right\"></span></a></li>"; // next
		$html .= "<li><a href=\"$link->last\" title=\"Last\"><span class=\"fa fa-angle-double-right\"></span></a></li>"; // last
		$html .= '</ul>';
		$html .= '</div>';
		$html .= '<div class="clearfix"></div>';
		return $html;
	}

}
