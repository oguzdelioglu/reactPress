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
$PinSayısı = 8;


$SearchKeyword = cleanQuery($_GET['q']);
if (strlen($SearchKeyword) <= 2) {
	header("Location: /404", 404);
	die();
}
$SearchKeyword_Slug = str_replace(" ", "-", $SearchKeyword);


//Pagination
$TotalPins = getPostCount($SearchKeyword);
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
	$page = (int) $_GET['page'];
	$offset = ($page - 1) * $PinSayısı;
} else {
	$page = 0;
	$offset = 0;
}
//Pagination


$Pins = getPostList($SearchKeyword, $offset, $PinSayısı); //POSTS

//404
if (empty($Pins)) {
	header("Location: /404", 404);
	die();
}

$categories = getCategories(); //Categories
$tags = getTags(); //Tags
$PopularPins = getPopularPosts(); //Popular Pins
$RandomPins = getRandomPosts(); //Random Posts
$LatestPosts = getLastPosts(); //Latest Posts
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

					<?php
					if ($reqtype == "search") {
					?>
						<div class="page-head">
							<h2 class="page-title">
								Search Results for: <span><?= $SearchKeyword; ?></span> </h2>
							<div class="stripe-line"></div>
						</div>
					<?
					}
					?>
					<div class="content">
						<nav id="crumbs"><a rel="home" href="/"><span class="fa fa-home" aria-hidden="true"></span> Home</a><span class="delimiter">/</span><span class="current"><?= ucfirst($SearchKeyword_Slug) ?></span></nav>
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
										"name": "<?= ucfirst($SearchKeyword) ?>",
										"@id": "<?= $domain ?>category/<?= $SearchKeyword_Slug ?>"
									}
								}]
							}
						</script>
						<?= $settings["site_ads_baglanti"]; ?>
						<div class="post-listing archive-box">
							<?php
							foreach ($Pins as $index => $Pin) {
								if (file_exists('uploads/350x350/' . $Pin["post_link"] . '.jpg')) {
									$imglink = $domain . 'uploads/350x350/' . $Pin["post_link"] . '.jpg';
								} elseif ($Pin["mypin_img"] != "") {
									$imglink = $Pin["mypin_img"];
								} else {
									$imglink = $Pin["pin_img"];
								}
								$Pin["category"] = explode(",", $Pin["pintaglist"])[0];
								$Pin["category_slug"] = str_replace(" ", "-", $Pin["category"]); ?>
								<article class="item-list tie_lightbox">
									<h2 class="post-box-title">
										<a <?php echo $reqtype == "search" ? ' rel="nofollow" ' : ''; ?> href="/post/<?= $Pin["post_link"] ?>"><?= $Pin["pin_title"] ?></a>
									</h2>
									<p class="post-meta">
										<span class="post-cats"><i class="fa fa-folder"></i><a <?php echo $reqtype == "search" ? ' rel="nofollow" ' : ''; ?> href="/category/<?= $Pin["category_slug"] ?>" rel="category"><?= ucfirst($Pin["category"]) ?></a></span>
									</p>
									<div class="post-thumbnail">
										<a title="<?= cleanQuery($Pin["pin_title"]) ?>" <?php echo $reqtype == "search" ? ' rel="nofollow" ' : ''; ?> href="/post/<?= $Pin["post_link"] ?>">
											<img width="350" height="350" src="<?= $imglink ?>" class="attachment-tie-medium size-tie-medium wp-post-image" alt="<?= $Pin["pin_title"] ?>" /> <span class="fa overlay-icon"></span>
										</a>
									</div>
									<div class="entry">
										<p><?= shortenText($Pin["pin_title"], 280) ?>
										</p>
										<a class="more-link" <?php echo $reqtype == "search" ? ' rel="nofollow" ' : ''; ?> href="/post/<?= $Pin["post_link"] ?>">Read More &raquo;</a>
									</div>
									<div class="clear"></div>
								</article>
							<?php
							}
							?>
							<?= $settings["site_ads_baglanti"]; ?>
						</div>

						<?php include_once 'include/pagination.php'; ?>
					</div><!-- .content /-->
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