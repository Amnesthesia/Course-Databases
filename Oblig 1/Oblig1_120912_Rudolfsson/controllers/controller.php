<?php


class Controller
{
	
	private $_page_title, $_view, $_params;	
	
	function __construct()
	{
		
		if(isset($_GET['route']) && !empty($_GET['route']))
			$route = $_GET['route'];
		else
			$route = "post/all/";
			
		
		
		// Split the route and get the controller keyword
		$split_route = explode("/",$route);
		
		// Make the first character of the class' name uppercase
		$controller_name = ucfirst(array_shift($split_route));
		
		
		// Append "Controller" to the class' name
		$controller_name .= "Controller";
		
		// Get the view (second in the argument list)
		$view_name = array_shift($split_route);
		
		// The rest of $split_route contains all the other parameters, after the controller
		// and the view has been taken out. However, we could also have $_POST parameters we wish to make use of,
		// but these will be taken care of by the action in question
		
		// Check so that $controller_name exists as a class and is a child-class of Controller
		if(class_exists($controller_name) && in_array("Controller", class_parents($controller_name)))
		{
			
			
			try
			{
				// Call the controller's view function for the specified view (always lowercase)
				// and pass the rest of the $route's arguments to it
			
				$controller = new $controller_name;
				
				$vital_parameters = call_user_func_array(array($controller,$view_name),$split_route);
			
				// All view "actions" must return an array consisting of the view to display
				// and the parameters to pass to that view.
				$this->_page_title = $vital_parameters["page_title"];
				$this->_view = $vital_parameters["view"];
				
				$this->_params = $vital_parameters["params"];
			}
			catch(Exception $e)
			{
				echo "Woops! " . $e->getMessage();
			}
			
			
		}
		
		
		
	}
	
	/**
	 * Redirects the page to a new page
	 * 
	 * @param string $url
	 * 
	 */
	 function redirect($url)
	 {
	 	header("Location: " . $url);
	 }
	 
	 /**
	  * Returns the title of the page set by the child-controller
	  * 
	  * @return string
	  */
	  function getPageTitle()
	  {
	  	return $this->_page_title;
	  }
	 
	 /**
	  * Returns the name of the view to display
	  * 
	  * @return string
	  */
	  function getView()
	  {
	  	return $this->_view;
	  }
	  
	  /**
	   * Returns the parameters to pass to the view
	   * 
	   * @return array
	   */
	   function getViewParameters()
	   {
	   	return $this->_params;
	   }
}
?>