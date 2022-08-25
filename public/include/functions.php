<?php

function getPost($_LINK)
{
    $statement = $GLOBALS['db']->prepare(
        "SELECT pinlist.id,pinlist.pin_id,pinlist.post_link,pin_content,pinlist.post_date,pinlist.pin_title,pinlist.mypin_img,pinlist.mypin_link,pinlist.pin_originalLink,pin_img, GROUP_CONCAT(DISTINCT t.tag_name) AS pintaglist
        FROM pinlist LEFT OUTER JOIN pintags ON pinlist.id = pintags.pin_id LEFT OUTER JOIN tags t on pintags.tag_id = t.tag_id
        WHERE pinlist.post_link = '" . $_LINK . "' GROUP BY pinlist.id LIMIT 1"
    );
    $statement->execute();
    return $statement->fetch();
}

function getPosts($_offset = 1, $_pincount = 1)
{
    $statement = $GLOBALS['db']->prepare(
        "SELECT pinlist.id,pinlist.pin_id,pinlist.mypin_img,pinlist.mypin_link,pinlist.pin_title,pinlist.pin_content,pin_img,post_link,
     GROUP_CONCAT(t.tag_name) AS pintaglist FROM pinlist LEFT OUTER JOIN pintags ON pinlist.id = pintags.pin_id LEFT OUTER JOIN tags t on pintags.tag_id = t.tag_id 
     GROUP BY pinlist.id ORDER BY pinlist.id DESC LIMIT " . $_offset . "," . $_pincount
    );
    $statement->execute();
    return $statement->fetchAll();
}

