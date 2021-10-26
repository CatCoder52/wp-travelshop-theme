<?php

use Pressmind\Travelshop\RouteHelper;

/**
 * @var int $id_object_type
 * @var array $args
 */

if(empty($id_object_type) === true){
    $id_object_type = TS_TOUR_PRODUCTS;
}

?>
<div class="search-wrapper">
    <?php
    if(!empty(TS_TOUR_PRODUCTS) && !empty(TS_DAYTRIPS_PRODUCTS)) {
        require 'search/searchbar-tabs.php';
    }
    require 'search/searchbar-form.php';
    ?>
</div>