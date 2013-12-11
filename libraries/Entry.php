<?php

class Entry {
	
	public static function get_entries_by_trip($trip_id) {
	
		$q = 'SELECT *
			FROM entries
			WHERE trip_id = '.$trip_id;
		
		$entries = DB::instance(DB_NAME)->select_rows($q);
		
		return $entries;
		
	}

} # end class

?>