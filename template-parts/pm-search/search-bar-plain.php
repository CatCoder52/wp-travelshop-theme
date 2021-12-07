<?php

use Pressmind\Travelshop\RouteHelper;

/**
 * <code>
 *  $args[total_result] => 112
 *  $args[current_page] => 1
 *  $args[pages] => 10
 *  $args[page_size] => 12
 *  $args[id_object_type] => 2277
 *  $args[... some more values search result ...]
 * </code>
 * @var array $args
 */

?>
<div class="search-wrapper">
    <?php
    if(!empty(TS_TOUR_PRODUCTS) && !empty(TS_DAYTRIPS_PRODUCTS)) {
        require 'search/searchbar-tabs.php';
    }
    require 'search/searchbar-form.php';
    ?>
</div>