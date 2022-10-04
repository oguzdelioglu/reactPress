<?php include_once 'include/scripts.php'; ?>
<div class="e3lan e3lan-bottom">
  <?= $settings["site_ads_responsive"]; ?>
</div>

<footer id="theme-footer">
  <div id="footer-widget-area" class="footer-3c">
    <div id="footer-first" class="footer-widgets-box">
      <div id="posts-list-widget-2" class="footer-widget posts-list">
        <div class="footer-widget-top">
          <h3>Popular Posts </h3>
        </div>
        <div class="footer-widget-container">
          <ul>
            <?php
            foreach ($PopularPins as $index => $Pin) {
              if (file_exists('uploads/350x350/' . $Pin["post_link"] . '.jpg')) {
                $imglink = $domain . 'uploads/350x350/' . $Pin["post_link"] . '.jpg';
              } elseif ($Pin["mypin_img"] != "") {
                $imglink = $Pin["mypin_img"];
              } else {
                $imglink = $Pin["pin_img"];
              } ?>
              <li>
                <div class="post-thumbnail">
                  <a href="/post/<?= $Pin["post_link"] ?>" title="<?= shortenText($Pin["pin_title"], 100) ?>" rel="bookmark"><img width="350" height="350" src="<?= $imglink ?>" class="attachment-tie-small size-tie-small wp-post-image" alt="" /><span class="fa overlay-icon"></span></a>
                </div><!-- post-thumbnail /-->
                <h4><a href="/post/<?= $Pin["post_link"] ?>"><?= shortenText($Pin["pin_title"], 100) ?></a></h4>
              </li>
            <?php
            }
            ?>
          </ul>
          <div class="clear"></div> 
        </div>
      </div><!-- .widget /-->
    </div>
    <div id="footer-second" class="footer-widgets-box">
      <div id="posts-list-widget-3" class="footer-widget posts-list">
        <div class="footer-widget-top">
          <h3>Random Posts </h3>
        </div>
        <div class="footer-widget-container">
          <ul>
            <?php
            foreach ($RandomPins as $index => $Pin) {
              if (file_exists('uploads/350x350/' . $Pin["post_link"] . '.jpg')) {
                $imglink = $domain . 'uploads/350x350/' . $Pin["post_link"] . '.jpg';
              } elseif ($Pin["mypin_img"] != "") {
                $imglink = $Pin["mypin_img"];
              } else {
                $imglink = $Pin["pin_img"];
              } ?>
              <li>
                <div class="post-thumbnail">
                  <a href="/post/<?= $Pin["post_link"] ?>" title="<?= shortenText($Pin["pin_title"], 100) ?>" rel="bookmark"><img width="350" height="350" src="<?= $imglink ?>" class="attachment-tie-small size-tie-small wp-post-image" alt="" /><span class="fa overlay-icon"></span></a>
                </div><!-- post-thumbnail /-->
                <h4><a href="/post/<?= $Pin["post_link"] ?>"><?= shortenText($Pin["pin_title"], 100) ?></a></h4>
              </li>
            <?php
            }
            ?>
          </ul>
          <div class="clear"></div>
        </div>
      </div><!-- .widget /-->
    </div><!-- #second .widget-area -->
    <div id="footer-third" class="footer-widgets-box">
      <div id="posts-list-widget-4" class="footer-widget posts-list">
        <div class="footer-widget-top">
          <h3>Latest Posts </h3>
        </div>
        <div class="footer-widget-container">
          <ul>
            <?php
            foreach ($LatestPosts as $index => $Pin) {
              if (file_exists('uploads/350x350/' . $Pin["post_link"] . '.jpg')) {
                $imglink = $domain . 'uploads/350x350/' . $Pin["post_link"] . '.jpg';
              } elseif ($Pin["mypin_img"] != "") {
                $imglink = $Pin["mypin_img"];
              } else {
                $imglink = $Pin["pin_img"];
              } ?>
              <li>
                <div class="post-thumbnail">
                  <a href="/post/<?= $Pin["post_link"] ?>" title="<?= shortenText($Pin["pin_title"], 100) ?>" rel="bookmark"><img width="350" height="350" src="<?= $imglink ?>" class="attachment-tie-small size-tie-small wp-post-image" alt="" /><span class="fa overlay-icon"></span></a>
                </div><!-- post-thumbnail /-->
                <h4><a href="/post/<?= $Pin["post_link"] ?>"><?= shortenText($Pin["pin_title"], 100) ?></a></h4>
              </li>
            <?php
            }
            ?>
          </ul>
          <div class="clear"></div>
        </div>
      </div><!-- .widget /-->
    </div><!-- #third .widget-area -->
  </div><!-- #footer-widget-area -->

  <?php
  if ($_SERVER['REQUEST_URI'] != "/") {
  ?>
    <script>
      $(function() {
        var nowDate = new Date(),
          date = new Date(nowDate);
        date.setMinutes(nowDate.getMinutes() + 10);
        console.log("Date:" + date.getTime());
        var prevDate = localStorage.getItem("date");
        console.log("Prev Date:" + prevDate);
        console.log("Diff:" + (prevDate));
        if (!prevDate || prevDate < nowDate.getTime()) {
          if (window.location.href.indexOf("/search/") > -1 || window.location.href.indexOf("/category/") > -1) {
            console.log("Category Or Search Not Recorded.");
            console.log(window.location.href);
          } else {
            console.log("Visitor OKEY");
            localStorage.setItem("date", date.getTime());
            visitor();
          }

        }
      });

      function visitor() {
        var settings = {
          "url": "<?php echo $domain . 'api'; ?>",
          "method": "POST",
          "headers": {
            "Content-Type": "application/x-www-form-urlencoded"
          },
          "data": {
            "SITE": location.host,
            "LINK": location.protocol + '//' + location.host + location.pathname,
            "USERAGENT": navigator.userAgent,
            "BROWSER_LANGUAGE": navigator.language,
            "TYPE": "HIT_INCREASE"
          }
        };
        $.ajax(settings).done(function(response) {});
      }
    </script>
  <?php
  }
  ?>

  <div class="clear"></div>
</footer><!-- .Footer /-->
<div class="clear"></div>
<div class="footer-bottom">
  <div class="container">
    <div class="alignright">
      Powered by <a href="http://wordpress.org">WordPress</a> | Designed by <a href="https://oguzdelioglu.com/">Oğuz DELİOĞLU</a> </div>
    <div class="alignleft">
      © Copyright 2020, All Rights Reserved </div>
    <div class="clear"></div>
  </div><!-- .Container -->
</div><!-- .Footer bottom -->