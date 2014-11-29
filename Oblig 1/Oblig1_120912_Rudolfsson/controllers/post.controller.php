<?php


class PostController extends Controller
{
	function __construct()
	{
		// PHP doesn't call parent constructors automatically
		// so this one is just a dummy one until it needs something to do.
	}
	/**
	 * Lists all posts, and takes one single parameter passed
	 * in the array: the index of the last post displayed.
	 * This is used for pagination.
	 * 
	 * @param array $params
	 * 
	 */
	function all($params = array())
	{
		if(count($params)<1)
			$pagination = 25;
		else 
			if(is_array($params))
				$pagination = array_shift($params);
			else 
				$pagination = $params;
		if($pagination < 1)
			$pagination = 25;
		
		$post_list = Post::getPostList($pagination-25);
		$page_parameters = array("page_title" => Configuration::getSiteName(), "post_list" => $post_list);
		
		return array("page_title" => "Posts", "view" => "list", "params" => $page_parameters);
	}
	
	/**
	 * Displays a single post
	 * 
	 * @param mixed $params
	 * 
	 */
	 function show($params = array())
	 {
	 	// Check if it's an array, and if it's empty, default to first post
	 	if(count($params)<1)
			$id = 1;
		// Otherwise, check if $params is just a string or integer, and use it as an ID to fetch
		// the right post. Cast it to an int to check so that it's greater than 0
		else if((gettype($params) == "string" || gettype($params) == "integer") && (int) $params > 0)
			$id = $params;
		// Otherwise, if it is an array with multiple elements, take the first one out and use it as ID.
		else 
			$id = array_shift($params);
		
		$page_params["post"] = new Post($id);
		$page_params["page_title"] = $page_params["post"]->getTitle();
		
		return array("page_title" => $page_params["post"]->getTitle(), "view" => "show", "params" => $page_params);
	 }
	 
	 /**
	  * Wrapper function for createOrUpdate (to make URLs look nicer)
	  * This one is for creating a post
	  * 
	  * @param array $params
	  * @return array
	  */
	  function create($params = array())
	  {
	  	return $this->createOrUpdate($params);
	  }
	  
	  
	  /**
	   * Wrapper function for createOrUpdate, to make URLs look nicer
	   * This one is for updating a post.
	   */
	   function update($params = array())
	   {
	   	return $this->createOrUpdate($params);
	   }
	 
	 /**
	  * Allows the user to create a new post; shows the 
	  * page with the form for creating or updating a post.
	  * 
	  * @param mixed $params
	  * @return array
	  */
	  function createOrUpdate($params = array())
	  {
	  	$page_parameters = array();
		
		///////////////////////////////////////////////
		/* ADD CHECK FOR USERS PERMISSION LEVEL HERE */
		///////////////////////////////////////////////
		
	  	// Check if the parameters passed is an array, and if it has any elements
	  	// because if it is, it should contain a post object. Then we can just take it out,
	  	// and put it in to the $page_parameters array with the array key "post", 
	  	// which will be used in the view
	  	if(is_array($params) && count($params) > 0)
			$page_parameters["post"] = array_shift($params);
		
		// But if it's just a post object, we can use it straight away 
		else if(gettype($params) == "Post")
			$page_parameters["post"] = $params;
		
		// However ... if it's a string or an integer, we use that to try to find the post and create a
		// post object from its ID :)
		else if((gettype($params) == "string" || gettype($params) == "integer") && (int) $params > 0)
			$page_parameters["post"] = new Post((int) $params);
		
		// Otherwise, we dont have a post object. Then it's a new entry!
		else 
			$page_parameters["post"] = NULL;
		
		if($page_parameters["post"] != NULL)
			$page_title = $page_parameters["page_title"] = $page_parameters["post"]->getTitle();
		else 
		{
			$page_title = $page_parameters["page_title"] = "New entry";
			$page_parameters["post"] = new Post();
		}
		
	  	return array("page_title" => $page_title, "view" => "create", "params" => $page_parameters);
	  }
	  
	  
	  /**
	   * Action for creating a new post.
	   * After the post has been created, redirect the 
	   * user to the page displaying the post
	   * 
	   * @param array $params
	   */
	   function save($params = array())
	   {
	   	// We really shouldn't need any $params passed here, so we can 
	   	// discard them and instead fetch the data received from $_POST
		
	   	if(count($_POST) < 1 || (!array_key_exists("title",$_POST) || !array_key_exists("content",$_POST) || !array_key_exists("author", $_POST)))
			$this->redirect('post/all/');
		
		// Add date to the $_POST array
		$_POST["date"] = date("Y-m-d H:i:s", time());
		
		// Create the post (if it already has an ID, it will be updated in the database with the new values)
		$post = new Post($_POST);
		
		// Save the post and get the posts ID
		$id = $post->save();
		
		// Redirect to display the newly created post
		$this->redirect('index.php?route=post/show/' . $id);
	   }
	 
	
}

?>