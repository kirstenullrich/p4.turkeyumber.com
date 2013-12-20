<?php
class Map {

	public static function super_unique($array) {
	  $result = array_map("unserialize", array_unique(array_map("serialize", $array)));

	  foreach ($result as $key => $value) {
	    if ( is_array($value) ) {
	      $result[$key] = array_unique($value);
	    }
	  }

	  return $result;
	}
}
?>