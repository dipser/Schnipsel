function &array_merge_recursive_distinct(array &$array1, &$array2 = null)
{
  $merged = $array1;
  
  if (is_array($array2))
    foreach ($array2 as $key => $val)
      if (is_array($array2[$key]))
        $merged[$key] = is_array($merged[$key]) ? array_merge_recursive_distinct($merged[$key], $array2[$key]) : $array2[$key];
      else
        $merged[$key] = $val;
  
  return $merged;
}
