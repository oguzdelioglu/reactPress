<?php
error_reporting('E_ALL');
ini_set('display_errors', true);

$orgSite = "https://".$_SERVER['SERVER_NAME'];
$setupphp = "setup.php";
$fl = "config.php";
$flexample = "config.example.php";
$PinSearcphp = "bot/PinSearch.php";

$findgooToken        	   = 'b8SfdXpkZWxpb8SfbHU=';

$adsense_fluid = '';
$adsense_300600 = '';
$adsense_336280 = '';
$adsense_72890 = '';
$adsense_300250 = '';
$adsense_responsive = '';
$site_headermeta = '';
$site_ads_baglanti = '';
$analyticsUAexample        = '';
$pubid                     = '';
$adsensePubADSexample      = 'ca-pub-'.$pubid;
$siteTitleexample          = '';
$siteDescriptionexample    = '';
$siteKeywordionexample     = '';
$dbnameExample			   = explode(".",$_SERVER['SERVER_NAME'])[1]."_".explode(".",$_SERVER['SERVER_NAME'])[0];
$dbuserExample			   = explode(".",$_SERVER['SERVER_NAME'])[1]."_".explode(".",$_SERVER['SERVER_NAME'])[0];
$dbpassExample 			   = '';


$ads_txt = 'google.com, pub-'.$pubid.', DIRECT, f08c47fec0942fa0';

if(file_exists($fl))die("Kurulum Zaten Yapıldı");
if(!function_exists('exec')) {
  die("Sunucuda exec fonksiyonu kapalı");
}
if(!function_exists('chmod')) {
  die("Sunucuda chmod fonksiyonu kapalı");
}

@mkdir("uploads", 0777, true);
//CHMODLAR
@chmod("assets", 0777);
@chmod("bot", 0777);
@chmod("sitemap", 0777);
//@chmod($fl,0777);
@chmod($PinSearcphp,0777);

/*
if (!is_writable($setupphp))die("setup.php chmod 777 Yapınız");
if (!is_writable($fl))die("config.php chmod 777 Yapınız");
if (!is_writable($PinSearcphp))die("PinSearch.php chmod 777 Yapınız");
if (!is_writable($PinSearcphp))die("sitemap/generator.php chmod 777 Yapınız");
*/
//CHMODLAR

