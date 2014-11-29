<?php 
	// If we have no search string, display the search page.
	if(!isset($_GET['varenummer']) || empty($_GET['varenummer'])): 
	?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Oblig 6 - Oppgave 1</title>
		<style type="text/css">
			#wrapper
			{
				width: 305px;
				height: 75px;
				position: absolute;
				top: 50%;
				left: 50%;
				margin-left: -150px;
				margin-top: -37px;
				
			}
			#wrapper input[type="text"]
			{
				height: 70px;
				width: 230px;
				font-size: 30px;
				color: #555;
			}
			#wrapper input[type="submit"]
			{
				height: 70px;
				width: 70px;
				font-size: 30px;
				color: #555;
			}
		</style>
	</head>
	<body>
		<div id="wrapper">
			<form action="index.php" method="GET">
				<input type="text" name="varenummer" />
				<input type="submit" value="Søk" />
			</form>
			<small>Tip: Comma separate product IDs to search for more than one</small>
		</div>
	</body>
</html>
<?php
// Else, display the XML document
else:
	header("Content-type: text/xml; charset=utf-8");
	date_default_timezone_set('Europe/Oslo');
	// Open database connection
	$db = new PDO("mysql:host=localhost;dbname=oblig6", "oblig6", "caL4UzGhEEVPXqvV");
	
	// Get IDs from GET variable and strip off whitespaces
	$raw_ids = preg_replace("/\s+/","",$_GET['varenummer']);
	
	// Set up a new XML document with our Butikkdata DTD
	$implementation = new DOMImplementation;
	$document = $implementation->createDocument(null, "Butikkdata", $implementation->createDocumentType("Butikkdata", '', "Butikkdata.dtd"));
	
	// Set date attribute for document root
	$document->documentElement->setAttribute("dato",date("Y-m-d",time()));
	
	// Set xmlns:xsi and xsi:noNamespaceSchemaLocation attributes for document root
	$document->documentElement->setAttribute("xmlns:xsi","http://www.w3.org/2001/XMLSchema-instance");
	$document->documentElement->setAttribute("xsi:noNamespaceSchemaLocation","Butikkdata.xsd");
	
	// Create Produkter, which will be parent of all Produkt elements.
	$Produkter = $document->createElement("Produkter");	
	$document->documentElement->appendChild($Produkter);
	
	
    // Fetch IDs from GET variable, and split to array if needed
    $ids = (strstr($raw_ids,",") ? explode(",",$raw_ids) : $raw_ids);
	
	// Prepare the statement, to escape the values
	if(is_array($ids))
	{
		$query = $db->prepare("SELECT Produkt.varenummer, Produkt.navn, Produkt.pris, detail.tekst, detail.detaljnummer FROM Produkt JOIN ProduktDetalj as detail ON (detail.varenummer = Produkt.varenummer) WHERE Produkt.varenummer IN (" . str_repeat('?,', count($ids) - 1) . '?'.")");
		$query->execute($ids);
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
	}	
	else 
	{
		$query = $db->prepare("SELECT Produkt.varenummer, Produkt.navn, Produkt.pris, detail.tekst, detail.detaljnummer FROM Produkt JOIN ProduktDetalj as detail ON (detail.varenummer = Produkt.varenummer) WHERE Produkt.varenummer = ?");
		$query->execute(array($ids));
		$results = $query->fetchAll(PDO::FETCH_ASSOC);
	}
	
	// keep a list of already processed products
	$added_products = array();
	
	
	// Add all Produkt elements to the document
	foreach($results as $row)
	{
		// If we haven't encountered this product before,
		// create an element for it and add all basic information
		if(!in_array($row["varenummer"],$added_products))
		{
			$added_products[] = $row["varenummer"];
			$current_product = $document->createElement("Produkt");
			$Produkter->appendChild($current_product);
			
			
			// Add varenummer element
			$current_product->appendChild(
										  $document->createElement("Varenummer",$row["varenummer"])
											);
			// Add Navn element
			$current_product->appendChild(
										  $document->createElement("Navn",$row["navn"])
										  	);
			
			// Add Pris element
			$tmpris = $document->createElement("Pris",$row["pris"]);
			$tmpris->setAttribute("myntenhet","NOK");
			$current_product->appendChild($tmpris);
			
			
			
		}
		// add the DetaljInfo element
		$current_product->appendChild(
									  $document->createElement("DetaljInfo",$row["tekst"])
										);
		
	}
	
	// Output as XML
	echo $document->saveXML();
	
	//echo $document->validate();
endif;
?>