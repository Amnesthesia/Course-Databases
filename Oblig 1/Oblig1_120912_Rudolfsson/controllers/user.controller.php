<?php
    class UserController extends Controller
    {
    	function __construct()
		{
			// Dummy constructor to prevent calling parent.
		}
		
		/**
		 * Allow users to log in
		 * 
		 * @param array $params
		 */
		 function login($params = array())
		 {

		 	if(count($_POST) < 2 || (!isset($_POST["username"]) || !isset($_POST["password"]) || empty($_POST["username"]) || empty($_POST["password"])))
				die("missing parameters");
			
		 	$username = $_POST["username"];
			$password = $_POST["password"];
			
			$user = User::getUserByUsername($username);
			echo "Getting username ".$username;
			
			if(crypt($password,Database::getInstance()->getSalt()) == $user->getPassword())
			{
				$_SESSION["user_id"] = $user->getID();
				
			}
			else
				echo crypt($_POST["password"],Database::getInstance()->getSalt()). " does not equal ".$user->getPassword();
			//$this->redirect("index.php?route=post/all/");
		 }
		 
   /**
	* Displays the user creation view (wrapper for createOrUpdate)
	* 
	* @param array $params
	* 
	*/
	 function create($params = array())
	 {
		return $this->createOrUpdate($params);	
	 }
	 
   /**
	* Displays the user update view (wrapper for createOrUpdate)
	* 
	* @param array $params
	* 
	*/
	 function update($params = array())
	 {
		return $this->createOrUpdate($params);	
	 }
		  
		  
		  
	 /**
	  * Allows the user to create a new user - OR update
	  * an existing user. This is determined by the existance
	  * or absence of a user ID. 
	  * 

	  *  
	  * @param mixed $params
	  * @return array
	  */
	  function createOrUpdate($params = array())
	  {
	  	global $user;
		
		// If the user is already loggedin, we automatically
		// assume the user wants to update his/her own info.
		if($user->getUsername() != "Guest")
			$params = $user->getID();
		
	  	$page_parameters = array();
		
		///////////////////////////////////////////////
		/* ADD CHECK FOR USERS PERMISSION LEVEL HERE */
		///////////////////////////////////////////////
		
	  	// Check if the parameters passed is an array, and if it has any elements
	  	// because if it is, it should contain a user ID. Then we can just take it out,
	  	// and put it in to the $page_parameters array as a new userobject, 
	  	if(is_array($params) && count($params) > 0 && is_numeric($params[0]))
			$page_parameters["user"] = new User(array_shift($params));
		
		// But if it's a user object, we can use it straight away 
		else if(gettype($params) == "User")
			$page_parameters["user"] = $params;
		
		// However ... if it's a string or an integer, we use that to try to find the post and create a
		// post object from its ID :)
		else if((gettype($params) == "string" || gettype($params) == "integer") && (int) $params > 0)
			$page_parameters["user"] = new User((int) $params);
		
		// Otherwise, we dont have a user object, which means we're creating a new user
		else 
			$page_parameters["user"] = NULL;
		
		// Set the page title depending on whether we got a user object yet or not
		if($page_parameters["user"] != NULL)
			$page_title = $page_parameters["page_title"] = "Settings";
		else 
		{
			$page_title = $page_parameters["page_title"] = "Sign Up";
			$page_parameters["user"] = new User();
		}
		
		
	  	return array("page_title" => $page_title, "view" => "create.user", "params" => $page_parameters);
	  }

	  /**
	   * Saves a (new or existing) user to the database. If ID is provided,
	   * it updates an existing user in the database. If not, it creates a user.
	   * 
	   * This is a security risk unless user ID is checked against
	   * currently logged in user's ID; so to avoid form forgery
	   * we'll have to do that as well.
	   * 
	   * @param array $params 
	   */
	   function save($params)
	   {
	   	global $user;
	   	// If we dont have enough information provided, redirect back to where we came from (but append error codes)
	   	if(count($_POST) < 1 || (!array_key_exists("username",$_POST) ||
	   							 empty($_POST["username"]) || 
	   							 !array_key_exists("first_name",$_POST) || 
	   							 empty($_POST["first_name"]) ||
	   							 !array_key_exists("last_name", $_POST) ||
	   							 empty($_POST["last_name"]) || 
	   							 !array_key_exists("password", $_POST) ||
	   							 empty($_POST["password"]) || 
	   							 !array_key_exists("email", $_POST) ||
	   							 empty($_POST["email"]) || 
	   							 !array_key_exists("confirmpw", $_POST) ||
								 empty($_POST["confirmpw"])) || 
								 $_POST["confirmpw"] != $_POST["password"])
		{
			// We assume the refering URL had at least the GET variable "route" in it, so we append new
			// GET variables.
			$error_code_redir = $_SERVER['HTTP_REFERER'] . "&missing=";
			$missing = array();
			
			if(!array_key_exists("username",$_POST) || empty($_POST["username"]))
				$missing[] = "username";
			if(!array_key_exists("first_name",$_POST) || empty($_POST["first_name"]))
				$missing[] = "first_name";
			if(!array_key_exists("last_name",$_POST) || empty($_POST["last_name"]))
				$missing[] = "last_name";
			if(!array_key_exists("password") || empty($_POST["password"]))
				$missing[] = "password";
			if(!array_key_exists("email") || empty($_POST["email"]))
				$missing[] = "email";
			if(!array_key_exists("confirmpw") || empty($_POST["confirmpw"]))
				$missing[] = "email";
			if($_POST["confirmpw"] != $_POST["password"])
				$missing[] = "confirmpw";
			
			// Now lets implode this array with commas, and pass it on back to where we came from.
			$error_code_redir .= implode(",",$missing);
			return $this->redirect($error_code_redir);
			
		}
			
		/**
		 * ENTER PERMISSION LEVEL CHECK HERE ON $user->getRole()
		 * USER WITH ADMINISTRATOR LEVEL PERMISSION SHOULD BE ALLOWED TO UPDATE
		 * ANY USER.
		 */
		
		// If the user is trying to update another user than himself, redirect
		// back to previous page with information about missing permissions.
		if(isset($_POST["id"]) && $user->getID() != $_POST["id"])
			echo $_POST["id"]. " DOES NOT EQUAL " . $user->getID();
		// Else if ID is set, and it's the same as this user's ID, update 
		// the user (or create it, if ID doesn't exist -- user model handles this)
		else
		{
			$update_user = new User($_POST);
			$update_user->save();
			
			// If an ID existed, and thus the user existed, redirect back to
			// previous page. Otherwise, redirect to front page.
			if(isset($_POST["id"]))
				return $this->redirect($_SERVER['HTTP_REFERER']);
			else
				return $this->redirect('index.php?route=post/all/');
		}
			
		
	   }

    }



?>
