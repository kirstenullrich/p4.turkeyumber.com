<?php

public function profile($user_name = NULL) {

    if($user_name == NULL) {
        echo "No user specified";
    }
    else {
        echo "This is the profile for ".$user_name;
    }
}
?>