<?php

class Post
{
	private $_db, $_id, $_title, $_content, $_author, $_date, $_published;
	
	function __construct($id = 0)
	{
		$this->_db = Database::getInstance();
		// If ID is an array, it's time for mass-assignment creation ;)
		if(is_array($id))
			$this->_massAssign($id);
		// ... but if ID is an actual ID, we fetch that post before mass-assignment
		else if(is_numeric($id) && $id > 0)
			$this->_massAssign($this->_db->getPostById($id));
		else {
			// Set all values to 0 / empty and allow the object to be 
			// manually set up
			
			$this->_id = $this->_author = $this->_date = $this->_published = 0;
			$this->_content = $this->_title = "";
		}
	}
	
	
	/**
	 * Mass assigns a Post object; takes an array and
	 * checks if an ID is set, and updates the post with that ID
	 * if it does -- otherwise creates a new post with the specified
	 * values.
	 * 
	 * 
	 * @param array $parameters
	 * @return integer
	 */
	 private function _massAssign($parameters)
	 {
	 	// Check so that all parameters actually exist in the array
	 	// before creating from it
	 	
	 	if(array_key_exists("title",$parameters) && array_key_exists("content",$parameters) && array_key_exists("author", $parameters) && array_key_exists("date",$parameters) && array_key_exists("published",$parameters))
		{
			$this->setTitle($parameters["title"]);
			$this->setContent($parameters["content"]);
			$this->setAuthor($parameters["author"]);
			$this->setDate($parameters["date"]);
			$this->setPublished($parameters["published"]);
			
			
			if(array_key_exists("id",$parameters) && $parameters["id"] > 0)
				$this->_id = $parameters["id"];
			
		}
	 }
	 
	 /**
	  * Saves the current post to the database
	  * and returns the ID for the post
	  * 
	  * @return integer
	  */
	  function save()
	  {
	  	if(isset($this->_id) && $this->_id > 0)
			$this->_db->updatePost($this->getAuthor()->getID(), $this->getTitle(), $this->getContent(), $this->isPublished(), $this->getID());
		else 
			$this->_id = $this->_db->createPost($this->getAuthor()->getID(), $this->getTitle(), $this->getContent(), $this->isPublished());
		
		return $this->_id;
	  }
	 
	 
	 /** Getters for all variables **/
	 
	 /**
	  * Gets the ID for the current post object
	  * 
	  * @return integer
	  */
	  function getID()
	  {
	  	return $this->_id;
	  }
	  
	  
	 /**
	  * Gets the title for the current post object
	  * 
	  * @return string
	  */
	  function getTitle()
	  {
	  	return $this->_title;
	  }
	  
	  /**
	   * Gets the content for the current post object
	   * 
	   * @return string
	   */
	  function getContent()
	  {
	  	return $this->_content;
	  }
	  
	 /**
	  * Gets the timestamp for the current post object
	  * 
	  * @return integer
	  */
	  function getDate()
	  {
		
	  	return $this->_date;
	  }
	  
	  /**
	   * Returns a 1 (true) if the post is published,
	   * and a 0 (false) if the post isn't.
	   * 
	   * @return boolean
	   */
	  function isPublished()
	  {
	  	return ($this->_published == 1);
	  }
	  
	 /**
	  * Gets the user object for the post's author
	  * 
	  * @return User
	  */
	  function getAuthor()
	  {
	  	return $this->_author;
	  } 
	 
	 /**
	  * Sets the title for the post
	  * 
	  * @param string $title
	  * 
	  */
	  function setTitle($title = "")
	  {
	  	if(isset($title) && !empty($title))
			$this->_title = $title;
		
	  }
	  
	  /**
	  * Sets the content for the post
	  * 
	  * @param string $content
	  * 
	  */
	  function setContent($content = "")
	  {
	  	if(isset($content) && !empty($content))
			$this->_content = $content;
		
	  }
	  
	  /**
	  * Sets the date for the post (defaults to now)
	  * 
	  * @param integer $date
	  * 
	  */
	  function setDate($date = 0)
	  {
	  	if($date === 0)
			$date = time();
		
	  	if(isset($date) && $date > 0)
			$this->_date = $date;
		
	  }
	  
	  /**
	  * Sets the published value for the post,
	  * indicating whether or not the post is 
	  * supposed to be shown publicly. 
	  * 
	  * @param string $published
	  * 
	  */
	  function setPublished($published = 1)
	  {
	  	if(isset($published) && ($published == 1 || $published == 0 || $published == true || $published == false))
			$this->_published = $published;
		
	  }
	  
	  /**
	  * Sets the author for the post
	  * 
	  * @param integer $author
	  * 
	  */
	  function setAuthor($author = 0)
	  {
	  	if($author > 0)
			$this->_author = new User($author);
	  }
	  
	  
	  /**
	   * Gets a list of maximum 25 posts starting at $index
	   * 
	   * @param integer $index
	   */
	   static function getPostList($index)
	   {
	   	$posts = Database::getInstance()->getPostList($index);
		
		$post_list = array();
		
		foreach($posts as $p)
			$post_list[] = new Post($p);
		
		return $post_list;
	   }
	
}

?>