if(isset($_POST['submitBtn']))
{
$_POST['siteurl'] = rtrim($_POST['siteurl'], '/') . '/';//Link Sonuna / koyuyoruz


MakeWeb($_POST['sitetitle'],$_POST['sitedescription'],$_POST['sitekeywords'],$_POST['siteurl'],
$_POST['host'],$_POST['hostuser'],$_POST['dbpassword'],$_POST['hostdb'],$_POST['dbport'],
"100",$findgooToken, $_POST['keywordlist'],$_POST['analyticsua'],$_POST['adsensecapub'],$_POST['adsense300250'],$_POST['adsense72890'],$_POST['adsense300600'],$_POST['adsense336280'],$_POST['adsenseresponsive'],$_POST['adsensefluid'],$_POST['adsensebaglanti']);
}
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <title>ODEL Project Script Kurucu</title>

    <!-- Bootstrap core CSS -->
    <link href="../../../../vendor/bootstrap/v4/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../../../vendor/bootstrap/v4/css/form-validation.css" rel="stylesheet">
    <style>
        .limit-me {
            height: 500px;
            width: 100%;
        }
    </style>
  </head>

  <body class="bg-light">

    <div class="container">
      <div class="py-3 text-center">
        <h2>ODEL PROJECT SCRIPT OLUŞTURUCU V1</h2>
        <p class="lead">Aşağıdaki Formu Doldurarak Scripti Klonlayabilirsiniz</p>
      </div>
      <div class="row">
        <div class="col-md-12 order-md-1">
          <h2 class="mb-3">Site Bilgileri</h2>
          <form action="setup.php" method="post">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="siteurl">Site URL</label>
                <input type="text" class="form-control" name="siteurl" placeholder="https://2.example.com/" value="<?php echo $orgSite; ?>" required>
              </div>
              <div class="col-md-6 mb-3">
                <label for="sitetitle">Site Title</label>
                <input type="text" class="form-control" name="sitetitle" placeholder="" value="<? echo $siteTitleexample;?>" >
              </div>
              <div class="col-md-6 mb-3">
                <label for="sitedescription">Site Description</label>
                <input type="text" class="form-control" name="sitedescription" placeholder="" value="<? echo $siteDescriptionexample;?>" >
              </div>

              <div class="col-md-6 mb-3">
                <label for="sitekeywords">Site Keywords</label>
                <input type="text" class="form-control" name="sitekeywords" placeholder="" value="<?php echo $siteKeywordionexample; ?>" >
              </div>

              <div class="col-md-6 mb-3">
                <label for="sitekeywords">Analytics UA</label>
                <input type="text" class="form-control" name="analyticsua" placeholder="" value="<? echo $analyticsUAexample;?>">
              </div>

              <div class="col-md-6 mb-3">
                <label for="sitekeywords">ADSENSE CA-PUB</label>
                <input type="text" class="form-control" name="adsensecapub" placeholder="" value="<? echo $adsensePubADSexample;?>">
              </div>

              <div class="col-md-6 mb-3">
                <label for="sitekeywords">ADSENSE 300-250</label>
                <textarea class="form-control" name="adsense300250" rows="3"><? echo $adsense_300250;?></textarea>
              </div>

              <div class="col-md-6 mb-3">
                <label for="sitekeywords">ADSENSE 728-90</label>
                <textarea class="form-control" name="adsense72890" rows="3"><? echo $adsense_72890;?></textarea>
              </div>

              <div class="col-md-6 mb-3">
                <label for="sitekeywords">ADSENSE Fluid</label>
                <textarea class="form-control" name="adsensefluid" rows="3"><? echo $adsense_fluid;?></textarea>
              </div>

              <div class="col-md-6 mb-3">
                <label for="sitekeywords">ADSENSE Responsive</label>
                <textarea class="form-control" name="adsenseresponsive" rows="3"><? echo $adsense_responsive;?></textarea>
              </div>

              <div class="col-md-6 mb-3">
                <label for="sitekeywords">ADSENSE 300-600</label>
                <textarea class="form-control" name="adsense300600" rows="3"><? echo $adsense_300600;?></textarea>
              </div>

              <div class="col-md-6 mb-3">
                <label for="sitekeywords">ADSENSE 336-280</label>
                <textarea class="form-control" name="adsense336280" rows="3"><? echo $adsense_336280;?></textarea>
              </div>

              <div class="col-md-6 mb-3">
                <label for="sitekeywords">ADSENSE Baglantı</label>
                <textarea class="form-control" name="adsensebaglanti" rows="3"><? echo $site_ads_baglanti;?></textarea>
              </div>
            </div>

           
            <div class="row mt-5"></div>
            <h2 class="mb-3">Veritabanı Bilgileri</h2>
            <div class="row">
                <div class="col-md-2 mb-3">
                  <label for="text">Host</label>
                  <input type="text" class="form-control" name="host" placeholder="127.0.0.1" value="127.0.0.1" required>
                </div>
                <div class="col-md-3 mb-3">
                  <label for="hostuser">DB USER</label>
                  <input type="text" class="form-control" name="hostuser"  placeholder="admin_bullet" value="<? echo $dbuserExample; ?>" required>
                </div>
                <div class="col-md-3 mb-3">
                  <label for="hostdb">DB Name</label>
                  <input type="text" class="form-control" name="hostdb" placeholder="admin_bulletdb" value="<? echo $dbnameExample; ?>" required>
                </div>
                <div class="col-md-2 mb-3">
                  <label for="dbpassword">Password</label>
                  <input type="password" class="form-control" name="dbpassword" placeholder="" value="<? echo $dbpassExample; ?>" required>
                </div>
                <div class="col-md-2 mb-3">
                  <label for="dbport">Port</label>
                  <input type="text" class="form-control" name="dbport" placeholder="3306" value ="3306" required>
                </div>
            </div>

            <div class="row mt-5"></div>
            
            <h2 class="mb-3">Cron Ayarları</h2>
            <div class="form-check-inline">
              <label class="form-check-label">
              <input type="checkbox" class="form-check-input" name="pinsearch" value="1" checked> Pin Search
              </label>
            </div>
            <div class="row mt-5"></div>
            
            <h2 class="mb-3">Keyword Listesi (Maximum 30 Adet ve Alt Alta giriniz)</h2>
            <textarea class="limit-me" name="keywordlist" rows="30" required></textarea>
                  <div class="row mt-5"></div>
                  <button class="btn btn-primary btn-lg btn-block" name="submitBtn" type="submit">Siteyi Oluştur</button>
                </form>
              </div>
            </div>

            <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; 2019 ODEL Project</p>
      </footer>
      <script>
          var lines = 1;

          function getKeyNum(e) {
              var keynum;
              // IE
              if (window.event) {
                  keynum = e.keyCode;
                  // Netscape/Firefox/Opera
              } else if (e.which) {
                  keynum = e.which;
              }

              return keynum;
          }

          var limitLines = function (e) {
              var keynum = getKeyNum(e);

              if (keynum === 13) {
                  if (lines >= this.rows) {
                      e.stopPropagation();
                      e.preventDefault();
                  } else {
                      lines++;
                  }
              }
          };

          var setNumberOfLines = function (e) {
              lines = getNumberOfLines(this.value);
          };

          var limitPaste = function (e) {
              var clipboardData, pastedData;

              // Stop data actually being pasted into div
              e.stopPropagation();
              e.preventDefault();

              // Get pasted data via clipboard API
              clipboardData = e.clipboardData || window.clipboardData;
              pastedData = clipboardData.getData('Text');

              var pastedLines = getNumberOfLines(pastedData);

              // Do whatever with pasteddata
              if (pastedLines <= this.rows) {
                  lines = pastedLines;
                  this.value = pastedData;
              }
              else if (pastedLines > this.rows) {
                  // alert("Too many lines pasted ");
                  this.value = pastedData
                      .split(/\r\n|\r|\n/)
                      .slice(0, this.rows)
                      .join("\n ");
              }
          };

          function getNumberOfLines(str) {
              if (str) {
                  return str.split(/\r\n|\r|\n/).length;
              }

              return 1;
          }

          var limitedElements = document.getElementsByClassName('limit-me');

          Array.from(limitedElements).forEach(function (element) {
              element.addEventListener('keydown', limitLines);
              element.addEventListener('keyup', setNumberOfLines);
              element.addEventListener('cut', setNumberOfLines);
              element.addEventListener('paste', limitPaste);
          });
      </script>
    </div>
  </body>
