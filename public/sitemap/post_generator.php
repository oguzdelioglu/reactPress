<?php
require __DIR__ . "/../config.php";
require __DIR__ . "/../include/functions.php";
// Set your custom table name to generate 
$table_name  = "pinlist";
// Set your custom column name to generate 
$column_name  = "post_link";
$column_name2  = "pin_title";
// Your site Base URL
$date_name  = "post_date";
$base_url = $domain . $posturl . "/";
//$base_url = $domain;
$frequency = "monthly";
// These are the static/page/subdirectories you need to include in the site map
$static_pages = array("", "menu#about", "menu#privacy-policy", "menu#terms-of-service", "menu#contact");
// END CONFIGURATION
/*if($_GET["token"] != $token){
		die("Not Authorized");
	}
	*/




try {
	$connection = dbbaglan();
	$result = "SELECT $column_name" . ($date_name != "" ? "," . $date_name : "") . "," . $column_name2 . " FROM $table_name";
	$statement = $connection->prepare($result);
	$statement->execute();
	$result = $statement->fetchAll();
	$totalResult = count($result);
	if (!$totalResult > 0) die("İçerik Yok");
	/*foreach ($static_pages as $page ) {
			generate_elements($page);
		}*/

	$count = 0;
	$i = 0;
	$j = 1;
	$binigecti = 0;
	$yenigeldim = 1;

	foreach ($result as $res) {
		if ($yenigeldim == 1) {
			echo "İlk Gelişim." . $j . PHP_EOL;
			$dom = new DomDocument('1.0', 'UTF-8');
			$root = $dom->appendChild($dom->createElement('urlset'));
			$root->appendChild($dom->createAttribute("xmlns"))->appendChild($dom->createTextNode('http://www.sitemaps.org/schemas/sitemap/0.9'));
			$root->appendChild($dom->createAttribute("xmlns:image"))->appendChild($dom->createTextNode('http://www.google.com/schemas/sitemap-image/1.1'));
			//Insert Main Domain
			$date = date('c', time());
			$url = $dom->createElement('url');
			$root->appendChild($url);
			$loc = $dom->createElement('loc', $domain);
			$url->appendChild($loc);
			$lastmod = $dom->createElement('lastmod', $date);
			$url->appendChild($lastmod);
			$changefreq = $dom->createElement('changefreq', 'always');
			$url->appendChild($changefreq);
			$priority = $dom->createElement('priority', '1.0');
			$url->appendChild($priority);
			//Insert Main Domain

			$yenigeldim = 0;
		}

		$curr["url"] = cleanQuery($res[$column_name]);
		$curr["title"] = cleanQuery($res[$column_name2]);
		//echo $curr["title"] . "<br>";
		if (isset($res[$date_name])) {
			$date = $res[$date_name];
			generate_elements($curr, $date);
		} else {
			generate_elements($curr);
		}

		// if ($j == 1) {
		// 	$yenigeldim = 0;
		// }

		$i++;
		$PageMax = $j * 1000;
		echo "i=" . $i . " j=".$j." Total:" . $totalResult . " | " . ($totalResult - $i) . " | " . $PageMax."|". ($PageMax-$totalResult)."<br>" . PHP_EOL;
		$boolLastPage = false;
		$KalanSayfa = ($PageMax - $totalResult);
		echo "Kalan Sayfa:".$KalanSayfa."<br>";
		 if($totalResult > 1000 & $j > 1 & $KalanSayfa > 0 & $KalanSayfa == ($PageMax-$totalResult) & ($PageMax - $count) == $KalanSayfa ){
			echo "Durum Pozitif";
			$boolLastPage = true;
		 }else{
			//echo "Durum Negatif";
			$boolLastPage = false;
		 }
		if ($i == 1000 || $boolLastPage) {
			echo $boolLastPage ? 'true' : 'false';
			echo " Sayfa Oluşturuldu. i=" . $i ." | j=".$j."<br>" . PHP_EOL;
			$dom->formatOutput = true;
			$test1 = $dom->saveXML();
			$dom->save(__DIR__ . "/posts" . $j . ".xml");
			$dom = new DomDocument('1.0', 'UTF-8');
			$root = $dom->appendChild($dom->createElement('urlset'));
			$root->appendChild($dom->createAttribute("xmlns"))->appendChild($dom->createTextNode('http://www.sitemaps.org/schemas/sitemap/0.9'));
			$root->appendChild($dom->createAttribute("xmlns:image"))->appendChild($dom->createTextNode('http://www.google.com/schemas/sitemap-image/1.1'));
			$j++;
			$i = 0;
			$binigecti = 1;
			if($boolLastPage){
				echo "Sayfa Sonuna Ulaşıldı.<br>";
				break;
			}
			
		}
	}

	// if ($binigecti == 0) {
	// 	$dom->formatOutput = true;
	// 	$dom->saveXML();
	// 	$dom->save(__DIR__ . "/posts1.xml");
	// }

	echo "<h2>Total Pages Added to sitemap :  $count</h2>";


	$connection = null;
} catch (Exception $e) {
	echo $e->getMessage();
	echo ("Can't open the database.");
}


function generate_elements($curr, $date = null)
{
	//if($date == null)
	$date = date('c', time());
	global $base_url, $frequency, $root, $dom, $count, $domain;
	$url = $dom->createElement('url');
	$root->appendChild($url);
	$loc = $dom->createElement('loc', $base_url . $curr["url"]);
	$url->appendChild($loc);
	$lastmod = $dom->createElement('lastmod', $date);
	$url->appendChild($lastmod);
	$changefreq = $dom->createElement('changefreq', $frequency);
	$url->appendChild($changefreq);
	$priority = $dom->createElement('priority', '0.8');
	$url->appendChild($priority);

	$img = $domain . "uploads/" . $curr["url"] . ".jpg";

	if (file_exists(realpath(dirname(__FILE__) . '/../uploads/' . $curr["url"] . '.jpg'))) {
		//echo $img."<br>";
		$image = $dom->createElement('image:image');
		$url->appendChild($image);
		$imageurl = $dom->createElement('image:loc', $img);
		$imagecaption = $dom->createElement('image:caption', $curr["title"]);
		$imagetitle = $dom->createElement('image:title', $curr["title"]);
		$image->appendChild($imageurl);
		$image->appendChild($imagecaption);
		$image->appendChild($imagetitle);
	}
	$count++;
}