<?php
//include('config.php');
$domain = 'https://edelsteineinformationen.com/';
$parse = get_domaininfo($domain);

//KİŞİSEL AYARLAR
$domainurl = empty($parse['subdomain'])?$parse['domain']:$parse['subdomain'].".".$parse['domain']; //Domain
$smallname = $parse['host'];     //Domain User

$sitebaslangıc = 1;         //SUBDOMAİN BAŞLANGIÇ
$sitebitis     = 100;       //SUBDOMAİN BİTİŞ
for($i = $sitebaslangıc; $i <= $sitebitis; $i++) 
{
	$sub = '';
	$sub_dom = $sub.$i;
	$subdomainname = $sub_dom.".".$domainurl;
	$domain = "https://$sub_dom.".$domainurl.'/';
    $path = "/home/" . $smallname . '/'.$subdomainname.'/bot/repairimage.php';
    echo $domainurl." | ".$smallname." | ". $path .PHP_EOL;
    if(!file_exists($path))die("Bitti");
    exec('php '.$path);
}
function get_domaininfo($url) {
    // regex can be replaced with parse_url
    preg_match("/^(https|http|ftp):\/\/(.*?)\//", "$url/" , $matches);
    $parts = explode(".", $matches[2]);
    $tld = array_pop($parts);
    $host = array_pop($parts);
    if ( strlen($tld) == 2 && strlen($host) <= 3 ) {
        $tld = "$host.$tld";
        $host = array_pop($parts);
    }

    return array(
        'protocol' => $matches[1],
        'subdomain' => implode(".", $parts),
        'domain' => "$host.$tld",
        'host'=>$host,'tld'=>$tld
    );
}