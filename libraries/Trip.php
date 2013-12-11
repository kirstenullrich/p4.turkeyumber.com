<?php

class Trip {
	
	# Cache trip in this class
	private $_trip;

	public $trip_id;
		
	public function __construct($entries_table = 'entries') {
		
		$this->entries_table = $entries_table;
	
			if(isset($trip['trip_id'])) {
			$this->trip_id = $trip_id;
		}
	}

	


	/*-------------------------------------------------------------------------------------------------
	
	-------------------------------------------------------------------------------------------------*/
	public function __load_trip() {

		# Retreive from cache, reduce DB calls
		if (! isset($this->_trip)) {
						
			# Load trip entries from DB
				$q = "SELECT *
					FROM ".$this->entries_table."
					WHERE trip_id = '".$this->trip_id."'
					";	
										
				$this->_trip = DB::instance(DB_NAME)->select_row($q, "object");

		}
				
		# Done
		return $this->_trip;

	}



} # end class

?>