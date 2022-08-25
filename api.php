<?php
header('Access-Control-Allow-Origin: *');
ini_set('max_execution_time', 900); //300 seconds = 5 minutes
require 'config.php';
//setup db variables
define("DB_HOST", $host);
define("DB_USER", $username);
define("DB_PASS", $password);
define("DB_NAME", $dbname);

try {
    if (isset($_POST) and isset($_POST["TYPE"])) {
        $database = new db();
        switch ($_POST["TYPE"]) {
            case "PIN_COUNT":
                $database->query('SELECT COUNT(id) as pinCount FROM pinlist');
                echo $database->single()["pinCount"];
                break;
            case "CATEGORY_COUNT":
                $database->query('SELECT COUNT(tag_id) as categoryCount FROM tags WHERE tag_category = 1');
                echo $database->single()["categoryCount"];
                break;
            case "PIN_LIST":
                $database->query('SELECT * FROM pinlist');
                header('Content-Type: application/json');
                echo json_encode($database->resultset(), JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_IGNORE);
                break;
            case "PIN_DETAY":
                $database->query('SELECT pinlist.id,pinlist.pin_id,pinlist.post_link,pin_content,pinlist.post_date,pinlist.pin_title,pinlist.mypin_img,pinlist.mypin_link,pin_img, GROUP_CONCAT(DISTINCT t.tag_name) AS pintaglist
            FROM pinlist LEFT OUTER JOIN pintags ON pinlist.id = pintags.pin_id LEFT OUTER JOIN tags t on pintags.tag_id = t.tag_id
            WHERE pinlist.id = ' . $_POST["id"] . ' GROUP BY pinlist.id LIMIT 1');
                header('Content-Type: application/json');
                echo json_encode($database->single(), JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_IGNORE);
                break;
            case "CATEGORY_LIST":
                $database->query('SELECT tag_name FROM tags WHERE tag_category = 1');
                header('Content-Type: application/json');
                echo json_encode($database->resultset(), JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_IGNORE);
                break;
            case "RESET_PIN_PUBLISHED":
                $database->query('UPDATE pinlist SET published = 1');
                $database->execute();
                echo "PIN RESET COMPLETED";
                break;
            case "SITE_SETTINGS":
                $database->query('SELECT * FROM settings LIMIT 1');
                header('Content-Type: application/json');
                echo json_encode($database->single(), JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_IGNORE);
                break;
            case "CACHE_CLEAR":
                CacheSil();
                echo "CACHE CLEAR COMPLETE";
                break;
            case "HIT_INCREASE":
                if (!BotChecker($_POST["USERAGENT"])) { //BOT CHECKER
                    file_get_contents('http://findgoo.com/api', false, stream_context_create([
                        'http' => [
                            'method' => 'POST',
                            'header'  => "Content-type: application/x-www-form-urlencoded",
                            'content' => http_build_query([
                                'SITE' => $_POST["SITE"], 'LINK' => $_POST["LINK"], 'USERAGENT' => $_POST["USERAGENT"], 'BROWSER_LANGUAGE' => $_POST["BROWSER_LANGUAGE"], 'TYPE' => 'HIT_INCREASE', 'IP' => getIpAddress()
                            ])
                        ]
                    ]));
                }
                echo "Visitor Added";
                break;
            case "ADS_UPDATE":
                $database->query('UPDATE settings SET `site_ads300-250` = :siteAds300250,`site_ads728-90` = :siteAds72890,`site_ads_fluid` = :siteAdsFluid,`site_ads_responsive` = :siteAdsResponsive,`site_ads_336-280` = :siteAds336280,`site_ads_300-600` = :siteAds300600,`site_ads_baglanti` = :siteAdsBaglanti,`site_headermeta` = :headermeta');
                $database->bind(':siteAds300250', $_POST["ads300250"]);
                $database->bind(':siteAds72890', $_POST["ads72890"]);
                $database->bind(':siteAdsFluid', $_POST["adsfluid"]);
                $database->bind(':siteAdsResponsive', $_POST["adsresponsive"]);
                $database->bind(':siteAds336280', $_POST["ads336280"]);
                $database->bind(':siteAds300600', $_POST["ads300600"]);
                $database->bind(':siteAdsBaglanti', $_POST["adsbaglanti"]);
                $database->bind(':headermeta', $_POST["headermeta"]);
                $database->execute();
                echo $domain . " => ADS UPDATED";
                break;
            case "UPDATE_SITEMAP":
                exec('php sitemap/generator.php');
                echo $domain . " => SITEMAP UPDATED";
                break;
            case "COPY_PIN":
                $pinid = $_POST["pin_id"];
                $pintitle = $_POST["pin_title"];
                $pincontent = $_POST["pin_content"];
                $image = $_POST["image"];
                $image350x350 = $_POST["image350x350"];
                $pintaglist = explode(",", $_POST["pintaglist"]);
                $islemID = rand(100000, 999999);
                $SefLink = pin_slug($pintitle) . "-" . $islemID;

                $database->query('INSERT INTO pinlist (pin_id,pin_title,pin_content,pin_img,post_link,pin_originalLink,published) VALUES(:pin_id, :pin_title, :pin_content, :pin_img, :post_link, :pin_originalLink, :published)');
                $database->bind(':pin_id', $pinid);
                $database->bind(':pin_title', $pintitle);
                $database->bind(':pin_content', $pincontent);
                $database->bind(':post_link', $SefLink);
                $database->bind(':pin_img', "");
                $database->bind(':pin_originalLink', "");
                $database->bind(':published', true);
                $database->execute();
                $lastinsertid = $database->lastInsertId();

                if ($lastinsertid <= 0) {
                    die("Failed" . $database->queryError() . $database->debugDumpParams());
                }

                //Tag Ayarlama
                foreach ($pintaglist as $index => $kword) {
                    if (!is_numeric($kword)) {
                        $iscat = 0;
                        if ($index == 0) {
                            $iscat = 1;
                        }
                        $lastInsertedTagID = TagEkle($kword, $iscat);
                        $database->query("insert into pintags(pin_id,tag_id) values (:insertedPinID,:lastInsertedTagID)");
                        $database->bind(':insertedPinID', $lastinsertid);
                        $database->bind(':lastInsertedTagID', $lastInsertedTagID);
                        $database->execute();
                    }
                }
                //Tag Ayarlama

                $imageDir = "uploads/" . $SefLink . ".jpg";
                $image350x350Dir = "uploads/350x350/" . $SefLink . ".jpg";
                file_put_contents($imageDir, file_get_contents($image));
                file_put_contents($image350x350Dir, file_get_contents($image350x350));
                echo "POST COPY SUCCESSFUL";
                break;
            case "POST_INFO":
                $postlink =  str_replace("/post/", "", $_POST["LINK"]);
                $database->query('SELECT id,pinlist.pin_id,pin_title,post_link,pin_content,post_date,GROUP_CONCAT(DISTINCT t.tag_name) AS pintaglist FROM pinlist LEFT OUTER JOIN pintags ON pinlist.id = pintags.pin_id LEFT OUTER JOIN tags t on pintags.tag_id = t.tag_id WHERE pinlist.post_link = "' . $postlink . '"');
                header('Content-Type: application/json');
                $post_info = $database->single();
                $post_info["image"] = $domain . "uploads/" . $post_info["post_link"] . ".jpg";
                $post_info["image350x350"] = $domain . "uploads/350x350/" . $post_info["post_link"] . ".jpg";
                echo json_encode($post_info, JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_IGNORE);
                break;
            case "SITE_INFO":
                $database->query('SELECT (SELECT "OK") as status, (SELECT COUNT(id) FROM `pinlist`) as pinCount, (SELECT COUNT(*) FROM `tags`) as tagCount');
                header('Content-Type: application/json');
                echo json_encode($database->resultset(), JSON_UNESCAPED_UNICODE | JSON_INVALID_UTF8_IGNORE);
                break;
            default:
                echo "Invalid Parameters";
        }
        $database->close();
    } else {
        echo "WORKING";
    }
} catch (Exception $e) {
    echo $e->getMessage();
}

function TagEkle($keyword, $iscat)
{
    global $database;
    $database->query("SELECT tag_id FROM tags WHERE LOWER(`tag_name`) = LOWER('" . $keyword . "') LIMIT 1");
    $lastinsertid = $database->single()["tag_id"] ?? 0;
    if ($lastinsertid != 0) { //EĞER DAHA ÖNCEDEN KEYWORD EKLENMİŞSE O KEYWORD ÜN ID Sİ ALINIR
        //KEYWORD ZATEN VAR
        return $lastinsertid;
    } else {
        //KEYWORDU Siteye EKLER
        $database->query("insert into tags (tag_name,tag_category) values ('" . $keyword . "'," . $iscat . ")");
        $database->execute();
        $lastinsertid = $database->lastInsertId();
        return $lastinsertid;
    }
}

function CacheSil()
{
    $dizin = realpath(dirname(__FILE__)) . '/cache';
    if ($kaynak = opendir($dizin)) {
        while (false !== ($file = readdir($kaynak))) {
            if ($file != "." and $file != ".." and $file != "index.html" and $file != ".htaccess") {
                unlink($dizin . "/" . $file);
            }
        }
    }
}
function getIpAddress()
{
    return (empty($_SERVER['HTTP_CLIENT_IP']) ? (empty($_SERVER['HTTP_X_FORWARDED_FOR']) ?
        $_SERVER['REMOTE_ADDR'] : $_SERVER['HTTP_X_FORWARDED_FOR']) : $_SERVER['HTTP_CLIENT_IP']);
}
function pin_slug($str)
{
    $str = mb_strtolower(substr(mb_convert_encoding((string) $str, 'UTF-8', mb_list_encodings()), 0, 180), 'UTF-8');
    $str = preg_replace('/[^\p{L}\p{N}\s]/u', "", $str);
    $str = preg_replace("/[^\p{L}\p{Nd}]+/u", "-", $str);
    return $str;
}
function BotChecker($useragent)
{
    return (isset($_SERVER['HTTP_USER_AGENT'])
        && preg_match('/bot|crawl|slurp|spider|mediapartners/i', $useragent));
}

class db
{
    private $host = DB_HOST;
    private $dbName = DB_NAME;
    private $user = DB_USER;
    private $pass = DB_PASS;

    private $dbh;
    private $error;
    private $qError;
    private $stmt;

    public function __construct()
    {
        //dsn for mysql
        $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->dbName;
        $options = array(
            PDO::ATTR_ERRMODE    => PDO::ERRMODE_SILENT,
            PDO::ATTR_PERSISTENT => false, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', PDO::ATTR_PERSISTENT => false, PDO::ATTR_EMULATE_PREPARES => false
        );

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        }
        //catch any errors
        catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    public function close()
    {
        try {
            $this->dbh = null;
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    public function query($query)
    {
        $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute()
    {
        return $this->stmt->execute();

        $this->qError = $this->dbh->errorInfo();
        if (!is_null($this->qError[2])) {
            echo $this->qError[2];
        }
        echo 'done with query';
    }

    public function resultset()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    public function lastInsertId()
    {
        return $this->dbh->lastInsertId();
    }

    public function beginTransaction()
    {
        return $this->dbh->beginTransaction();
    }

    public function endTransaction()
    {
        return $this->dbh->commit();
    }

    public function cancelTransaction()
    {
        return $this->dbh->rollBack();
    }

    public function debugDumpParams()
    {
        return $this->stmt->debugDumpParams();
    }

    public function queryError()
    {
        $this->qError = $this->dbh->errorInfo();
        if (!is_null($qError[2])) {
            echo $qError[2];
        }
    }
}//end class db
