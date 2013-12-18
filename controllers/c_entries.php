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


       
    

}
?>