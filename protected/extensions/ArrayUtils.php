<?php
class ArrayUtils
{
	public function rem_array_obj_obj($array,$str)
	{
		$result = array();
		foreach ($array as $key => $value) 
		{
			if ($value->id != $str->id) 
			{
				$result[] = $value->id;
			}
		}
		return $result;
	}
	
	public function rem_array_obj_id($array,$str)
	{
		$result = array();
		foreach ($array as $key => $value) 
		{
			if ($value->id != $str) 
			{
				$result[] = $value->id;
			}
		}
		return $result;
	}
}	
?>