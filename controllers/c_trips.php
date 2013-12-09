<?php
class trips_controller extends base_controller {

    public function __construct() {
        parent::__construct();

        # Make sure user is logged in if they want to use anything in this controller
        if(!$this->user) {
            die("Members only. <a href='/users/login'>Login</a>");
        }
    }

    public function add() {

        # Setup view
        $this->template->head = View::instance("v_index_head");
        $this->template->nav = View::instance('v_trips_add_nav');
        $this->template->content = View::instance('v_trips_add');
        $this->template->title   = "New Trip";

        # Render template
        echo $this->template;

    }

    public function p_add() {
        # Check for blank fields
        if (empty($_POST['title'])) {
            Router::redirect("/trips/new/missing");
        } 

        # Associate this trip with this user
        $_POST['user_id']  = $this->user->user_id;

        # Unix timestamp of when this trip was created / modified
        $_POST['created']  = Time::now();
        $_POST['modified'] = Time::now();

        $_POST['miles'] = "";
        $_POST['coverimg'] = "";
        $_POST['starred'] = "";

        # Insert
        # Note we didn't have to sanitize any of the $_POST data because we're using the insert method which does it for us
        DB::instance(DB_NAME)->insert("trips", $_POST);

        Router::redirect("/trips/add");

    }


        public function index() {

            # Set up the View
            $this->template->head = View::instance("v_index_head");
            $this->template->nav = View::instance('v_trips_index_nav');
            $this->template->content = View::instance('v_trips_index');
            $this->template->title   = "All Trips";

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
                WHERE users.user_id = '.$this->user->user_id.
                ' ORDER BY trips.created DESC';

            # Run the query, store the results in the variable $trips
            $trips = DB::instance(DB_NAME)->select_rows($q);

            $q = 'SELECT users_trips.trip_id AS starred_id
                FROM users_trips 
                INNER JOIN trips 
                    ON trips.trip_id = users_trips.trip_id
                WHERE users_trips.user_id = '.$this->user->user_id;

            $star = DB::instance(DB_NAME)->select_array($q, 'starred_id');

            # How many stars each trip has
            $q = "SELECT trip_id, COUNT(1) AS total FROM users_trips GROUP BY trip_id";
            $stars = DB::instance(DB_NAME)->select_rows($q);

            
            $this->template->content->stars = $stars;
            $this->template->content->trips = $trips;
            $this->template->content->star = $star;

           # Render the View
            echo $this->template;

        }

        # The list of your own trips
        public function self(){
            $this->template->head = View::instance("v_index_head");
            $this->template->nav = View::instance('v_trips_self_nav');
            $this->template->content = View::instance('v_trips_self');

            $q = "SELECT
                    trips.trip_id,
                    trips.content,
                    trips.created,
                    trips.user_id AS trip_user_id,
                    users.first_name,
                    users.last_name,
                    users.image
                FROM trips
                INNER JOIN users 
                    ON trips.user_id = users.user_id
                WHERE users.user_id = ".$this->user->user_id.
                " ORDER BY trips.created DESC";
            $trips = DB::instance(DB_NAME)->select_rows($q);
            $this->template->content->trips = $trips;

            echo $this->template;
        }

        public function users() {

            # Set up the View
            $this->template->head = View::instance("v_index_head");
            $this->template->nav = View::instance("v_trips_users_nav");
            $this->template->content = View::instance("v_trips_users");
            $this->template->title   = "Users";

            # Build the query to get all the users
            $q = "SELECT *
                FROM users
                WHERE user_id != ".$this->user->user_id;

            # Execute the query to get all the users. 
            # Store the result array in the variable $users
            $users = DB::instance(DB_NAME)->select_rows($q);

            # Build the query to figure out what connections does this user already have? 
            # I.e. who are they following
            $q = "SELECT * 
                FROM users_users
                WHERE user_id = ".$this->user->user_id;

            # Execute this query with the select_array method
            # select_array will return our results in an array and use the "users_id_followed" field as the index.
            # This will come in handy when we get to the view
            # Store our results (an array) in the variable $connections
            $connections = DB::instance(DB_NAME)->select_array($q, 'user_id_followed');

            # Pass data (users and connections) to the view
            $this->template->content->users       = $users;
            $this->template->content->connections = $connections;

            # Render the view
            echo $this->template;
        }


        public function follow($user_id_followed) {

            # Prepare the data array to be inserted
            $data = Array(
                "created" => Time::now(),
                "user_id" => $this->user->user_id,
                "user_id_followed" => $user_id_followed
                );

            # Do the insert
            DB::instance(DB_NAME)->insert('users_users', $data);

            # Send them back
            Router::redirect("/trips/users");

        }

        public function unfollow($user_id_followed) {

            # Delete this connection
            $where_condition = 'WHERE user_id = '.$this->user->user_id.' AND user_id_followed = '.$user_id_followed;
            DB::instance(DB_NAME)->delete('users_users', $where_condition);

            # Send them back
            Router::redirect("/trips/users");

        }

        public function star($trip_id) {

            $data = Array(
                "trip_id" => $trip_id,
                "user_id" => $this->user->user_id,
                );

            DB::instance(DB_NAME)->insert("users_trips", $data);

            Router::redirect("/trips");
        }

        public function unstar($trip_id) {

            # Delete this connection
            $where_condition = 'WHERE user_id = '.$this->user->user_id.' AND trip_id = '.$trip_id;
            DB::instance(DB_NAME)->delete('users_trips', $where_condition);

            # Send them back
            Router::redirect("/trips");

        }

        public function dashboard($trip_dash) {

            $this->template->head = View::instance("v_index_head");
            $this->template->nav = View::instance('v_trips_index_nav');
            $this->template->content = View::instance('v_trips_dashboard');
            $this->template->title   = "Hiiiii";

            # Trying to pass trip id to dashboard
           // $trip_dash = "trip_id";

            /*$trip_dash = DB::instance(DB_NAME)->select_rows("trips", "trip_id");

            # Query to select entries for a specific trip
            $q = "SELECT *
                FROM entries
                WHERE trip_id = ".$trip_dash.
                " ORDER BY entries.created ASC";

            # Execute the query to get all the entries. 
            # Store the result array in the variable $entries
            $entries = DB::instance(DB_NAME)->select_rows($q);
            
            $q = "SELECT *
                FROM trips
                WHERE trip_id = ".$trip_dash;

            $this_trip = DB::instance(DB_NAME)->select_rows($q);

            $this->template->content->entries     = $entries;*/
            $this->template->content->trip_dash = $trip_dash;
        }
}
?>