<?php
class trips_controller extends base_controller {

    public function __construct() {
        parent::__construct();

        # Make sure user is logged in if they want to use anything in this controller
        if(!$this->user) {
            die(Router::redirect("/users/login"));
        }
    }

    public function add($missing = NULL) {

        # Setup view
        $this->template->head = View::instance("v_index_head");
        $this->template->content = View::instance('v_trips_add');
        $this->template->title = "New Trip";
        $this->template->content->missing = $missing;


        # Render template
        echo $this->template;

    }

    public function p_add() {
        # Check for blank fields
        if (empty($_POST['title'])) {
            Router::redirect("/trips/new/missing");
        }

        # Associate this trip with this user
        $_POST['user_id'] = $this->user->user_id;

        # Unix timestamp of when this trip was created / modified
        $_POST['created'] = Time::now();
        $_POST['modified'] = Time::now();

        $_POST['coverimg'] = "fpo.jpg";

        # Insert
        DB::instance(DB_NAME)->insert("trips", $_POST);

        Router::redirect("/trips/index");

    }


        public function index() {

            $this->template->head = View::instance("v_index_head");
            $this->template->content = View::instance('v_trips_index');
            $this->template->title = "All Trips";

            # Figure out where the user is
            $here = Geolocate::locate();

            # Query
            $q = 'SELECT
            trips.trip_id,
            trips.title,
            trips.description,
            trips.created,
            trips.coverimg,
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

            # Run the query to see what trips are starred
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
            $this->template->content->here = $here;

            echo $this->template;
        }


        public function star($trip_id) {

            # Set up user-star association
            $data = Array(
                "trip_id" => $trip_id,
                "user_id" => $this->user->user_id,
                );

            DB::instance(DB_NAME)->insert("users_trips", $data);

            Router::redirect("/trips");
        }


        public function unstar($trip_id) {

            # Delete user-star association
            $where_condition = 'WHERE user_id = '.$this->user->user_id.' AND trip_id = '.$trip_id;

            DB::instance(DB_NAME)->delete('users_trips', $where_condition);

            Router::redirect("/trips");

        }


     # The list of starred trips
        public function starred(){
            $this->template->head = View::instance("v_index_head");
            $this->template->content = View::instance('v_trips_starred');
            $this->template->title = "Starred Trips";

            $q = "SELECT trips.trip_id AS trip_id,
                trips.created, trips.title, trips.description,
                users_trips.trip_id AS starred_id,
                users_trips.user_id,
                users.last_name,
                users.first_name
                FROM users_trips
                INNER JOIN trips
                ON trips.trip_id = users_trips.trip_id 
                AND users_trips.user_id = ".$this->user->user_id.
                " INNER JOIN users
                ON users_trips.user_id = users.user_id
                ORDER BY trips.created DESC";
            $starred = DB::instance(DB_NAME)->select_rows($q);
            $this->template->content->starred = $starred;

            echo $this->template;
        }


