<header id="theme-header" class="theme-header">
  <div class="header-content">
    <a title="Menu" id="slide-out-open" class="slide-out-open" href="#"><span></span></a>
    <div class="search-block">
      <form method="get" id="searchform-header" action="search">
        <button aria-label="search-button" class="search-button" type="submit" placeholder="Search"><i class="fa fa-search"></i></button>
        <input class="search-live" type="text" id="s-header" name="q" title="Search" placeholder="Search" minlength="3" maxlength="20" required onfocus="if (this.value == 'Search') {this.value = '';}" onblur="if (this.value == '') {this.placeholder = 'Search';}" />
      </form>
      <script>
        (function() {
          var wordInput = document.getElementById("s-header");
          var form_el = document.getElementById("searchform-header");
          form_el.addEventListener("submit", function(e) {
            e.preventDefault();
            window.location.href = "/search/" + wordInput.value
          });
        })()
      </script>
    </div><!-- .search-block /-->
    <div class="logo">
      <h1> <a rel="home" title="<?= $settings["site_title"] ?>" href="/">
          <img src="/css/images/logo.png" alt="<?= $settings["site_title"] ?>" width="175" height="44" /><strong><?= $settings["site_title"] ?></strong>
        </a>
      </h1>
    </div><!-- .logo /-->
    <div class="clear"></div>
  </div>
  <nav id="main-nav" class="fixed-enabled">
    <div class="container">
      <div class="main-menu">
        <ul id="menu-ana-menu" class="menu">
          <li id="menu-item-1" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home"><a rel="home" href="/">Home</a></li>
          <? 
          foreach (array_slice($categories, 0, 5) as $index => $category) {
            echo ' <li id="menu-item-' . $index . '" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-' . $index . '"><a rel="category" href="/category/' . str_replace(" ", "-", $category["tag_name"]) . '"><i class="fa fa-folder"></i>' . ucfirst($category["tag_name"]) . '</a></li>';
          }
          ?>
        </ul>
      </div>
    </div>
  </nav><!-- .main-nav /-->
  <?= $settings["site_ads_responsive"]; ?>
</header><!-- #header /-->