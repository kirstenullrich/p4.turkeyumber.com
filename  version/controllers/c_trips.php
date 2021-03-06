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

        Router::redirect("/trips/dashboard");

    }


        public function index() {

            # Set up the View
            $this->template->head = View::instance("v_index_head");
            $this->template->content = View::instance('v_trips_index');
            $this->template->title   = "All Trips";

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


           # Render the View
            echo $this->template;

        }

        # The list of your own trips
        public function self(){
            $this->template->head = View::instance("v_index_head");
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


        public function dashboard($trip_id) {

            # Set up the View
            $this->template->head = View::instance("v_trips_head");
            $this->template->content = View::instance("v_trips_dashboard");
            $this->template->title   = "Dashboard";


            
            # Build the query to get all the entries
            $q = "SELECT
                * from entries
                WHERE trip_id = ".$trip_id.
                " ORDER BY created DESC";

            $entries = DB::instance(DB_NAME)->select_rows($q);

            $q = "SELECT 
                pics.pic_id,
                pics.img,
                pics.caption,
                pics.created AS pics_created,
                entries.entry_id AS the_entry_id,
                entries.trip_id
                FROM entries
                INNER JOIN pics 
                    ON entries.entry_id = pics.entry_id
                WHERE entries.trip_id = ".$trip_id;

            $gallery = DB::instance(DB_NAME)->select_rows($q);

           
            $q = "SELECT *
                FROM trips
                WHERE trip_id = ".$trip_id;

            $thistrip = DB::instance(DB_NAME)->select_row($q);


            # Pass data (users and connections) to the view
            $this->template->content->entries       = $entries;
            $this->template->content->thistrip      = $thistrip;
            $this->template->content->trip_id       = $trip_id;
            $this->template->content->gallery       = $gallery;

           // $this->template->content->connections = $connections;

            # Render the view
            echo $this->template;
        }



    public function p_newentry($trip_id) {
        # Check for blank fields
        if (empty($_POST['title'])) {
            Router::redirect("/trips/newentry/blank");
        } 
        
        $here = Geolocate::locate();
        $_POST['state']  = $here['state'];
        $_POST['city']  = $here['city'];
        $_POST['ip']  = $here['ip'];

        # Associate this trip with this user
        $_POST['user_id']  = $this->user->user_id;

        # Unix timestamp of when this trip was created / modified
        $_POST['created']  = Time::now();
        $_POST['modified'] = Time::now();

        $_POST['pic_id'] = "";
        $_POST['trip_id'] = $trip_id;
        $_POST['vid'] = "";
        $_POST['comment_id'] = "";

        # Insert
        # Note we didn't have to sanitize any of the $_POST data because we're using the insert method which does it for us
        DB::instance(DB_NAME)->insert("entries", $_POST);

        Router::redirect("/trips/dashboard/".$trip_id);
    }
    public function p_modify($entry_id, $trip_id) {
         # Check for blank fields
      //  if (empty($_POST['title'])) {
        //    Router::redirect("/entries/modify/error");
        //} 

        $_POST['modified'] = Time::now();
        
        $where = "WHERE entry_id = ".$entry_id;
        DB::instance(DB_NAME)->update("entries", $_POST, $where);

        Router::redirect("/trips/dashboard/".$trip_id);
    }

    public function addimage($entry_id, $trip_id) {
        # Upload a profile image
            if ($_FILES['img']['error'] == 0) {
            $entry_image = Upload::upload($_FILES, "/uploads/entries/", array("JPG", "JPEG", "jpg", "jpeg", "gif", "GIF", "png", "PNG"), "entry_image_".$entry_id."_".Utils::generate_random_string());

        # Error message if the file type isn't on the list
            if($entry_image == 'Invalid file type.') {
            Router::redirect("/trips/dashboard/invalid");
            }

            else {

                # Process the upload
                $data = Array("img" => $entry_image,
                            "entry_id" => $entry_id);
                DB::instance(DB_NAME)->insert("pics", $data);

                # Instantiate new image object using uploaded file
                $imgObj = new Image(APP_PATH."uploads/entries/".$entry_image);

                # Resize the image
                $imgObj->resize(150,200, "crop");
                $imgObj->save_image(APP_PATH."uploads/entries/".$entry_image, 100);
               // DB::instance(DB_NAME)->insert("pics", $_POST);
                }
            }
            else
            {
                # Error message if file isn't able to be processed
                Router::redirect("/trips/dashboard/process/");
            }

        # Go back to the profile page
        Router::redirect("/trips/dashboard/".$trip_id);
        }


}
?>