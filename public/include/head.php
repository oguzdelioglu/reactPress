<head>
    <meta charset="UTF-8" />
    <?php
    function getimgsize($url, $referer = '')
    {
        // Set headers    
        $headers = array('Range: bytes=0-131072');
        if (!empty($referer)) {
            array_push($headers, 'Referer: ' . $referer);
        }
        // Get remote image
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $data = curl_exec($ch);
        $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curl_errno = curl_errno($ch);
        curl_close($ch);
        // Get network stauts
        if ($http_status != 200) {
            echo 'HTTP Status[' . $http_status . '] Errno [' . $curl_errno . ']';
            return [0, 0];
        }
        // Process image
        $image = imagecreatefromstring($data);
        $dims = [imagesx($image), imagesy($image)];
        imagedestroy($image);
        return $dims;
    }
    $settings = Settings();
    if (isset($pin)) { //Pin Page
    ?>
        <title><?php echo $pin["pin_title"]; ?>
        </title>
        <link rel="canonical" href="<?php echo $domain; ?>post/<?php echo $pin["post_link"]; ?>" />
        <meta name="robots" content="index, follow" />
        <meta name="keywords" content="<?php echo $pin["pintaglist"]; ?>" />
        <meta name="description" content="<?php echo substr($pin["pin_title"], 0, 160); ?>" />
        <meta property="og:type" content="article" />
        <meta property="og:locale" content="en_US" />
        <meta property="og:title" content="<?php echo $pin["pin_title"]; ?>" />
        <meta property="og:description" content="<?php echo wordwrap($pin["pin_title"], 137, '...'); ?>" />
        <meta property="og:image" content="<?php
                                            list($width, $height) = getimgsize($imglink);
                                            $arr = array('h' => $height, 'w' => $width);
                                            echo $imglink;
                                            ?>" />
        <meta property="og:image:width" content="<?php echo $arr["w"]; ?>" />
        <meta property="og:image:height" content="<?php echo $arr["h"]; ?>" />
        <meta property="twitter:title" content="<?php echo $pin["pin_title"]; ?>" />
        <meta property="twitter:description" content="<?php echo wordwrap($pin["pin_title"], 137, '...'); ?>" />
        <meta property="article:published_time" content="<?php echo $pin["post_date"]; ?>" />
        <meta property="article:author" content="<?php echo $author; ?>" />
        <?php
        foreach ((explode(",", $pin["pintaglist"])) as $pintag) :
            if (!empty($pintag)) { ?>
                <meta property="article:tag" content="<?php echo $pintag; ?>" />
        <?php
            }
        endforeach;
    } elseif (isset($_GET['q'])) { //Search Result and Category Page
        $KeywordTitle = $SearchKeyword;
        $search = str_replace("-", " ", $KeywordTitle); ?>
        <?php
        $reqtype = explode("/", $_SERVER["REQUEST_URI"])[1];
        if ($reqtype == "category") {
            $contenttype = "index,follow";
        } else if ($reqtype == "404") {
            $contenttype = "noindex,nofollow";
            $search = "Not Found";
        } else {
            $contenttype = "noindex,nofollow";
        } ?>
        <title><?php echo $settings["site_title"] . " | " . $search; ?></title>
        <meta name="title" content="<?php echo $search; ?>" />
        <meta name="robots" content="<?php echo $contenttype; ?>" />
        <meta name="description" content="<?php echo $search; ?>">
        <meta name="keywords" content="<?php echo $search; ?>">
        <meta name="author" content="<?php echo $settings["site_author"]; ?>">
        <?php
        if ($reqtype == "category") {
        ?>
            <link rel="canonical" href="<?php echo $domain; ?>category/<?php echo (isset($_GET['page']) && is_numeric($_GET['page'])) ? $KeywordTitle . "?page=" . $_GET['page'] : $KeywordTitle; ?>" />
        <?php
        }
        ?>
    <?php
    } else { ?>
        <title><?php echo $settings["site_title"]; ?></title>
        <?php if (isset($_GET['page']) && is_numeric($_GET['page'])) { ?>
            <link rel="canonical" href="<?php echo $domain; ?><?php echo "?page=" . $_GET['page']; ?>" />
            <meta name="robots" content="noindex,follow" />
        <?php } else { ?>
            <link rel="canonical" href="<?php echo substr($domain, 0, -1); ?>" />
            <meta name="robots" content="index, follow" /><?php } ?>
        <meta name="title" content="<?php echo $settings["site_title"]; ?>" />
        <meta name="description" content="<?php echo $settings["site_description"]; ?>" />
        <meta name="keywords" content="<?php echo $settings["site_keywords"]; ?>" />
        <meta name="author" content="<?php echo $settings["site_author"]; ?>">
        <meta property="og:locale" content="en_US" />
        <meta property="og:title" content="<?php echo $settings["site_title"]; ?>" />
        <meta property="og:url" content="<?php echo $domain; ?>" />
        <meta property="og:description" content="<?php echo $settings["site_description"]; ?>" />
        <meta property="twitter:title" content="<?php echo $settings["site_title"]; ?>" />
        <meta property="twitter:description" content="<?php echo $settings["site_description"]; ?>" />
    <?php } ?>
    <link rel='dns-prefetch' href='//fonts.googleapis.com' />
    <link rel='dns-prefetch' href='//s.w.org' />
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel='stylesheet preload prefetch' href='/css/style.css' type='text/css' media='all' as="style" />
    <link rel='stylesheet preload prefetc' href='/css/ilightbox/dark-skin/skin.css' type='text/css' media='all' as="style" />
    <link rel="preload" href="/fonts/fontawesome/fontawesome-webfont.woff2?v=4.6.3" as="font" crossorigin="anonymous" />
    <link rel="stylesheet preload prefetch" href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@600&display=swap" type="text/css" crossorigin="anonymous" as="style" />
    <script type='text/javascript' src='/js/jquery-3.6.0.min.js'></script>
    <meta name="generator" content="WordPress 5.7.1" />
    <link rel="shortcut icon" href="/favicon.ico" title="Favicon" />
    <!--[if IE]>
