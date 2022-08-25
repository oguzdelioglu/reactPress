<?php
require __DIR__ . "/../config.php";

// Set your custom table name to generate 
$table_name  = "tags";
// Set your custom column name to generate 
$column_name  = "tag_name";
// Your site Base URL
$date_name  = "";

$base_url = $domain . "category/";
$frequency = "hourly";
// These are the static/page/subdirectories you need to include in the site map
$static_pages = array();

// END CONFIGURATION
/*if($_GET["token"] != $token){
		die("Not Authorized");
	}*/


try {
	$connection = dbbaglan();
	$result = "SELECT $column_name" . ($date_name != "" ? "," . $date_name : "") . " FROM $table_name WHERE tag_category = 1";
	$statement = $connection->prepare($result);
	$statement->execute();
	$result = $statement->fetchAll();

	$count = 0;
	$i = 0;
	$j = 1;
	$binigecti = 0;
	$yenigeldim = 1;

	foreach ($result as $res) {
		if ($yenigeldim == 1) {
			$dom = new DomDocument('1.0', 'UTF-8');
			$root = $dom->appendChild($dom->createElement('urlset'));
			$attr = $dom->createAttribute('xmlns');
			$attr->appendChild($dom->createTextNode('http://www.sitemaps.org/schemas/sitemap/0.9'));
			$root->appendChild($attr);
			$yenigeldim = 0;
		}

		$curr =  str_replace(" ", "-", $res[$column_name]);
		if (isset($res[$date_name])) {
			$date = $res[$date_name];
			generate_elements($curr, $date);
		} else {
			generate_elements($curr);
		}

		$i++;
		if ($i >= 10000) {
			$dom->formatOutput = true;
			$test1 = $dom->saveXML();
			$dom->save(__DIR__ . "/category" . $j . ".xml");

			$j++;
			$i = 0;
			$binigecti = 1;
			$yenigeldim = 1;
		}
	}

	if ($binigecti == 0) {
		$dom->formatOutput = true;
		$dom->saveXML();
		$dom->save(__DIR__ . "/category.xml");
	}

	echo "<h2>Total Pages Added to sitemap :  $count</h2>";




	$connection = null;
} catch (Exception $e) {
	echo ("Can't open the database.");
}


function generate_elements($curr, $date = null)
{
	if ($date == null)
		$date = date('c', time());

	global $base_url, $frequency, $root, $dom, $count;
	$url = $dom->createElement('url');
	$root->appendChild($url);
	$loc = $dom->createElement('loc', $base_url . $curr);
	$url->appendChild($loc);
	$lastmod = $dom->createElement('lastmod', $date);
	$url->appendChild($lastmod);
	$changefreq = $dom->createElement('changefreq', $frequency);
	$url->appendChild($changefreq);
	$priority = $dom->createElement('priority', '1.0');
	$url->appendChild($priority);
	$count++;
}