</html>




<?

function MakeWeb(
$site_title,$site_description,$site_keywords,$do_main,$ho_st,$user_name,$pass_word,$db_name,$po_rt,$pin_SearchCount,$findgooToken,$keywordlist,$analyticsua,$adsensecapub,$adsense300250,$adsense72890,$adsense300600,$adsense336280,$adsenseresponsive,$adsensefluid,$adsensebaglanti)
{
    global $fl,$flexample;
    $ayrılmışiçerikler = array();
	echo '<!DOCTYPE html>
<html lang="en">
<head>
  <title>ODELPROJECT Script Kurucu</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body> ';
	echo '<div class="container"><div class="row">';
	echo '<div class="col text-center"><h2>Kurulum Sonuçları</h2></div>';
	
  //Keywordleri DB YE INSERT EDIYORUZ
  $array = explode(PHP_EOL, $keywordlist);
  $kw_array  = array_unique($array);
  $kw_array  = array_map(function($value) { return str_replace("'", "", $value); }, $kw_array);
  $kw_array  = array_map('trim',$kw_array);
  $kw_array  = array_map('ucfirst', $kw_array);
  if(count($kw_array)>3)array_push($ayrılmışiçerikler,$kw_array);//Listede En az 4 adet İçerik Olmalı

  //print_r($ayrılmışiçerikler);
	$maxicerik = 3;
	if(count($kw_array) < $maxicerik + 1)die('<div class="col text-center"><li class="label label-danger">Lütfen En Az '.$maxicerik. ' adet Keyword Girin.Şuan ".count($kw_array)." adet keyword eklemişsiniz.(Aynı Olanlar Silindikten sonra kalanlar)</li></div>');
  
  $atılacakiçerikler = $ayrılmışiçerikler[0];//İçeriklerin Bulunduğu Array

  $site_title = "";
  $site_keywords = "";
  $site_description = "";
  $seoicin = $atılacakiçerikler;

  try
  {
    if($site_title == "")
    {
      //Site Başlık Oluşturuyoruz
      while(strlen($site_title)<46 & isset($seoicin[0]))
      {
        $site_title.= " ".$seoicin[0];
        array_splice($seoicin, 0, 1);
      }
      if(strlen($site_title)<55)
      $site_title.= " And More";
        $site_title = substr($site_title,0,254);
      //Site Başlık Oluşturuyoruz
    }
    
    if($site_keywords == "")
    {
      //Site Keyword LİST OLUŞTURUYORUZ
      while(strlen($site_keywords)<200 & isset($seoicin[0]))
      {
        $site_keywords.= $site_keywords != null?",".$seoicin[0]:"".$seoicin[0];
        array_splice($seoicin, 0, 1);
      }
      $site_keywords = substr($site_keywords,0,254);
      //Site Keyword LİST OLUŞTURUYORUZ
    }
    if($site_description == "")
    {
      //Site Açıklama Oluşturuyoruz
      while(strlen($site_description)<145 & isset($seoicin[0]))
      {
        $site_description.= $site_description != null?" ".$seoicin[0]:"".$seoicin[0];
        array_splice($seoicin, 0, 1);
      }
      if(strlen($site_description)<150)
      $site_description.= " And More";
        $site_description = substr($site_description,0,254);
        if($site_description == " And More") $site_description = $site_title;
      //Site Açıklama Oluşturuyoruz
    }
  }
  catch(Exception $e)
  {
    echo $e->getMessage();
  }
  
	if(substr($do_main, -1)!="/")$do_main = $do_main."/";//Eğer eklenen domainin sonunda / yoksa ekler
	
	
	$findgoApi = ApiOlustur($findgooToken,$do_main);
	if(empty($findgoApi))die('<div class="col text-center"><li class="label label-danger">Sitenin Tokeni Alınamıyor</li></div>');
	$newSettings = array(
	  'domain' => $do_main,
	  'host' => $ho_st,
	  'username' => $user_name,
	  'password' => $pass_word,
	  'dbname' => $db_name,
	  'port' => $po_rt,
	  'pinSearchCount' => $pin_SearchCount,
	  'findgoApi' => $findgoApi,
    'AnalyticsUA' => $analyticsua,
    'postType' => 'instagram',
	  'GoogleADS' => $adsensecapub
	);

  //Config.php Ayarlarını Yapıyoruz
  $tmp = fopen($flexample, "r");
  $content=fread($tmp,filesize($flexample));
  fclose($tmp);//Var Olan Ayarları Çekiyoruz
  
  foreach($newSettings as $key => $setting)//Ayarları Döngüye Veriyoruz
  {
    $content = preg_replace('/\$'.$key.'=(.*?)\"(.*?)\";/', '$'.$key.'="'.$setting.'";', $content);//Ayarları Değiştiriyoruz
  }
  
  $tmp2 = fopen($fl, "w");
  fwrite($tmp2, $content);
  fclose($tmp2);//Ayarları Kaydediyoruz
  chmod($fl,0777);
  
  //echo $content;
  //Config.php Ayarlarını Yapıyoruz

  //robots.txt Ayarını Yapıyoruz
  file_put_contents('robots.txt','Sitemap: '.$do_main.'sitemap/sitemap.xml');
  //robots.txt Ayarını Yapıyoruz

  file_put_contents('ads.txt',$ads_txt);

  $siteAuthor = str_replace("https://","",$do_main);
  $siteAuthor = str_replace("http://","",$siteAuthor);
  $siteAuthor = str_replace("www.","",$siteAuthor);
  $siteAuthor = str_replace("/","",$siteAuthor);
  $siteAuthor = "admin@".  $siteAuthor;

  /*
  echo $site_title."<br>";
  echo $site_description."<br>";
  echo $site_keywords."<br>";
 */
sqlekle:
  $dsn        = "mysql:host=$ho_st;dbname=$db_name;port=$po_rt";
  $options    = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',PDO::ATTR_PERSISTENT => FALSE);
  $dbImport   = new PDO($dsn, $user_name, $pass_word, $options);

  //SQL EKLEME  
  $sqlCmd = file_get_contents('SQL/sql.sql');
  $resimport = $dbImport->exec($sqlCmd);
  if($resimport==0)
  {
    echo '<div class="col text-center"><li class="label label-success">SQL IMPORT BAŞARILI</li></div>'.PHP_EOL;
  }
  else if($resimport == 1)
  {
    echo '<div class="col text-center"><li class="label label-warning">SQL IMPORT SORUNU</li></div>'.PHP_EOL;
  }
  $dbImport = null;
  //SQL EKLEME

updateyap:
  $db = new PDO($dsn, $user_name, $pass_word, $options);
  $statement = $db->prepare(
  "UPDATE settings SET `site_title`=:site_title,`site_description`=:site_description,`site_keywords`=:site_keywords,`site_author`=:site_author,`site_ads300-250`=:site_300250,`site_ads_fluid`=:site_ads_fluid,`site_ads_336-280`= :site_ads_336280,`site_ads_300-600`=:site_ads_300600,`site_ads728-90`=:site_ads_72890,`site_ads_baglanti`=:site_ads_baglanti,`site_ads_responsive`=:site_ads_responsive");
  $statement->bindParam(':site_title', $site_title);
  $statement->bindParam(':site_description',$site_description);
  $statement->bindParam(':site_keywords',$site_keywords);
  $statement->bindParam(':site_author', $siteAuthor);
  $statement->bindParam(':site_300250', $adsense300250);
  $statement->bindParam(':site_ads_fluid', $adsensefluid);
  $statement->bindParam(':site_ads_336280', $adsense336280);
  $statement->bindParam(':site_ads_300600', $adsense300600);
  $statement->bindParam(':site_ads_72890', $adsense72890);
  $statement->bindParam(':site_ads_responsive', $adsenseresponsive);
  $statement->bindParam(':site_ads_baglanti', $adsensebaglanti);
  $statement->execute();
  $arr = $statement->errorInfo();
  print_r($arr);
  if($statement->rowCount()==1)
  {
    echo '<div class="col text-center"><li class="label label-warning">Site Verileri Veritabanına Kaydedildi</li></div>'.PHP_EOL;
  }
  else
  {
    echo '<div class="col text-center"><li class="label label-warning">Site Verileri Veritabanına Kaydedilemedi</li></div>'.PHP_EOL;
    //print_r( $arr);
  }

//Keywordleri DB YE INSERT EDIYORUZ
$query = "INSERT INTO tags (tag_name) VALUES ('".implode("'),('",$atılacakiçerikler)."')";
$statement = $db->prepare($query);
$statement->execute();
$arr = $statement->errorInfo();
//Keywordleri DB YE INSERT EDIYORUZ

//EKLEDİKLERİMİZİ KATEGORİ OLARAK KAYDEDİYORUZ
$query = "UPDATE `tags` SET tag_category = 1 WHERE tag_name IN ('".implode("', '", $atılacakiçerikler)."')";
$statement = $db->prepare($query);
$statement->execute();
$arr = $statement->errorInfo();
//EKLEDİKLERİMİZİ KATEGORİ OLARAK KAYDEDİYORUZ

  $db = null;
  $dbImport = null;



  //Cron Ayarları
  $MainFolder = dirname(__FILE__)."/bot/";
  $BackFolder = dirname(__FILE__)."/";
  $CronList = array();
  $PHPWhere = "nohup php -q";
  $PinSearch = $MainFolder ."PinSearch.php > ".$MainFolder."pinresult.txt 2>&1 &";
  array_push($CronList, array("time"=> rand(0,59).' 0-23/'.rand(3,4).' * * *',"phpwhere"=>$PHPWhere,"script"=>$PinSearch));
  exec('crontab -l',$output);
  $çıktı = array_filter($output);
  $çıktı = implode(PHP_EOL,$çıktı);
  if (strpos($çıktı, $PinSearch) == false) {//Eğer Daha Önceden Cron Varsa Eklemez
      foreach($CronList as $Cron)
      {
        $command = $Cron["time"].' '.$Cron["phpwhere"].' '.$Cron["script"];
        $çıktı = $çıktı.PHP_EOL.$command.PHP_EOL;
      }
      file_put_contents('crontab.txt', $çıktı);
      exec('crontab crontab.txt');
  }
  echo '<div class="col text-center"><li class="label label-info">Cron Eklendi -> '.$command.'</li></div>'.PHP_EOL;
  unlink('crontab.txt');
  unset($çıktı);
  unset($output);

	include_once($fl);
	//PaneleAktar($findgoApi,implode("-|-", $kw_array),"4");//Kelimeleri Bot Paneline Board Açılması İçin Gönderiyoruz
	echo '<div class="col text-center"><li class="label label-success">Kurulum Tamamlandı.</li></div>';
	echo '<div class="col text-center"><li class="label label-info">Lütfen setup.php dosyasını ftp den silin.</li></div>';
	echo '</div></div></body></html>';
	die();
}

