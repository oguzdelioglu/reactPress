<?php
/*
require_once('sCache.php');
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

//Pagination
$TotalPins = Pagination();
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
	$page = (int) $_GET['page'];
	$offset = ($page - 1) * $PinSayısı;
} else {
	$page = 0;
	$offset = 0;
}
//Pagination

$Pins = getPosts($offset, $PinSayısı);
$categories = getCategories();
$tags = getTags();
$PopularPins = getPopularPosts();
$RandomPins = getRandomPosts();
$LatestPosts = getLastPosts();

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
										<a href="/post/<?= $Pin["post_link"] ?>"><?= $Pin["pin_title"] ?></a>
									</h2>
									<p class="post-meta">
										<span class="post-cats"><i class="fa fa-folder"></i><a href="/category/<?= $Pin["category_slug"] ?>" rel="category"><?= ucfirst($Pin["category"]) ?></a></span>
									</p>
									<div class="post-thumbnail">
										<a title="<?= cleanQuery($Pin["pin_title"]) ?>" href="/post/<?= $Pin["post_link"] ?>">
											<img width="350" height="350" src="<?= $imglink ?>" class="attachment-tie-medium size-tie-medium wp-post-image" alt="<?= cleanQuery($Pin["pin_title"]) ?>" /> <span class="fa overlay-icon"></span>
										</a>
									</div>
									<div class="entry">
										<p><?= truncate($Pin["pin_title"], 280) ?>
										</p>
										<a class="more-link" href="/post/<?= $Pin["post_link"] ?>">Read More &raquo;</a>
									</div>
									<div class="clear"></div>
								</article>
							<?php
							}
							?>
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