        public function dashboard($trip_id) {

            $this->template->head = View::instance("v_trips_head");
            $this->template->content = View::instance("v_trips_dashboard");
            $this->template->title = "Dashboard";

            $client_files_body = Array(
                '/js/dashboard.js'
                );

            $this->template->client_files_body = Utils::load_client_files($client_files_body);
            
            # Get all the entries
            $q = "SELECT
            * from entries
            WHERE trip_id = ".$trip_id.
            " ORDER BY created ASC";

            $entries = DB::instance(DB_NAME)->select_rows($q);

            # Oldest entry
            $q = "SELECT created from entries
            WHERE trip_id = ".$trip_id.
            " ORDER BY created ASC
            LIMIT 1";

            $start = DB::instance(DB_NAME)->select_rows($q);

            # Newest entry
            $q = "SELECT created from entries
            WHERE trip_id = ".$trip_id.
            " ORDER BY created DESC
            LIMIT 1";

            $last = DB::instance(DB_NAME)->select_rows($q);

            # Get entry comments
            $q = "SELECT
            comments.entry_id AS thisentrycomment, 
            comments.user_id AS commenter,
            comments.created, 
            comments.content,
            entries.entry_id AS entry_id,
            entries.trip_id,
            users.user_id AS user_id,
            users.first_name,
            users.last_name
            FROM comments
            INNER JOIN entries
            ON comments.entry_id = entries.entry_id 
            INNER JOIN users
            ON comments.user_id = users.user_id
            WHERE trip_id = ".$trip_id.
            " ORDER BY created ASC";

            $comments = DB::instance(DB_NAME)->select_rows($q);

            # Get entry pictures
            $q = "SELECT 
            pic_id, entry_id 
            FROM pics";

            $gallery = DB::instance(DB_NAME)->select_kv($q, 'entry_id', 'pic_id');

            # Get single trip info           
            $q = "SELECT *
            FROM trips
            WHERE trip_id = ".$trip_id;

            $thistrip = DB::instance(DB_NAME)->select_row($q);

            # Get states the trip has covered, eliminate duplicates          
            $q = "SELECT state 
            FROM entries 
            WHERE trip_id = ".$trip_id;
            $state = Db::instance(DB_NAME)->select_rows($q);
            $dashmap = Map::super_unique($state);

            # Pass data (users and connections) to the view
            $this->template->content->entries = $entries;
            $this->template->content->thistrip = $thistrip;
            $this->template->content->trip_id = $trip_id;
            $this->template->content->gallery = $gallery;
            $this->template->content->dashmap = $dashmap;
            $this->template->content->comments = $comments;
            $this->template->content->start = $start;
            $this->template->content->last = $last;

            echo $this->template;
        }


    public function p_newentry($trip_id) {

        # Check for blank fields
        if (empty($_POST['title'])) {
            Router::redirect("/trips/newentry/blank");
        }
        
        $here = Geolocate::locate();
        $_POST['state'] = $here['state'];
        $_POST['city'] = $here['city'];
        $_POST['ip'] = $here['ip'];

        # Associate this trip with this user
        $_POST['user_id'] = $this->user->user_id;

        # Unix timestamp of when this trip was created / modified
        $_POST['created'] = Time::now();
        $_POST['modified'] = Time::now();

        $_POST['pic_id'] = "";
        $_POST['trip_id'] = $trip_id;
        $_POST['vid'] = "";
        $_POST['comment_id'] = "";

        DB::instance(DB_NAME)->insert("entries", $_POST);

        Router::redirect("/trips/dashboard/".$trip_id);
    }


    public function p_modify($entry_id, $trip_id) {

        # Modify an entry
        $_POST['modified'] = Time::now();
        
        $where = "WHERE entry_id = ".$entry_id;
        DB::instance(DB_NAME)->update("entries", $_POST, $where);

        Router::redirect("/trips/dashboard/".$trip_id);
    }


    public function addimage($entry_id, $trip_id) {

        # Upload a profile image
            if ($_FILES['img']['error'] == 0  && $_FILES['coverimg']['size'] < 1500*1500) {
            $entry_image = Upload::upload($_FILES, "/uploads/entries/", array("JPG", "JPEG", "jpg", "jpeg", "gif", "GIF", "png", "PNG"), "entry_image_".$entry_id."_".Utils::generate_random_string());

        # Error message if the file type isn't on the list
            if($entry_image == 'Invalid file type.') {
            Router::redirect("/trips/dashboard/invalid");
            }

            else {
                
                # Process the upload
                $data = Array("img" => $entry_image,
                            "entry_id" => $entry_id,
                            "caption" => $caption,
                            "created" => Time::now());
                DB::instance(DB_NAME)->insert("pics", $data);

                # Boolean for entries table so we know there are pictures associated with this entry
                $pic = Array("pic_id" => "1");
                DB::instance(DB_NAME)->update("entries", $pic, "WHERE entry_id = ".$entry_id);

                # Instantiate new image object using uploaded file
                $imgObj = new Image(APP_PATH."uploads/entries/".$entry_image);

                # Resize the image
                $imgObj->resize(500,500, "crop");
                $imgObj->save_image(APP_PATH."uploads/entries/".$entry_image, 100);
                Router::redirect("/trips/dashboard/".$trip_id);
                }
            }
            else
            {
                # Error message if file isn't able to be processed
                Router::redirect("/trips/dashboard/process/");
            }
        }


