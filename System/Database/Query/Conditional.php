<?php

namespace System\Database\Query;

class Conditional
{

	private $column = "";
	private $operator = "";
	private $value = "";

	public static function add($column, $operator = null, $value = null)
	{
		$cons = array();
		switch (func_num_args())
		{
			case 1:
				$data = $column;
				if (is_array($data))
				{
					foreach ($data as $k => $v)
					{
						if (is_integer($k) and is_array($v))
						{
							array_push($cons, new Conditional($v[0], $v[1], $v[2]));
						}
						if (is_string($k))
						{
							array_push($cons, new Conditional($k, "=", $v));
						}
					}
				}
				else if (is_string($column))
				break;
			case 2:
				$value = $operator;
				array_push($cons, new Conditional($column, "=", $value));
				break;
			case 3:
				array_push($cons, new Conditional($column, $operator, $value));
				break;
		}
		return $cons;
	}

	public function __construct($column, $operator, $value)
	{
		if (is_string($column))
		{
			$this->column = $column;
		}
		else
		{
			throw new \InvalidArgumentException("column name MUST be a \"string\"");
		}
		if (is_string($operator))
		{
			$this->operator = $operator;
		}
		else
		{
			throw new \InvalidArgumentException("operator name MUST be a \"string\"");
		}
		if (is_string($value) or is_numeric($value) or is_array($value) or is_null($value))
		{
			$this->value = $value;
		}
		else
		{
			throw new \InvalidArgumentException("value MUST be (string, float, integer, boolean, array, NULL)");
		}
	}

}
