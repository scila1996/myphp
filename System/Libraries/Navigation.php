<?php

namespace System\Libraries;

class Navigation
{

	private $data = array();

	public function add($title, $uri = '')
	{
		array_push($this->data, (object) array(
					'title' => $title,
					'uri' => $uri
		));
	}

	public function clear()
	{
		$this->data = array();
		return $this;
	}

	public function get()
	{
		$html = '<ol class="breadcrumb">';
		$n = count($this->data) - 1;
		foreach ($this->data as $index => $value)
		{
			if ($index == $n)
			{
				$html .= "<li class=\"active\"> $value->title </li>";
			}
			else
			{
				$html .= "<li><a href=\"$value->uri\"> $value->title </a></li>";
			}
		}
		$html .= '</ol>';
		return $html;
	}

}
