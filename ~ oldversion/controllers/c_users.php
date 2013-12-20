<?php
class users_controller 
extends base_controller {

    public function __construct() {
        parent::__construct();
    } 


    public function index() {
        Router::redirect("/users/login");
    }


    public function signup($error = NULL) {

        # Setup view
            $this->template->head = View::instance("v_index_head");
            $this->template->content = View::instance('v_users_signup');
            $this->template->title   = "Sign Up";
            $this->template->content->error = $error;

        # Render template
            echo $this->template;

    }


    public function p_signup() {

        # Check for blank fields
            foreach($_POST as $formfield) {
                if (empty($formfield)) {
                    Router::redirect("/users/signup/missing");
                } 
            }

        # Check for duplicate email addresses
            $emailcheck = $this->userObj->confirm_unique_email($_POST['email']);
                if ($emailcheck == false){
                    Router::redirect("/users/signup/dupemail");
                }

        # More data we want stored with the user
            $_POST['image']  = "avatar.jpg";
            $_POST['created']  = Time::now();
            $_POST['modified'] = Time::now();

        # Encrypt the password  
            $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);            

        # Create an encrypted token via their email address and a random string
            $_POST['token'] = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string()); 

        # Insert this user into the database 
            $user_id = DB::instance(DB_NAME)->insert("users", $_POST);

           // $data = Array('user_id' => $user_id,
           //     'user_id_followed' => $user_id,
           //     'created' => Time::now()
           //     );

           // $followyourself = DB::instance(DB_NAME)->insert("users_users", $data);

       # Go back to Login page
            Router::redirect("/users/login/");
    }


    public function login($error = NULL) {

        # Setup view
            $this->template->head = View::instance("v_index_head");
            $this->template->content = View::instance('v_users_login');
            $this->template->title   = "Login";
            $this->template->content->error = $error;

        # Render template
            echo $this->template;
    }


    public function p_login() {

        # Sanitize the user entered data to prevent any funny-business (re: SQL Injection Attacks)
            $_POST = DB::instance(DB_NAME)->sanitize($_POST);

        # Hash submitted password so we can compare it against one in the db
            $_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

        # Search the db for this email and password
        # Retrieve the token if it's available
            $q = "SELECT token 
                FROM users 
                WHERE email = '".$_POST['email']."' 
                AND password = '".$_POST['password']."'";

            $token = DB::instance(DB_NAME)->select_field($q);

        # If we didn't find a matching token in the database, it means login failed
            if(!$token) {

            # Send them back to the login page
                Router::redirect("/users/login/error");

        # But if we did, login succeeded! 
            } else {

            /* 
            Store this token in a cookie using setcookie()
            Important Note: *Nothing* else can echo to the page before setcookie is called
            Not even one single white space.
            param 1 = name of the cookie
            param 2 = the value of the cookie
            param 3 = when to expire
            param 4 = the path of the cooke (a single forward slash sets it for the entire domain)
            */
                setcookie("token", $token, strtotime('+1 year'), '/');

            # Send them to the main page - or whever you want them to go
                Router::redirect("/trips");

        }

    }


    public function logout() {

        # Generate and save a new token for next login
            $new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());

        # Create the data array we'll use with the update method
        # In this case, we're only updating one field, so our array only has one entry
            $data = Array("token" => $new_token);

        # Do the update
            DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");

        # Delete their token cookie by setting it to a date in the past - effectively logging them out
            setcookie("token", "", strtotime('-1 year'), '/');

        # Send them back to the main index.
            Router::redirect("/users/login");

    }


    public function profile($error = NULL) {

        # If user is blank, they're not logged in; redirect them to the login page
            if(!$this->user) {
            Router::redirect('/users/login');
            }

        # If they weren't redirected away, continue:

        # Setup view
            $this->template->head = View::instance("v_index_head");
            $this->template->nav = View::instance("v_trips_users_nav");
            $this->template->content = View::instance('v_users_profile');
            $this->template->title   = $this->user->first_name."'s profile";
            $this->template->content->error = $error;

        # Render template
            echo $this->template;
    }


     public function p_profile() {

        # Upload a profile image
            if ($_FILES['image']['error'] == 0) {
            $image = Upload::upload($_FILES, "/uploads/avatars/", array("JPG", "JPEG", "jpg", "jpeg", "gif", "GIF", "png", "PNG"), $this->user->user_id);

        # Error message if the file type isn't on the list
            if($image == 'Invalid file type.') {
            Router::redirect("/users/profile/error");
            }

            else {

                # Process the upload
                $data = Array("image" => $image);
                DB::instance(DB_NAME)->update("users", $data, "WHERE user_id = ".$this->user->user_id);

                # Resize the image
                $imgObj = new Image($_SERVER["DOCUMENT_ROOT"] . '/uploads/avatars/' . $image);
                $imgObj->resize(75,75, "crop");
                $imgObj->save_image($_SERVER["DOCUMENT_ROOT"] . '/uploads/avatars/' . $image);
            }
        }
        else
        {
            # Error message if file isn't able to be processed
            Router::redirect("/users/profile/error/");
        }

        # Go back to the profile page
        Router::redirect('/users/profile/');
    }

} # end of the class