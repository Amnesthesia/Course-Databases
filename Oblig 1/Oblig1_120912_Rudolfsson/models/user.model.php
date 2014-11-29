<?php

class User
{
	private $_db, $_id, $_username, $_first_name, $_last_name, $_email, $_registration_date, $_role, $_hashword;
	
	
	function __construct($id = 0)
	{
		$this->_db = Database::getInstance();
		
		if(is_numeric($id) && $id > 0)
		{
			$this->_massAssign($this->_db->getUserById($id));
			
		}
		else if(is_array($id))
			$this->_massAssign($id);
		else {
			
			// Does absolutely nothing if we get 0, or incorrect values.
			// If so, it simply sets up an empty object and allows for 
			// manually setting values and saving to the database
			$this->_id = $this->_role = $this->_registration_date = 0;
			$this->_username = $this->_first_name = $this->_last_name = $this->_email = $this->_hashword = "";  
		}
		
	}
	
	
	/**
	 * Sets up a user from a mass-assignment array,
	 * either straight from the database, or from
	 * a newly created user
	 * 
	 * @param array $attributes
	 */
	 private function _massAssign($array = array())
	 {
	 	if(count($array)<1 || !is_array($array))
			return;
		
	 	if(array_key_exists("username",$array) && array_key_exists("first_name", $array) && array_key_exists("last_name", $array) && array_key_exists("email", $array))
		{
			$this->setUsername($array["username"]);
			$this->setFirstName($array["first_name"]);
			$this->setLastName($array["last_name"]);
			$this->setEmail($array["email"]);
			
			
			// If the user is being created, the array key "password"
			// will be used instead of "hashword". We need this hashed.
			if(array_key_exists("password",$array))
				$this->setPassword($array["password"]);
			else if(array_key_exists("hashword",$array))
				$this->_hashword = $array["hashword"];
			
			
			// If the user is created from a pre-existing database entry
			// we can continue to check for the existance of parameters 
			// which should only exist if the user has been inserted into
			// the users table:
			
			if(array_key_exists("id",$array))
				$this->_id = $array["id"];
			else
				$this->_id = 0;
			
			if(array_key_exists("registration_date",$array))
				$this->_registration_date = $array["registration_date"];
			
			// If "rank" exists, it comes from a database entry
			if(array_key_exists("rank",$array))
				$this->_role["id"] = $array["rank"];
			// If rank does not exist, but role exists, this is a new user
			else if(array_key_exists("role",$array))
				$this->_role["id"] = $array["role"];
			// Default to permission level 3 (role 3)
			else 
				$this->_role["id"] = 3;
		}				
	 }

	/**
	 * Stores the current user in the database.
	 * If the user exists, necessary fields will be updated.
	 * If the user does not exist, it will be created.
	 * 
	 * @return bool
	 */
	 function save()
	 {
	 	try{
	 		if($this->_id == 0)
				$this->_id = $this->_db->createUser($this->_role["id"], $this->getUsername(), $this->getEmail(), $this->getFirstName(), $this->getLastName(), $this->_hashword);
			else 
				$this->_db->updateUser($this->_role["id"], $this->getUsername(), $this->getEmail(), $this->getFirstName(), $this->getLastName(), $this->_hashword, $this->_id);
	 	} catch(Exception $e)
		{
			echo $e->getMessage();
		}
	 }
	
	/** Getters for all variables **/
	
	/**
	 * Gets the user ID
	 * 
	 * @return integer
	 */
	 function getID()
	 {
	 	return $this->_id;
	 }
	
	/**
	 * Gets the username for the current user
	 * 
	 * @return string
	 */
	 function getUsername()
	 {
	 	return $this->_username;
	 }
	 
	/**
	 * Gets the first name for the current user
	 * 
	 * @return string
	 */
	 function getFirstName()
	 {
	 	return $this->_first_name;
	 } 
	 
	/**
	 * Gets the last name for the current user
	 * 
	 * @return string
	 */
	 function getLastName()
	 {
	 	return $this->_last_name;
	 }
	 
	/**
	 * Gets the email address for the current user
	 * 
	 * @return string
	 */
	 function getEmail()
	 {
	 	return $this->_email;
	 }
	 
	/**
	 * Gets the registration date for the current user
	 * 
	 * @return string
	 */
	 function getRegistrationDate()
	 {
	 	return $this->_registration_date;
	 }
	 
	 
	 /** 
	  * Returns the hashed password
	  * 
	  * @return string
	  */
	 function getPassword()
	 {
	 	return $this->_hashword;
	 }
	 
	 /**
	  * Gets the role for the current user
	  * 
	  * @return Role
	  */
	 function getRole()
	 {
	 	return $this->_db->getRoleById($this->_role);
	 }
	
	
	/** Setters for all variables **/
	
	/**
	 * Sets username for current user
	 * 
	 * @param string $username
	 * 
	 */
	 function setUsername($username = "")
	 {
	 	if(isset($username) && !empty($username))
			$this->_username = $username;
	 }
	 
	 /**
	  * Sets first name for current user
	  * 
	  * @param string $first_name
	  * 
	  */
	  function setFirstName($first_name = "")
	  {
	  	if(isset($first_name) && !empty($first_name))
			$this->_first_name = $first_name;
	  }
	  
	  /**
	   * Sets last name for current user
	   * 
	   * @param string $last_name
	   */
	   function setLastName($last_name = "")
	   {
	   	if(isset($last_name) && !empty($last_name))
			$this->_last_name = $last_name;
		
	   } 
	   
	   /** 
	    * Sets email for current user
	    * 
	    * @param string $email
	    */
	    function setEmail($email = "")
		{
		 if(isset($email) && !empty($email))
		 	$this->_email = $email;
		}
		
		/**
		 * Sets password for current user
		 * 
		 * @param string $password
		 * @return string 
		 */
		 function setPassword($password = "")
		 {
		 	if(isset($password) && !empty($password))
				$this->_hashword = crypt($password, Configuration::getSalt());
			return $this->_hashword;
		 }
		 
		 /**
		  * Sets role for current user
		  * 
		  * @param integer $role
		  * 
		  */
		  function setRole($role_id = 0)
		  {
		  	if($role_id > 0)
				$this->_role = $this->_db->getRoleById($role_id);
		  }
		  
		  
		  /**
		   * Static method that returns a user object from a username
		   * 
		   * @param string $username
		   * @return User
		   */
		   static function getUserByUsername($username = "")
		   {
		   	if($username === "")
				return false;
			return new User(Database::getInstance()->getUserByUsername($username));
		   }
		  
		  
	
}

?>