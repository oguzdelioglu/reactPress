<?php
header('Access-Control-Allow-Origin: *');
//Fazla Kurcalama
//ini_set('display_errors', 0);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('Europe/Istanbul');
define("ROOT", __DIR__);
$ServerSaati=gmdate('Y-m-d H:i:s', time() + 3600 * 3);
//Fazla Kurcalama


//Site Bilgileri
$domain="";
$AnalyticsUA="";
$GoogleADS="";
//Site Bilgileri


//Veritabanı Bilgileri
$host="";
$username="";
$password="";
$dbname="";
$port="";
//Veritabanı Bilgileri


//Script Özel Ayarlar
$posturl="post";
$searchurl="search";
$author="ODELProject";
$imgFolder="images/posts/";
$pinSearchCount=5;
$findgoApi="";
$postType="instagram";
//Script Özel Ayarlar

$dsn       ="mysql:host=$host;dbname=$dbname;port=$port";
$options   =array(
    PDO::ATTR_ERRMODE    => PDO::ERRMODE_SILENT,
    PDO::ATTR_PERSISTENT => false, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', PDO::ATTR_PERSISTENT => FALSE, PDO::ATTR_EMULATE_PREPARES => FALSE
);
function clean2($string)
{
    $string=str_replace(' ', ' ', $string);
    $string=preg_replace('/[^A-Za-z0-9\-ığşçöüÖÇŞİıĞ]/', '', $string);
    return preg_replace('/-+/', '-', $string);
}

function my_server_url()
{
    $server_name=$_SERVER['SERVER_NAME'];

    if (!in_array($_SERVER['SERVER_PORT'], [80, 443])) {
        $port=":$_SERVER[SERVER_PORT]";
    } else {
        $port='';
    }

    if (!empty($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) == 'on' || $_SERVER['HTTPS'] == '1')) {
        $scheme='https';
    } else {
        $scheme='http';
    }
    return $scheme . '://' . $server_name . $port;
}

function humantime($tarih)
{
    try {
        //$date1=new DateTime( date('Y-m-d H:i:s') );
        $date1=new DateTime(gmdate('Y-m-d H:i:s', time() + 3600 * 3));
        $date2=new DateTime($tarih);
        $interval=$date1->diff($date2);
        $result=$interval->format('%y yıl %m ay %d gün %h saat %i dakika %s saniye');
        $result=preg_replace('/\b0+\s+[a-zA-Z-ıü]+,?\s*/is', '', $result);
        return $result;
    } catch (Exception $e) {
        return false;
    }
}


function clearTerminal()
{
    if (strncasecmp(PHP_OS, 'win', 3) === 0) {
        popen('cls', 'w');
    } else {
        exec('clear');
    }
}

function Yaz($str)
{
    ob_start();
    sleep(0);
    echo $str;
    ob_end_flush();
    @ob_flush();
    flush();
}

function ClearMemory()
{
    //Memory cleanup for long-running scripts.
    gc_enable(); // Enable Garbage Collector
    var_dump(gc_enabled()); // true
    var_dump(gc_collect_cycles()); // # of elements cleaned up
    gc_disable(); // Disable Garbage Collector
}

function Unsetter()
{
    $vars=array_keys(get_defined_vars());
    for ($i=0; $i < sizeOf($vars); $i++) {
        unset($$vars[$i]);
    }
    unset($vars, $i);
}

function dbbaglan()
{
    try {
        global $dsn, $username, $password, $options;
        //echo $dsn." ".$username." ".$password.PHP_EOL;
        $conn=new PDO($dsn, $username, $password, $options);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        echo 'Connection failed: ' . $e->getMessage();
        exit;
    }
}

function Memory_Usage($decimals=1)
{
    $result=0;
    if (function_exists('memory_get_usage')) {
        $result=memory_get_usage() / 1024;
    } else {
        if (function_exists('exec')) {
            $output=array();
            if (substr(strtoupper(PHP_OS), 0, 3) == 'WIN') {
                exec('tasklist /FI "PID eq ' . getmypid() . '" /FO LIST', $output);
                $result=preg_replace('/[\D]/', '', $output[5]);
            } else {
                exec('ps -eo%mem,rss,pid | grep ' . getmypid(), $output);
                $output=explode('  ', $output[0]);
                $result=$output[1];
            }
        }
    }
    return number_format(intval($result) / 1024, $decimals, '.', '');
}

function logyap($done)
{
    file_put_contents(dirname(__FILE__) . '\\logs.txt', $done . PHP_EOL, FILE_APPEND | LOCK_EX);
}



function PaneleAktar($findgoApi, $pin, $typeInfo=2)
{
    global $domain;
    $SiteApi=$findgoApi;
    $curlRepin=curl_init();
    curl_setopt_array($curlRepin, array(
        CURLOPT_URL => "http://findgoo.com/islemler",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"islemturum\"\r\n\r\n" . $typeInfo . "\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"islemverisi\"\r\n\r\n" . $pin . "\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"api\"\r\n\r\n" . $SiteApi . "\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache",
            "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
            "postman-token: 3df5e8bc-9c25-f172-7329-1a15a712ea46"
        ),
    ));
    curl_setopt($curlRepin, CURLOPT_REFERER, $domain);
    $response=curl_exec($curlRepin);
    $err=curl_error($curlRepin);
    curl_close($curlRepin);
    return $response;
}
