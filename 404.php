<?php
http_response_code(404);
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
$SearchKeyword = @cleanQuery($_GET['q']);

$RandomPins = getRandomPosts(5, true); //Random Posts
$categories = getCategories(); //Categoriest->fetchAll();
$PopularPins = getPopularPosts(); //Popular Pins
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
					<div class="content">
						<nav id="crumbs"><a rel="home" href="/"><span class="fa fa-home" aria-hidden="true"></span> Home</a></nav>
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
								}]
							}
						</script>
						<div class="page-head">
							<h2 class="page-title">
								Nothing Found </h2>
							<div class="stripe-line"></div>
						</div>
						<div id="post-0" class="post not-found post-listing">
							<div class="entry">
								<p>Sorry, but nothing matched your criteria. Please try again with some different post or keywords.</p>
							</div>
						</div>
						<?= $settings["site_ads_baglanti"]; ?>
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