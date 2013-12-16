<?php

class Entry {
	
	public static function get_entries_by_trip($trip_id) {
	
		$q = 'SELECT *
			FROM entries
			WHERE trip_id = '.$trip_id;
		
		$trip_entries = DB::instance(DB_NAME)->select_rows($q);
		
		return $trip_entries;
		
	}

		public static function get_entries_by_id($entry_id) {
	
		$q = 'SELECT *
			FROM entries
			WHERE entry_id = '.$entry_id;
		
		$specific_entry = DB::instance(DB_NAME)->select_rows($q);
		
		return $specific_entry;
		
	}

} # end class

?>