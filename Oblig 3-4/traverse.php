<?php
  $xml_file = file_get_contents("http://www.aftenposten.no/rss/?kat=nyheter_uriks");

  $doc = new DOMDocument;
  
  // Ideally, we would not do this; instead we'd use $doc->loadXML($xml_file)
  // but this wouldn't work for me as PHP complained the XML retrieved from
  // aftenposten.no was not well-formed XML. Loading it as HTML (which does not require
  // it to be well-formed and then saving it as XML works). 
  // For some reason, it also works by manually saving the xml and opening it from file.
  $doc->loadHTML($xml_file);
  

  $xpath = new DOMXPath($doc);
  $title = $xpath->query("//channel/title")->item(0)->textContent;
  
  $item_count = $xpath->evaluate("count(//channel/item)"); 
?>

<html>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<head>
		<title><?php echo $title; ?></title>
		<style type="text/css">
			body
			{
				background: #DDD;
			}
			div#wrapper
			{
				background: #ECECEC;
				width: 800px;
				margin: auto auto;
			}
			
			div#wrapper .item
			{
				color: #555;
				width: 390px;
				padding: 5px;
				position: relative;
				float: left;
				border-bottom: 1px solid #CCC;
				min-height: 350px;
			}
			
			.item a.readmore
			{
				color: orange;
				text-decoration: none;
			}
			
			.item .pubdate
			{
				font-size: small;
				margin-bottom: 0px;
			}
			
		</style>
	</head>
	<body>
	<h1>aftenposten.no - Innenriks</h1>
		<div id='wrapper'>
			<?php
				$i = 1;
  				while($i <= $item_count)
  				{
  					// Set up all important variables
  					$item_title = $xpath->query("//channel/item[$i]/title")->item(0)->textContent;
					$item_description = $xpath->query("//channel/item[$i]/description")->item(0)->textContent;
					$publication_date = $xpath->query("//channel/item[$i]/pubDate")->item(0)->textContent;
					$url = $xpath->query("//channel/item[$i]/link")->item(0)->textContent;
					$img = $xpath->query("//channel/item[$i]/enclosure[@type='img/jpg']/@url");
					
	
					// Create element for displaying this item
					echo "<div class='item'>";
	
					// Print title
					echo "<h2>" . $item_title . "</h2>";
					
					// Print image (if any)
					if($img->length > 0)
						echo "<p><img src='".$img->item(0)->textContent."' /></p>";
					
					// Print description
					echo "<p>" . $item_description . "</p>";
					
					// Print read more link
					echo "<p><a href='".$url."' class='readmore'>Read more</a></p>";
					
					// Print publication date
					echo "<p class='pubdate'>Published: ".$publication_date."</p>";
					
					echo "</div>";
	
  					$i++;
  				}
			?>	
		</div>
	</body>
</html>