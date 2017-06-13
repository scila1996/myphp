<?php

namespace System\Libraries\Database\Query;

class Arr
{

	/**
	 * Flatten a multi-dimensional array into a single level.
	 *
	 * @param  array  $array
	 * @param  int  $depth
	 * @return array
	 */
	public static function flatten($array, $depth = INF)
	{
		return array_reduce($array, function ($result, $item) use ($depth) {

			if (!is_array($item))
			{
				return array_merge($result, [$item]);
			}
			elseif ($depth === 1)
			{
				return array_merge($result, array_values($item));
			}
			else
			{
				return array_merge($result, static::flatten($item, $depth - 1));
			}
		}, []);
	}

	/**
	 * Get all of the given array except for a specified array of items.
	 *
	 * @param  array  $array
	 * @param  array|string  $keys
	 * @return array
	 */
	public static function except($array, $keys)
	{
		static::forget($array, $keys);

		return $array;
	}

	/**
	 * Remove one or many array items from a given array using "dot" notation.
	 *
	 * @param  array  $array
	 * @param  array|string  $keys
	 * @return void
	 */
	public static function forget(&$array, $keys)
	{
		$original = &$array;

		$keys = (array) $keys;

		if (count($keys) === 0)
		{
			return;
		}

		foreach ($keys as $key)
		{
			// if the exact key exists in the top-level, remove it
			if (array_key_exists($key, $array))
			{
				unset($array[$key]);

				continue;
			}

			$parts = explode('.', $key);

			// clean up before each pass
			$array = &$original;

			while (count($parts) > 1)
			{
				$part = array_shift($parts);

				if (isset($array[$part]) && is_array($array[$part]))
				{
					$array = &$array[$part];
				}
				else
				{
					continue 2;
				}
			}

			unset($array[array_shift($parts)]);
		}
	}

}
