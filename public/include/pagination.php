<?php
// find out total pages
$totalpages = ceil($TotalPins / $PinSayısı);
// get the current page or set a default
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    // cast var as int
    $page = (int) $_GET['page'];
} else {
    // default page num
    $page = 1;
} // end if
// if current page is greater than total pages...
if ($page > $totalpages) {
    // set current page to last page
    $page = $totalpages;
} // end if
// if current page is less than first page...
if ($page < 1) {
    // set current page to first page
    $page = 1;
} // end if
// get the info from the db 
/******  build the pagination links ******/
// range of num links to show
$range = 3;
?>
<div class="pagination">
    <?

    $current_url = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    $current_url = filter_var($current_url,FILTER_SANITIZE_SPECIAL_CHARS);
    // if not on page 1, don't show back links
    if ($page > 1) {
        // show << link to go back to page 1
        echo " <a href='" . $current_url . "?page=1' class=\"page\">First</a> ";
        // get previous page num
        $prevpage = $page - 1;
        // show < link to go back to 1 page
        echo " <span rel=\"prev\" id=\"tie-prev-page\"><a href='" . $current_url . "?page=$prevpage'>&laquo</a></span> ";
    } // end if 
    // loop to show links to range of pages around current page
    for ($x = ($page - $range); $x < (($page + $range) + 1); $x++) {
        // if it's a valid page number...
        if (($x > 0) && ($x <= $totalpages)) {
            // if we're on current page...
            if ($x == $page) {
                // 'highlight' it but don't make a link
                echo ' <span class="current">' . $x . '</span>';
                // if not current page...
            } else {
                // make it a link
                echo " <a href='" . $current_url . "?page=$x'  class=\"page\" title=\"" . $x . "\">$x</a> ";
            } // end else
        } // end if 
    } // end for
    // if not on last page, show forward and last page links        
    if ($page != $totalpages) {
        // get next page
        $nextpage = $page + 1;
        // echo forward link for next page 
        echo " <span id=\"tie-next-page\"><a rel=\"next\" href='" . $current_url . "?page=$nextpage'> &raquo; </a></span> ";
        // echo forward link for lastpage
        //echo " <a href='".$current_url."?page=$totalpages'> Last </a> ";
    } // end if
    /****** end build pagination links ******/
    ?>
</div>