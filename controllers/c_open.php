<?php
# This controller allows non-logged-in users to see the list of all trips and check out the entries

class open_controller extends base_controller {

    public function __construct() {
        parent::__construct();
}
        public function index() {

            # Set up the View
            $this->template->head = View::instance("v_index_head");
            $this->template->content = View::instance('v_open_index');
            $this->template->title = "All Trips";

            $here = Geolocate::locate();

            # Query
            $q = 'SELECT
            trips.trip_id,
            trips.title,
            trips.description,
            trips.created,
            trips.user_id AS trip_user_id,
            users.first_name,
            users.last_name,
            users.image
            FROM trips
            INNER JOIN users
            ON trips.user_id = users.user_id
            ORDER BY trips.created DESC';

            # Run the query, store the results in the variable $trips
            $trips = DB::instance(DB_NAME)->select_rows($q);

            $q = 'SELECT users_trips.trip_id AS starred_id
            FROM users_trips
            INNER JOIN trips
            ON trips.trip_id = users_trips.trip_id';

            $star = DB::instance(DB_NAME)->select_array($q, 'starred_id');

            # How many stars each trip has
            $q = "SELECT trip_id, COUNT(1) AS total FROM users_trips GROUP BY trip_id";
            $stars = DB::instance(DB_NAME)->select_rows($q);


            $this->template->content->stars = $stars;
            $this->template->content->trips = $trips;
            $this->template->content->star = $star;
            $this->template->content->here = $here;


           # Render the View
            echo $this->template;

        }
}
?>