    public function gallery($entry_id, $trip_id) {

            $this->template->head = View::instance("v_trips_head");
            $this->template->content = View::instance('v_trips_gallery');
            $this->template->title = "All Trips";

            # Query to get entry images
            $q = 'SELECT *
            FROM pics
            WHERE entry_id = '.$entry_id;

            $gallery = DB::instance(DB_NAME)->select_rows($q);

            # Query to get entry title
            $q = 'SELECT title
            FROM entries
            WHERE entry_id = '.$entry_id;

            $title = DB::instance(DB_NAME)->select_field($q);

            $this->template->content->gallery = $gallery;
            $this->template->content->entry_id = $entry_id;
            $this->template->content->trip_id = $trip_id;
            $this->template->content->title = $title;

            echo $this->template;
    }


    public function coverimage($trip_id, $error = NULL) {

            $this->template->head = View::instance("v_trips_head");
            $this->template->content = View::instance('v_trips_coverimage');
            $this->template->title   = "Cover image";
            $this->template->content->error = $error;
            $this->template->content->trip_id = $trip_id;

            # Query
            $q = 'SELECT *
            FROM trips
            WHERE trip_id = '.$trip_id;

            $trips = DB::instance(DB_NAME)->select_row($q);
            $this->template->content->trips = $trips;

        # Render template
            echo $this->template;
    }

     public function p_coverimage($trip_id) {

        # Upload a cover image
            if ($_FILES['coverimg']['error'] == 0 && $_FILES['coverimg']['size'] < 800*800){
            $image = Upload::upload($_FILES, "/uploads/avatars/", array("JPG", "JPEG", "jpg", "jpeg", "gif", "GIF", "png", "PNG"), $trip_id);

        # Error message if the file type isn't on the list
            if($image == 'Invalid file type.') {
            Router::redirect("/trips/coverimage/".$trip_id."/error");
            }

            else {

                # Process the upload
                $data = Array("coverimg" => $image);
                DB::instance(DB_NAME)->update("trips", $data, "WHERE trip_id = ".$trip_id);

                # Resize the image
                $imgObj = new Image(APP_PATH."uploads/avatars/". $image);
                $imgObj->resize(100,100, "crop");
                $imgObj->save_image(APP_PATH."uploads/avatars/". $image);

                # Go back to the cover image page
                Router::redirect('/trips/coverimage/'.$trip_id);
            }
        }
        else
        {
            # Error message if file isn't able to be processed
            Router::redirect("/trips/coverimage/".$trip_id."/error");
        }

    }


    public function addcomment($entry_id, $trip_id) {

        # Check for blank fields
        if (empty($_POST['content'])) {
            Router::redirect("/trips/dashboard/missing");
        }

        # Associate this trip with this user
        $_POST['user_id'] = $this->user->user_id;

        $_POST['entry_id'] = $entry_id;

        # Unix timestamp of when this trip was created / modified
        $_POST['created'] = Time::now();

        DB::instance(DB_NAME)->insert("comments", $_POST);

        Router::redirect("/trips/dashboard/".$trip_id);
    }


    public function comments($entry_id, $trip_id) {

        $q = 'SELECT *
            FROM comments
            WHERE entry_id = '.$entry_id;

        $comments = DB::instance(DB_NAME)->select_rows($q);

        Router::redirect("/trips/dashboard/".$trip_id);
    }
}
?>