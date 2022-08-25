<aside id="sidebar">
  <div class="theiaStickySidebar">
    <div class="widget">
      <!-- ADS300-600 /-->
      <?= $settings["site_ads_300-600"]; ?>
    </div>
    <? if (isset($RandomPins)) { //if(!isset($next["post_link"]) AND !isset($previus["post_link"]) AND isset($RandomPins))
    ?>
      <div class="e3lan-widget-content">
        <div class="widget-top">
          <h2>Our Picks</h2>
          <div class="stripe-line"></div>
        </div>
        <?
        foreach (array_slice($RandomPins, 0, 2) as $Pin) {
        ?>
          <div class="widget">
            <?
            if (file_exists('uploads/350x350/' . $Pin["post_link"] . '.jpg')) {
              $imglink = $domain . 'uploads/350x350/' . $Pin["post_link"] . '.jpg';
            } else if ($Pin["mypin_img"] != "") {
              $imglink = $Pin["mypin_img"];
            } else {
              $imglink = $Pin["pin_img"];
            }
            ?>
            <div class="post-thumbnail">
              <a rel="bookmark" href="/post/<?= $Pin["post_link"] ?>" title="<?= shortenText($Pin["pin_title"], 100) ?>"><img width="350" height="350" src="<?= $imglink ?>" class="attachment-tie-medium size-tie-medium wp-post-image" alt="" /><span class="fa overlay-icon"></span></a>
            </div>
            <h3><a rel="bookmark" href="/post/<?= $Pin["post_link"] ?>"><?= shortenText($Pin["pin_title"], 100) ?></a></h3>
          </div>
        <?
        }
        ?>
      </div>
    <?
    }
    ?>

    <!-- Categories /-->
    <div class="widget widget_categories">
      <div class="widget-top">
        <h2>Categories</h2>
        <div class="stripe-line"></div>
      </div>
      <div class="widget-container">
        <ul>
          <?
          foreach ($categories as $category) {
            echo ' <li class="cat-item"><a rel="category" href="/category/' . str_replace(" ", "-", $category["tag_name"]) . '">' . ucfirst($category["tag_name"]) . ' (' . $category["pinCount"] . ')</a></li>';
          }
          ?>
        </ul>
      </div>
    </div>


    <? if (isset($tags)) { ?>
      <!-- ADS-FLUID /-->


      <!-- Recent-Popular-Tags /-->
      <div class="widget" id="tabbed-widget">
        <div class="widget-container">
          <div class="widget-top">
            <ul class="tabs posts-taps">
              <li class="tabs"><a href="#tags">Tags</a></li>
            </ul>
          </div>
          <!-- Tags /-->
          <div id="tags" class="tabs-wrap tagcloud">
            <!-- Widget Tags -->
            <div class="widget">
              <h2 class="widget-title">Tags</h2>
              <div class="widget-tags">
                <?
                foreach ($tags as $index => $tag) {
                  echo '<a class="tag-cloud-link" rel="nofollow" href="/search/' . str_replace(" ", "-", $tag["tag_name"]) . '" style="font-size: 12pt;">' . $tag["tag_name"] . '</a>';
                }
                ?>
              </div>
            </div>
          </div>
        </div>
      </div><!-- .widget /-->


      <div class="widget">
        <?= $settings["site_ads_300-600"]; ?>
      </div>
    <? } ?>
  </div><!-- .theiaStickySidebar /-->
</aside><!-- #sidebar /-->