function getPostList($_KEYWORD, $_OFFSET, $_PINCOUNT)
{
    $statement = $GLOBALS['db']->prepare("SELECT bp.id,bp.pin_id,bp.pin_title,bp.pin_content,bp.pin_img,bp.post_link,GROUP_CONCAT(tt.tag_name) as pintaglist  FROM pinlist bp 
LEFT OUTER JOIN pintags ON bp.id = pintags.pin_id LEFT OUTER JOIN tags tt on pintags.tag_id = tt.tag_id
WHERE EXISTS (SELECT * FROM pintags bt INNER JOIN tags t ON t.tag_id = bt.tag_id WHERE bp.id = bt.pin_id AND t.tag_name LIKE '%" . str_replace("-", " ", $_KEYWORD) . "%') 
OR bp.pin_title LIKE '%" . str_replace("-", " ", $_KEYWORD) . "%'
GROUP BY bp.id ORDER BY bp.id DESC LIMIT " . $_OFFSET . "," . $_PINCOUNT);
    $statement->execute();
    return $statement->fetchAll();
}

function getLastPosts($_LIMIT = 5)
{
    $statement = $GLOBALS['db']->prepare("SELECT pinlist.mypin_img,pinlist.mypin_link,pinlist.pin_title,pin_img,post_link FROM pinlist ORDER BY id DESC LIMIT $_LIMIT");
    $statement->execute();
    return $statement->fetchAll();
}

function getRelatedPosts($_POSTID, $_KEYWORD, $_LIMIT = 6)
{
    $statement = $GLOBALS['db']->prepare("SELECT bp.id,bp.pin_id,bp.pin_title,bp.pin_img,bp.post_link,GROUP_CONCAT(tt.tag_name) as pintaglist  FROM pinlist bp 
    LEFT OUTER JOIN pintags ON bp.id = pintags.pin_id LEFT OUTER JOIN tags tt on pintags.tag_id = tt.tag_id
    WHERE bp.id != " . $_POSTID . " AND EXISTS (SELECT * FROM pintags bt INNER JOIN tags t ON t.tag_id = bt.tag_id WHERE bp.id = bt.pin_id AND t.tag_name LIKE '%" . $_KEYWORD . "%') 
    OR bp.pin_title LIKE '%" . $_KEYWORD . "%' GROUP BY bp.id ORDER BY RAND() LIMIT $_LIMIT");
    return $statement->fetchAll();
}

function getPopularPosts($_LIMIT = 5)
{
    $statement = $GLOBALS['db']->prepare("SELECT pinlist.mypin_img,pinlist.mypin_link,pinlist.pin_title,pin_img,post_link FROM pinlist ORDER BY id DESC LIMIT $_LIMIT OFFSET 20"); //Son Eklenen pinlerden 20. sıradan sonraki 5 adeti çeker
    $statement->execute();
    return $statement->fetchAll();
}

function getRandomPosts($_LIMIT = 5, $_DETAILS = false)
{
    if ($_DETAILS) {
        $sql = "SELECT pinlist.id,pinlist.pin_id,pinlist.mypin_img,pinlist.mypin_link,pinlist.pin_title,pin_img,post_link, GROUP_CONCAT(t.tag_name) AS pintaglist FROM pinlist LEFT OUTER JOIN pintags ON pinlist.id = pintags.pin_id LEFT OUTER JOIN tags t on pintags.tag_id = t.tag_id GROUP BY pinlist.id ORDER BY RAND() LIMIT $_LIMIT";
    } else {
        $sql = "SELECT pinlist.mypin_img,pinlist.mypin_link,pinlist.pin_title,pin_img,post_link FROM pinlist ORDER BY RAND() LIMIT $_LIMIT";
    }
    $statement = $GLOBALS['db']->prepare($sql);
    $statement->execute();
    return $statement->fetchAll();
}

function getCategories()
{
    $statement = $GLOBALS['db']->prepare("SELECT tags.tag_name,(SELECT COUNT(pintags.pin_id) FROM pintags WHERE pintags.tag_id=tags.tag_id) as pinCount FROM `tags` WHERE `tag_category` = 1");
    $statement->execute();
    return $statement->fetchAll();
}

function getTags($_CategoryID = 0, $_Limit = 25)
{
    $statement = $GLOBALS['db']->prepare("SELECT tags.tag_name FROM `tags` WHERE `tag_category` = $_CategoryID LIMIT $_Limit");
    $statement->execute();
    return $statement->fetchAll();
}

function getPreviusPost($_PINID)
{
    $statement = $GLOBALS['db']->prepare("select post_link,pin_title from pinlist where id > $_PINID ORDER BY id LIMIT 1");
    $statement->execute();
    return $statement->fetch();
}

function getNextPost($_PINID)
{
    $statement = $GLOBALS['db']->prepare("select post_link,pin_title from pinlist where id < $_PINID ORDER BY id DESC LIMIT 1");
    $statement->execute();
    return $statement->fetch();
}

function getPostCount($_KEYWORD)
{
    try {
        $statement = $GLOBALS['db']->prepare("SELECT bp.pin_id FROM pinlist bp 
        LEFT OUTER JOIN pintags ON bp.id = pintags.pin_id LEFT OUTER JOIN tags tt on pintags.tag_id = tt.tag_id
        WHERE EXISTS (SELECT * FROM pintags bt INNER JOIN tags t ON t.tag_id = bt.tag_id WHERE bp.id = bt.pin_id AND t.tag_name LIKE '%" . str_replace("-", " ", $_KEYWORD) . "%') 
        OR bp.pin_title LIKE '%" . str_replace("-", " ", $_KEYWORD) . "%'
        GROUP BY bp.id");
        $statement->execute();
        return $statement->rowCount();
    } catch (\Exception $th) {
        return null;
    }
}

function Pagination()
{
    $statement = $GLOBALS['db']->prepare("SELECT COUNT(pin_id) AS pinCount FROM pinlist");
    $statement->execute();
    return $statement->fetch()[0];
}

function Settings()
{
    $statement = $GLOBALS['db']->prepare("SELECT * FROM settings");
    $statement->execute();
    return $statement->fetch();
}

function cleanQuery($_QUERY)
{
    $SearchKeyword = htmlspecialchars(strip_tags($_QUERY));
    $SearchKeyword = preg_replace('/[\\\"\'\;\}\{\:\&]/', "", $SearchKeyword);
    $SearchKeyword = preg_replace('/<script[^\>]*>|<\/script>|&quot|(onabort|onblur|onchange|onclick|ondbclick|onerror|onfocus|onkeydown|onkeypress|
    onkeyup|onload|onmousedown|onmousemove|onmouseout|onmouseover|onmouseup|
    onreset|onresize|onselect|onsubmit|onunload)\s*=\s*"[^"]+"/i', '', $SearchKeyword);
    $SearchKeyword = str_replace("  ", " ", $SearchKeyword);
    return $SearchKeyword;
}

function shortenText($text, $maxlength = 50, $appendix = "...")
{
    if (mb_strlen($text) <= $maxlength) {
        return $text;
    }
    $text = mb_substr($text, 0, $maxlength - mb_strlen($appendix));
    $text .= $appendix;
    return trim($text);
}

function UpdateAds($_ADS, $_KEYWORD)
{
    return str_replace("KEYWORDHERE", $_KEYWORD, $_ADS);
}

function crawlerDetect($USER_AGENT)
{
    $crawlers_agents = "Google|GoogleBot|Googlebot|msnbot|Rambler|Yahoo|AbachoBOT|accoona|AcioRobot|ASPSeek|CocoCrawler|Dumbot|FAST-WebCrawler|Pinterest|GeonaBot|Gigabot|Lycos|MSRBOT|Scooter|contxbot|AltaVista|IDBot|eStyle|Scrubby";
    $crawlers = explode("|", $crawlers_agents);
    foreach ($crawlers as $crawler) {
        if (strpos($USER_AGENT, $crawler) !== false) {
            return true;
        }
    }
    return false;
}


function truncate($text, $length)
{
    $length = abs((int)$length);
    if (strlen($text) > $length) {
        $text = preg_replace("/^(.{1,$length})(\s.*|$)/s", '\\1', $text);
    }
    return ($text);
}
