<?php

	class Database
	{
		// Class variables
		private static $_db, $_instance;
		private $_getPost, 
				$_getPosts,
				$_createPost,
				$_updatePost,
				$_createRole,
				$_updateRole,
				$_getRole, 
				$_getUser, 
				$_getUsers, 
				$_createUser,
				$_updateUser,
				$_pw_salt;
		
		function __construct()
		{
			// Get the password salt from config file
			$this->_pw_salt = Configuration::getSalt();
			
			// Try to connect to the database
			try
			{
				self::$_db = new PDO("mysql:host=".Configuration::getDatabaseHost().";dbname=".Configuration::getDatabaseName(), Configuration::getDatabaseUser(), Configuration::getDatabasePassword());
			}
			catch(PDOException $e)
			{
				echo $e->getMessage();
				die("Cannot connect to database!");
			}
			
			/** Prepare creation statements for users, posts, and roles **/
			
			$this->_createUser = self::$_db->prepare("INSERT INTO users (role, username, email, first_name, last_name, hashword, registration_date) VALUES (:role,:username,:email,:first_name,:last_name,:password,NOW());");
			$this->_createPost = self::$_db->prepare("INSERT INTO posts (author, title, content, date, published) VALUES (:author,:title,:content,NOW(),:published);");
			$this->_createRole = self::$_db->prepare("INSERT INTO roles (title, description, permission_level) VALUES (:title,:description,:permission_level);");
			
			
			/** Prepare get statements **/
			
			// Gets a single post by ID
			$this->_getPost = self::$_db->prepare("SELECT posts.id, posts.author, posts.title, posts.content, posts.date, posts.published, users.username, users.first_name, users.last_name, users.role, roles.title as rank FROM posts JOIN users ON (posts.author = users.id) JOIN roles ON (users.role = roles.id) WHERE posts.id = :id");
			
			// Gets all posts (with limit set, pass arguments for which row to start on and how many to list)
			$this->_getPosts = self::$_db->prepare("SELECT posts.id, posts.author, posts.title, posts.content, posts.date, posts.published, users.username, users.first_name, users.last_name, users.role, roles.title as rank FROM posts JOIN users ON (posts.author = users.id) JOIN roles ON (users.role = roles.id) ORDER BY posts.date DESC LIMIT :index, :count;");
			
			// Gets all users (with limit, pass arguments for which row to start on and how many to list)
			$this->_getUsers = self::$_db->prepare("SELECT users.id, users.username, users.hashword, users.first_name, users.last_name, users.role, roles.title as rank FROM users JOIN roles ON (users.role = roles.id) ORDER BY id ASC LIMIT :index, :count");
			
			// Gets a single user by ID
			$this->_getUser = self::$_db->prepare("SELECT users.id, users.username,  users.hashword, users.email, users.first_name, users.last_name, users.role, roles.title as rank FROM users JOIN roles ON (users.role = roles.id) WHERE users.id = :id");
			
			// Gets a single user by username
			$this->_getUserByUsername = self::$_db->prepare("SELECT users.id, users.username,  users.hashword, users.email, users.first_name, users.last_name, users.role, roles.title as rank FROM users JOIN roles ON (users.role = roles.id) WHERE users.username = :username");
			
			
			// Gets a single role by ID
			$this->_getRole = self::$_db->prepare("SELECT id,title,description, permission_level FROM roles WHERE id = :id");
			
			// Gets all roles
			$this->_getRole = self::$_db->prepare("SELECT title,description,permission_level FROM roles ORDER BY id DESC");
			
			
			/** Prepare update statements **/
			
			// Updates a post with new values -- post date never changes.
			$this->_updatePost = self::$_db->prepare("UPDATE posts SET author = :author, title = :title, content = :content, published = :published WHERE id = :id");
			
			// Updates a role with new values
			$this->_updateRole = self::$_db->prepare("UPDATE roles SET title = :title, description = :description, permission_level = :permission_level WHERE id = :id");
			
			// Updates a user with new values
			$this->_updateUser = self::$_db->prepare("UPDATE users SET role = :role, username = :username, email = :email, first_name = :first_name, last_name = :last_name, hashword = :password WHERE id = :id");
			
		
		
		}
		
		/**
		 * Creates a new user in the database table
		 * 
		 * @param integer $role
		 * @param string $username
		 * @param string $email
		 * @param string $first_name
		 * @param string $last_name
		 * @param string $hashed_pw
		 * @return integer user_id
		 */
		 function createUser($role, $username, $email, $first_name, $last_name, $hashed_pw)
		 {
			try
			{		 
		 		$this->_createUser->bindParam(':role',$role, PDO::PARAM_INT);
				$this->_createUser->bindParam(':username',$username);
				$this->_createUser->bindParam(':email', $email);
				$this->_createUser->bindParam(':first_name', $first_name);
				$this->_createUser->bindParam(':last_name', $last_name);
				$this->_createUser->bindParam(':password', $hashed_pw);
		 		$this->_createUser->execute();

				$user_id = self::$_db->lastInsertId();
				
				return $user_id;
			}
			catch(PDOException $exception)
			{
				echo "<h1> Well shit: " . $exception->getMessage() . "</h1>";
			}
		 }
		 
		/**
		 * Updates a user in the database
		 * @param integer $role
		 * @param string $username
		 * @param string $email
		 * @param string $first_name
		 * @param string $last_name
		 * @param string $hashed_pw
		 * @param integer $user_id
		 * @return integer user_id
		 */
		 function updateUser($role, $username, $email, $first_name, $last_name, $hashed_pw, $user_id)
		 {
		 	try
		 	{
				$this->_updateUser->bindParam(':role',$role, PDO::PARAM_INT);
				$this->_updateUser->bindParam(':username',$username);
				$this->_updateUser->bindParam(':email', $email);
				$this->_updateUser->bindParam(':first_name', $first_name);
				$this->_updateUser->bindParam(':last_name', $last_name);
				$this->_updateUser->bindParam(':password', $hashed_pw);
				$this->_updateUser->bindParam(':id',$user_id, PDO::PARAM_INT);
				$this->_updateUser->execute();
		 	}
			catch(PDOException $exception)
			{
				echo "<h1> Well shit: " . $exception->getMessage() . "</h1>";	
			}
		 }
		
		/**
		 * 	Returns the salt used for hashing passwords
		 * 
		 * @return string
		 */
		 function getSalt()
		 {
		 	return $this->_pw_salt;
		 }
		
		
		/**
		 * Creates a new Post in the Posts table
		 * Returns the post ID
		 * 
		 * @param integer $author
		 * @param string $title
		 * @param string $content
		 * @param integer $published
		 * @return integer
		 */
		function createPost($author = 0, $title, $content, $published)
		{
			try
			{
				self::$_db->beginTransaction();
				$this->_createPost->bindParam(':author', $author, PDO::PARAM_INT);
				$this->_createPost->bindParam(':title',$title);
				$this->_createPost->bindParam(':content', $content);
				$this->_createPost->bindParam(':published', $published, PDO::PARAM_BOOL);
				$this->_createPost->execute();
				$id = self::$_db->lastInsertId();
				self::$_db->commit();
				
				return $id;
			}
			catch(PDOException $e)
			{
				echo "<h1> Well shit: " . $exception->getMessage() . "</h1>";
			}
		}
		
		/**
		 * Updates an existing post
		 * 
		 * @param integer $author
		 * @param string $title
		 * @param string $content
		 * @param integer $published
		 * @param integer $post_id
		 * @return boolean
		 */
		function updatePost($author = 0, $title, $content, $published, $post_id)
		{
			try
			{
				$this->_updatePost->bindParam(':author',$author);
				$this->_updatePost->bindParam(':title',$title);
				$this->_updatePost->bindParam(':content',$content);
				$this->_updatePost->bindParam(':published',$published);
				$this->_updatePost->bindParam(':id',$post_id, PDO::PARAM_INT);
				$this->_updatePost->execute();
				
				return true;
			}
			catch(PDOException $e)
			{
				echo "<h1> Well shit: " . $exception->getMessage() . "</h1>";
				return false;
			}
		}
		 
		 
		/**
		 * Gets a Role by ID
		 * 
		 * @param integer $id
		 * @return array
		 */
		function getRoleById($id = 0)
		{
			if($id == 0)
				return;
			$this->_getRole->bindParam(':id',$id, PDO::PARAM_INT);
			$this->_getRole->execute();
			return $this->_getRole->fetch(PDO::FETCH_ASSOC);
		}
		
		/**
		 * Gets a user by ID and returns it as an associative array
		 * 
		 * @param integer $id
		 * @return array
		 */
		function getUserById($id = 0)
		{
			
			if($id == 0 || !is_numeric($id))
				return;
			
			$this->_getUser->bindParam(':id',$id, PDO::PARAM_INT);
			$this->_getUser->execute();
			$res = $this->_getUser->fetch(PDO::FETCH_ASSOC);
			return $res;
		}
		
		/**
		 * Gets a user by username and returns it as an associative array
		 * 
		 * @param string $username
		 * @return array
		 */
		function getUserByUsername($username)
		{
			if(!isset($username) || empty($username))
				return;
			
			$this->_getUserByUsername->bindParam(':username',$username);
			$this->_getUserByUsername->execute();
			return $this->_getUserByUsername->fetch(PDO::FETCH_ASSOC);
		}
		
		
		/**
		 * Gets a post by its ID and returns it as an associative array
		 * 
		 * @param integer $id
		 * @return array
		 */
		function getPostById($id = 0)
		{
			if($id == 0)
				return;
			$this->_getPost->bindParam(':id',$id, PDO::PARAM_INT);
			$this->_getPost->execute();
			return $this->_getPost->fetch(PDO::FETCH_ASSOC);
		}
		
		/**
		 * Gets a list of posts from the database from row $index to
		 * $count.
		 * Returns the list of posts as an associative array
		 * 
		 * @param integer $index Defines what row to start fetching from
		 * @param integer $count Defines how many rows to fetch
		 * @return array
		 */
		 function getPostList($index = 0, $count = 25)
		 {
		 	try
		 	{

		 		$this->_getPosts->bindParam(':index',$index, PDO::PARAM_INT);
				$this->_getPosts->bindParam(':count',$count, PDO::PARAM_INT);
				$this->_getPosts->execute();
				$val = $this->_getPosts->fetchAll(PDO::FETCH_ASSOC);
				
		 	}
			catch(PDOException $e)
			{
				echo "Woop! ".$e->getMessage();
			}
		 	
			
			return $val;
		 }
		
		/**
		 * Only allow one instance of this object to exist,
		 * it's simply unnecessary to create multiple connections to the database
		 * instead of just letting this static function return the only object necessary
		 * 
		 * @return Database
		 */
		static function getInstance()
		{
			if(!isset(self::$_instance))
				self::$_instance = new Database();
			return self::$_instance;
		}
		
	}
?>