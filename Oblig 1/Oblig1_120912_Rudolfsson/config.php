<?php
/**
 * Configuration class; only one instance of this
 * may exist at any given time.
 * 
 * Contains all "static" parameters for the site.
 * 
 */
class Configuration {
	
	static private $_site_name = "Blogathor", 
			$_site_slogan = "Simple Open Blog Platform",
			$_database_host = "127.0.0.1",
			$_database_user = "datamodellering",
			$_database_password = "lolphpwhynotrails?",
			$_database_name = "oblig",
			$_salt = "ph'nglui mglw'nafh C'thulhu R'lyeh wgah'nagl fhtagn",
			$_view_directory = "views/",
			$_model_directory = "models/",
			$_controller_directory = "controllers/",
			$_javascript_directory = "assets/javascript/",
			$_stylesheet_directory = "assets/stylesheets/";
	
	static function getSiteName()
	{
		return self::$_site_name;
	}
	
	static function getSiteSlogan()
	{
		return self::$_site_slogan;
	}
	
	static function getSalt()
	{
		return self::$_salt;
	}
	
	static function getViewDirectory()
	{
		return self::$_view_directory;
	}
	
	static function getModelDirectory()
	{
		return self::$_model_directory;
	}
	
	static function getControllerDirectory()
	{
		return self::$_controller_directory;
	}
	
	static function getJavaScriptDirectory()
	{
		return self::$_javascript_directory;
	}
	
	static function getStylesheetDirectory()
	{
		return self::$_stylesheet_directory;
	}
	
	static function getDatabaseName()
	{
		return self::$_database_name;
	}
	
	static function getDatabaseUser()
	{
		return self::$_database_user;
	}
	
	static function getDatabasePassword()
	{
		return self::$_database_password;
	}
	
	static function getDatabaseHost()
	{
		return self::$_database_host;
	}
	
}

?>
