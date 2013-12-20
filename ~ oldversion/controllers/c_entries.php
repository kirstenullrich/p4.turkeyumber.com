<?php
class entries_controller extends base_controller {

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
        $this->template->content = View::instance('v_entries_add');
        $this->template->title   = "New Trip Entry";

        # Render template
        echo $this->template;

    }

    public function p_add() {
        # Check for blank fields
        if (empty($_POST['title'])) {
            Router::redirect("/entries/add/blank");
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
        $_POST['trip_id'] = "";
        $_POST['vid'] = "";
        $_POST['comment_id'] = "";

        # Insert
        # Note we didn't have to sanitize any of the $_POST data because we're using the insert method which does it for us
        DB::instance(DB_NAME)->insert("entries", $_POST);

        Router::redirect("/entries/add");
    }

    public function modify($entry_id) {

       # Setup view
        $this->template->head = View::instance("v_index_head");
        $this->template->nav = View::instance('v_trips_add_nav');
        $this->template->content = View::instance('v_entries_modify');
        $this->template->title   = "Modify Trip Entry";

        # Render template
        echo $this->template;
            $q = "SELECT * 
                FROM entries
                WHERE entry_id = ".$entry_id;
    }

    public function p_modify($entry_id) {
         # Check for blank fields
        if (empty($_POST['title'])) {
            Router::redirect("/entries/modify/error");
        } 

        $_POST['modified'] = Time::now();
        
        DB::instance(DB_NAME)->update("entries", $_POST);

        Router::redirect("/trips/dashboard");
    }

    public function addimage($entry_id) {
        # Upload a profile image
            if ($_FILES['image']['error'] == 0) {
            $entry_image = Upload::upload($_FILES, "/uploads/entries/", array("JPG", "JPEG", "jpg", "jpeg", "gif", "GIF", "png", "PNG"), "entry_image_".Utils::generate_random_string());

        # Error message if the file type isn't on the list
            if($image == 'Invalid file type.') {
            Router::redirect("/users/profile/invalid");
            }

            else {

                # Process the upload
                $data = Array("image" => $image);
                DB::instance(DB_NAME)->insert("pics", $data, "WHERE entry_id = ".$entry_id);

                # Instantiate new image object using uploaded file
                $imgObj = new Image(APP_PATH."uploads/entries/".$entry_image);

                # Resize the image
                $imgObj->resize(400,600, "crop");
                $imgObj->save_image(APP_PATH."uploads/entries/".$entry_image, 100);
                DB::instance(DB_NAME)->insert("pics", $_POST);
                }
            }
            else
            {
                # Error message if file isn't able to be processed
                Router::redirect("/entries/addimage/process/");
            }

        # Go back to the profile page
        Router::redirect('/entries/'.$entry_id);
        }
       
    

}
?>