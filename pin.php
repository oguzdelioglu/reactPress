<?php
/*require_once('sCache.php');
$options = array(
'time'   => 360,
'dir'    => 'cache',
'buffer' => true,
'load'   => false,
'extension' => '.scache'
);
$sCache = new sCache($options);*/
require 'config.php';
require 'include/functions.php';

$GLOBALS['db'] = dbbaglan();
//Pin Bilgileri

$PostQuery = $_GET['q'];
if (strpos($PostQuery, " ") or strpos($PostQuery, "=") or strpos($PostQuery, "%20")) {
	header("Location: /404", 404);
	die();
}

$pin = getPost(cleanQuery($PostQuery));

//404
if (empty($pin) or empty($pin["id"])) {
	header("Location: /404", 404);
	die();
}
if (file_exists('uploads/' . $pin["post_link"] . '.jpg')) {
	$imglink = $domain . 'uploads/' . $pin["post_link"] . '.jpg';
} elseif ($pin["mypin_img"] != "") {
	$imglink = $pin["mypin_img"];
} else {
	$imglink = $pin["pin_img"];
}
$tamlinkpost = $domain . "post/" . $pin["post_link"] . "_" . $pin["id"];
$pin_title_social = str_replace(" ", "+", $pin["pin_title"]);
$FirstTag = "";
$Tags = "";
$TagList = explode(",", $pin["pintaglist"]);
foreach ($TagList as $pintag) {
	if (!empty($pintag)) {
		if ($FirstTag == "") {
			$FirstTag = $pintag;
		}
		$tag = str_replace(" ", "-", $pintag);
		$Tags .= '<a rel="nofollow" href="/search/' . $tag . '" rel="tag">' . $pintag . '</a> ';
	}
}
$pin["pin_content"] = preg_replace("/{$TagList[0]}/i", "<strong><a class=\"posttag\" href=\"/search/" . str_replace(" ", "-", $TagList[0]) . "\">$TagList[0]</a></strong>", $pin["pin_content"], 1);
$pin["category"] = $FirstTag;
$pin["category_slug"] = str_replace(" ", "-", $FirstTag);
//Pin Bilgileri

$RandomPins = getRandomPosts(5, true); //Random Posts
$similar = explode(",", $pin["pintaglist"])[0]; //Post Category
$RelatedPins = getRelatedPosts($pin["id"], $similar); //Related Posts
$categories = getCategories(); //Categories
$next = getNextPost($pin["id"]); //Next Post
$previus = getPreviusPost($pin["id"]); //Previus Post
$PopularPins = getPopularPosts(); //Popular Pins
$LatestPosts = getLastPosts(); //Latest Posts
$amazon = strpos($pin["pin_originalLink"], 'www.amazon');
?>
<!DOCTYPE html>
<html lang="en" prefix="og: http://ogp.me/ns#">
<?php include_once 'include/head.php'; ?>

