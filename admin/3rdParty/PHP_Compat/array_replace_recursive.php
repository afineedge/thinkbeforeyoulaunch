<?php

// original from: http://www.php.net/manual/en/function.array-replace-recursive.php#92574

function php_compat_array_replace_recursive($array, $array1)
{
  function php_compat_array_replace_recursive_($array, $array1)
  {
    foreach ($array1 as $key => $value)
    {
      // create new key in $array, if it is empty or not an array
      if (!isset($array[$key]) || (isset($array[$key]) && !is_array($array[$key])))
      {
        $array[$key] = array();
      }

      // overwrite the value in the base array
      if (is_array($value))
      {
        $value = php_compat_array_replace_recursive_($array[$key], $value);
      }
      $array[$key] = $value;
    }
    return $array;
  }

  // handle the arguments, merge one by one
  $args = func_get_args();
  $array = $args[0];
  if (!is_array($array))
  {
    return $array;
  }
  for ($i = 1; $i < count($args); $i++)
  {
    if (is_array($args[$i]))
    {
      $array = php_compat_array_replace_recursive_($array, $args[$i]);
    }
  }
  return $array;
}

// Define
if (!function_exists('array_replace_recursive')) {
    function array_replace_recursive($array)
    {
        return php_compat_array_replace_recursive($array);
    }
}
