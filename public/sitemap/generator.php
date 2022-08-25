<?php
set_time_limit(0);
include __DIR__ . "/../config.php";
$dir = __DIR__ . "/";
$base_url = $domain . "sitemap/";
foreach (new DirectoryIterator($dir) as $fileInfo) {
	if ($fileInfo->getExtension() == "xml") {
		//echo $fileInfo->getFilename().PHP_EOL;
		//echo $fileInfo->getPathname().PHP_EOL;
		unlink($fileInfo->getPathname());
	}
}
$post_generator = exec('php ' . $dir . 'post_generator.php');
$tag_generator =  exec('php ' . $dir . 'tag_generator.php');
//die();
$dom = new DomDocument('1.0', 'UTF-8');
$root = $dom->appendChild($dom->createElement('sitemapindex'));
$attr = $dom->createAttribute('xmlns');
$attr->appendChild($dom->createTextNode('http://www.sitemaps.org/schemas/sitemap/0.9'));
$root->appendChild($attr);

foreach (new DirectoryIterator($dir) as $fileInfo) {
	if ($fileInfo->getExtension() == "xml") {
		$date = date("Y-m-d");
		global $base_url, $frequency, $root, $dom;
		$url = $dom->createElement('sitemap');
		$root->appendChild($url);
		$loc = $dom->createElement('loc', $base_url . $fileInfo->getFilename());
		$url->appendChild($loc);
		$lastmod = $dom->createElement('lastmod', $date);
		$url->appendChild($lastmod);
	}
}
$dom->formatOutput = true;
$test1 = $dom->saveXML();
$dom->save($dir . "sitemap.xml");
echo "TAMAMLANDI";
$sitemaps = array();
foreach (new DirectoryIterator($dir) as $fileInfo) {
	if ($fileInfo->getExtension() == "xml") {
		array_push($sitemaps, $domain . "sitemap/" . $fileInfo->getFilename());
	}
}


foreach ($sitemaps as $sitemapUrl) {
	$sitemapUrl = htmlentities($sitemapUrl);
	//Google  
	$url = "http://www.google.com/webmasters/sitemaps/ping?sitemap=" . $sitemapUrl;
	SubmitSiteMap($url);
	//Bing / MSN
	$url = "http://www.bing.com/webmaster/ping.aspx?siteMap=" . $sitemapUrl;
	SubmitSiteMap($url);
	// Live
	$url = "http://webmaster.live.com/ping.aspx?siteMap=" . $sitemapUrl;
	SubmitSiteMap($url);
	// moreover
	$url = "http://api.moreover.com/ping?sitemap=" . $sitemapUrl;
	SubmitSiteMap($url);
}

// cUrl handler to ping the Sitemap submission URLs for Search Engines…
function Submit($url)
{
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_exec($ch);
	$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	return $httpCode;
}
function SubmitSiteMap($url)
{
	$returnCode = Submit($url);
	if ($returnCode != 200) {
		echo "Error $returnCode: $url <BR/>";
	} else {
		echo "Submitted $returnCode: $url <BR/>";
	}
}