<script type="text/javascript">jQuery(document).ready(function (){ jQuery(".menu-item").has("ul").children("a").attr("aria-haspopup", "true");});</script>
<![endif]-->
    <!--[if lt IE 9]>
<script src="/js/html5.js"></script>
<script src="/js/selectivizr-min.js"></script>
<![endif]-->
    <!--[if IE 9]>
<link rel="stylesheet" type="text/css" media="all" href="/css/ie9.css" />
<![endif]-->
    <!--[if IE 8]>
<link rel="stylesheet" type="text/css" media="all" href="/css/ie8.css" />
<![endif]-->
    <!--[if IE 7]>
<link rel="stylesheet" type="text/css" media="all" href="/css/ie7.css" />
<![endif]-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style type="text/css" media="screen">
        body {
            font-family: 'Roboto Mono';
        }

        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        #main-nav,
        .cat-box-content,
        #sidebar .widget-container,
        .post-listing,
        #commentform {
            border-bottom-color: #37b8eb;
        }

        .search-block .search-button,
        #topcontrol,
        #main-nav ul li.current-menu-item a,
        #main-nav ul li.current-menu-item a:hover,
        #main-nav ul li.current_page_parent a,
        #main-nav ul li.current_page_parent a:hover,
        #main-nav ul li.current-menu-parent a,
        #main-nav ul li.current-menu-parent a:hover,
        #main-nav ul li.current-page-ancestor a,
        #main-nav ul li.current-page-ancestor a:hover,
        .pagination span.current,
        .share-post span.share-text,
        .flex-control-paging li a.flex-active,
        .ei-slider-thumbs li.ei-slider-element,
        .review-percentage .review-item span span,
        .review-final-score,
        .button,
        a.button,
        a.more-link,
        #main-content input[type="submit"],
        .form-submit #submit,
        #login-form .login-button,
        .widget-feedburner .feedburner-subscribe,
        input[type="submit"],
        #buddypress button,
        #buddypress a.button,
        #buddypress input[type=submit],
        #buddypress input[type=reset],
        #buddypress ul.button-nav li a,
        #buddypress div.generic-button a,
        #buddypress .comment-reply-link,
        #buddypress div.item-list-tabs ul li a span,
        #buddypress div.item-list-tabs ul li.selected a,
        #buddypress div.item-list-tabs ul li.current a,
        #buddypress #members-directory-form div.item-list-tabs ul li.selected span,
        #members-list-options a.selected,
        #groups-list-options a.selected,
        body.dark-skin #buddypress div.item-list-tabs ul li a span,
        body.dark-skin #buddypress div.item-list-tabs ul li.selected a,
        body.dark-skin #buddypress div.item-list-tabs ul li.current a,
        body.dark-skin #members-list-options a.selected,
        body.dark-skin #groups-list-options a.selected,
        .search-block-large .search-button,
        #featured-posts .flex-next:hover,
        #featured-posts .flex-prev:hover,
        a.tie-cart span.shooping-count,
        .woocommerce span.onsale,
        .woocommerce-page span.onsale,
        .woocommerce .widget_price_filter .ui-slider .ui-slider-handle,
        .woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle,
        #check-also-close,
        a.post-slideshow-next,
        a.post-slideshow-prev,
        .widget_price_filter .ui-slider .ui-slider-handle,
        .quantity .minus:hover,
        .quantity .plus:hover,
        .mejs-container .mejs-controls .mejs-time-rail .mejs-time-current,
        #reading-position-indicator {
            background-color: #08435a;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #37b8eb !important;
        }

        #theme-footer,
        #theme-header,
        .top-nav ul li.current-menu-item:before,
        #main-nav .menu-sub-content,
        #main-nav ul ul,
        #check-also-box {
            border-top-color: #37b8eb;
        }

        .search-block:after {
            border-right-color: #37b8eb;
        }

        body.rtl .search-block:after {
            border-left-color: #37b8eb;
        }

        #main-nav ul>li.menu-item-has-children:hover>a:after,
        #main-nav ul>li.mega-menu:hover>a:after {
            border-color: transparent transparent #37b8eb;
        }

        .widget.timeline-posts li a:hover,
        .widget.timeline-posts li a:hover span.tie-date {
            color: #37b8eb;
        }

        .widget.timeline-posts li a:hover span.tie-date:before {
            background: #37b8eb;
            border-color: #37b8eb;
        }

        #order_review,
        #order_review_heading {
            border-color: #37b8eb;
        }
    </style>
    <?php if (!empty($GoogleADS)) { ?>
        <script data-ad-client="<?php echo $GoogleADS; ?>" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <?php } ?>
    <?php
    $crawler = crawlerDetect($_SERVER['HTTP_USER_AGENT']);
    if (!$crawler) {
        echo $settings["site_headermeta"] ?? '';
    } ?>
</head>
<aside id="slide-out">
    <div class="search-mobile">
        <form method="get" id="searchform-mobile" action="search">
            <button class="search-button" type="submit" aria-label="Search" value="Search"><i class="fa fa-search"></i></button>
            <input type="text" id="s-mobile" name="s" title="Search" value="Search" minlength="3" maxlength="20" required onfocus="if (this.value == 'Search') {this.value = '';}" onblur="if (this.value == '') {this.value = 'Search';}" />
        </form>
        <script>
            (function() {
                var wordInput = document.getElementById("s-mobile");
                var form_el = document.getElementById("searchform-mobile");
                form_el.addEventListener("submit", function(e) {
                    e.preventDefault();
                    window.location.href = "/search/" + wordInput.value
                });
            })()
        </script>
    </div><!-- .search-mobile /-->
    <div id="mobile-menu"></div>
</aside><!-- #slide-out /-->