<body id="top" class="home blog lazy-enabled">
	<div class="wrapper-outer">
		<div class="background-cover"></div>
		<div id="wrapper" class="boxed-all">
			<div class="inner-wrapper">
				<?php include_once 'include/header.php'; ?>
				<div id="main-content" class="container">
					<div class="content">
						<nav id="crumbs"><a rel="home" href="/"><span class="fa fa-home" aria-hidden="true"></span> Home</a><span class="delimiter">/</span><a rel="category" href="/category/<?= $pin["category_slug"] ?>"><?= ucfirst($pin["category"]) ?></a><span class="delimiter">/<span class="current"><?= $pin["pin_title"] ?></span></nav>
						<script type="application/ld+json">
							{
								"@context": "http:\/\/schema.org",
								"@type": "BreadcrumbList",
								"@id": "#Breadcrumb",
								"itemListElement": [{
									"@type": "ListItem",
									"position": 1,
									"item": {
										"name": "Home",
										"@id": "<?= $domain ?>"
									}
								}, {
									"@type": "ListItem",
									"position": 2,
									"item": {
										"name": "<?= $pin["category"] ?>",
										"@id": "<?= $domain ?>category/<?= $pin["category_slug"] ?>"
									}
								}]
							}
						</script>
						<article class="post-listing post type-post status-publish format-standard has-post-thumbnail  category-thumbnail tag-article tag-author tag-post tag-video" id="the-post">
							<div class="post-inner">
								<h1 class="name post-title entry-title"><span itemprop="name"><?= $pin["pin_title"] ?></span></h1>
								<p class="post-meta">
									<span class="post-cats"><i class="fa fa-folder"></i><a href="/category/<?= $pin["category_slug"] ?>" rel="category"><?= ucfirst($pin["category"]) ?></a></span>
								</p>
								<div class="clear"></div>
								<div class="entry">
									<?php if (isset($next["post_link"]) or isset($previus["post_link"])) { ?>
										<p style="text-align: center;">
											<?php if (isset($previus["post_link"])) { ?>
												<a href="<?= $previus["post_link"] ?>" title="previus post"><img class="alignnone size-medium" src="/css/images/previous.gif" alt="previus" width="150" height="55" /></a>
											<?php } ?>
											<?php if (isset($next["post_link"])) { ?>
												<a href="<?= $next["post_link"] ?>" title="next post"><img class="alignnone size-full" src="/css/images/next.gif" alt="next" width="150" height="55" /></a>
											<?php } ?>
										</p>
									<?php } ?>
									<div class="tie-medium-width-img"><?php if ($amazon) echo '<a rel="nofollow noopener noreferrer" target="_BLANK" href="' . $pin["pin_originalLink"] . '">'; ?><img class="alignnone size-medium tie-appear" title="<?= cleanQuery($pin["pin_title"]); ?>" src="<?= $imglink ?>" alt="<?= cleanQuery($pin["pin_title"]); ?>" width="1024" height="683" srcset="<?= $imglink ?>"><?php if ($amazon) echo '</a>'; ?></div>
									<?php if (!empty($settings["site_ads_336-280"])) {
										echo  '<div class="clear"></div>' . UpdateAds($settings["site_ads_336-280"], $pin["category"]) . '<div class="clear"></div>';
									} ?>
									<?= $pin["pin_content"] ?>
									<div class="clear"></div>
									<?php if (!empty($settings["site_ads_336-280"])) {
										echo  '<div class="clear"></div>' . UpdateAds($settings["site_ads_336-280"], $pin["category"]) . '<div class="clear"></div>';
									} ?>
								</div><!-- .entry /-->
								<div class="share-post">
									<span class="share-text">Share</span>
									<ul class="flat-social">
										<li><a title="share to twitter" href="https://twitter.com/intent/tweet?text=<?= $pin_title_social ?>&amp;url=<?= $tamlinkpost ?>" class="social-twitter" rel="noopener noreferrer" target="_blank"><i class="fa fa-twitter"></i> <span>Twitter</span></a></li>
										<li><a title="share to facebook" href="http://www.facebook.com/sharer.php?u=<?= $tamlinkpost ?>" class="social-facebook" rel="noopener noreferrer" target="_blank"><i class="fa fa-facebook"></i> <span>Facebook</span></a></li>
										<li><a title="share to pinterest" href="http://pinterest.com/pin/create/button/?url=<?= $tamlinkpost ?>&amp;description=<?= $pin_title_social ?>&amp;media=<?= $imglink ?>" class="social-pinterest" rel="noopener noreferrer" target="_blank"><i class="fa fa-pinterest"></i> <span>Pinterest</span></a></li>
										<li><a title="share to linkedin" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?= $tamlinkpost ?>&amp;title=<?= $pin_title_social ?>" class="social-linkedin" rel="noopener noreferrer" target="_blank"><i class="fa fa-linkedin"></i> <span>LinkedIn</span></a></li>
									</ul>
									<div class="clear"></div>
								</div> <!-- .share-post -->
								<div class="clear"></div>
							</div><!-- .post-inner -->
							<script type="application/ld+json">
								{
									"@context": "http:\/\/schema.org",
									"@type": "Article",
									"dateCreated": "<?= $pin["post_date"] ?>",
									"datePublished": "<?= $pin["post_date"] ?>",
									"dateModified": "<?= $pin["post_date"] ?>",
									"headline": "<?= cleanQuery($pin["pin_title"]) ?>",
									"name": "<?= cleanQuery($pin["pin_title"]) ?>",
									"keywords": "<?= $pin["pintaglist"] ?>",
									"url": "<?= $tamlinkpost ?>",
									"description": "<?= cleanQuery($pin["pin_title"]) ?>",
									"copyrightYear": "2020",
									"publisher": {
										"@id": "#Publisher",
										"@type": "Organization",
										"name": "<?= $settings["site_title"] ?>",
										"logo": {
											"@type": "ImageObject",
											"url": "<?= $domain . "assets/images/logo.png" ?>"
										}
									},
									"sourceOrganization": {
										"@id": "#Publisher"
									},
									"copyrightHolder": {
										"@id": "#Publisher"
									},
									"mainEntityOfPage": {
										"@type": "WebPage",
										"@id": "<?= $tamlinkpost ?>",
										"breadcrumb": {
											"@id": "#Breadcrumb"
										}
									},
									"author": {
										"@type": "Person",
										"name": "admin",
										"url": "<?= $domain ?>?author=1"
									},
									"articleSection": "Article",
									"articleBody": "<?= cleanQuery($pin["pin_title"]) ?>",
									"image": {
										"@type": "ImageObject",
										"url": "<?= $imglink ?>",
										"width": <?= $arr["w"] ?>,
										"height": <?= $arr["h"] ?>
									}
								}
							</script>
						</article><!-- .post-listing -->
						<p class="post-tag">Tags <?= $Tags ?>
						</p>
						<?= UpdateAds($settings["site_ads_baglanti"], $pin["category"]);  ?>
					</div>
					<?php include_once 'include/sidebar.php'; ?>
					<div class="clear"></div>
				</div><!-- .container /-->
				<?php include_once 'include/footer.php'; ?>
			</div><!-- .inner-Wrapper -->
		</div><!-- #Wrapper -->
	</div><!-- .Wrapper-outer -->
	<div id="topcontrol" class="fa fa-angle-up" title="Scroll To Top"></div>
	<div id="fb-root"></div>
	<script type='text/javascript'>
		/* <![CDATA[ */
		var tie = {
			"mobile_menu_active": "true",
			"mobile_menu_top": "",
			"lightbox_all": "true",
			"lightbox_gallery": "true",
			"woocommerce_lightbox": "",
			"lightbox_skin": "dark",
			"lightbox_thumb": "vertical",
			"lightbox_arrows": "",
			"is_singular": "",
			"reading_indicator": "",
			"lang_no_results": "No Results",
			"lang_results_found": "Results Found"
		};
		/* ]]> */
	</script>
</body>

</html>