function ApiOlustur($token,$domain)
{
		$curlRepin = curl_init();
		curl_setopt_array($curlRepin, array(
		  CURLOPT_URL => "http://findgoo.com/siteler",
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"token\"\r\n\r\n".$token."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"siteName\"\r\n\r\n".$domain."\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
		  CURLOPT_HTTPHEADER => array(
			"cache-control: no-cache",
			"content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
			"postman-token: 3df5e8bc-9c25-f172-7329-1a15a712ea46"
		  ),
		));
		curl_setopt($curlRepin, CURLOPT_REFERER,$domain);
		$response = curl_exec($curlRepin);
		$err = curl_error($curlRepin);
        curl_close($curlRepin);
        return $response;
}

function append_cronjob($cmd){

    if(is_string($cmd)&&!empty($cmd)&&cronjob_exists($cmd)===FALSE){

        //add job to crontab
        exec('echo -e "`crontab -l`\n'.$cmd.'" | crontab -', $output);
    }
    return $output;
}


function cronjob_exists($command){
    $cronjob_exists=false;
    exec('crontab -l', $crontab);
    if(isset($crontab)&&is_array($crontab)){
        $crontab = array_flip($crontab);
        if(isset($crontab[$command])){

            $cronjob_exists=true;
        }
    }
    return $cronjob_exists;
}



?>


