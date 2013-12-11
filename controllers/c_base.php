<?php

class base_controller {
	
	public $user;
	public $userObj;
	public $template;
	public $email_template;

	public $tripObj;
	public $trip;

	/*-------------------------------------------------------------------------------------------------

	-------------------------------------------------------------------------------------------------*/
	public function __construct() {
						
		# Instantiate User obj
			$this->userObj = new User();
			$this->tripObj = new Trip();
			
		# Authenticate / load user
			$this->user = $this->userObj->authenticate();					
						
		# Set up templates
			$this->template 	  = View::instance('_v_template');
			$this->email_template = View::instance('_v_email');			
								
		# So we can use $user in views			
			$this->template->set_global('user', $this->user);
			$this->template->set_global('trip', $this->trip);
			
	}
	
} # eoc
