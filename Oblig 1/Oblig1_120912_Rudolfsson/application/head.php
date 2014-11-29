<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Blogathor | <?php echo $base_controller->getPageTitle(); ?></title>
	
		
<?php


// First, include all stylesheets in the assets/stylesheets directory
foreach($stylesheets as $css)
{
	if(strstr($css,".style.css"))
		echo "<link href='".Configuration::getStylesheetDirectory().$css."' type='text/css' rel='stylesheet' /> 
		";
}

// Now, look if there's a stylesheet in assets/stylesheets/views for the specific view -- 
// views can override previous CSS on a per-view basis.
if(file_exists(Configuration::getStylesheetDirectory() . $view_name.".style.css"))
	echo "<link href='" . Configuration::getStylesheetDirectory() . $view_name ."style.css' type='text/css' rel='stylesheet' /> 
		";
		
// After including stylesheets, include all javascripts
foreach($javascripts as $js)
{
	if(strstr($js,".js"))
		echo "<script src='".Configuration::getJavaScriptDirectory().$js."' type='text/javascript'></script> 
		";
}

// Finally, after everything is included, initiate tinyMCE editor
?>

<script type="text/javascript">
tinymce.init({
    selector: "textarea"
 });
</script>
	</head>
