<?php

namespace System\Libraries\Database\Query;

class Binding
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

        $keys = (array) $keys;

        if (count($keys) === 0)
        {
            return;
        }

        return array_diff_key($array, array_flip($keys));
    }

}
