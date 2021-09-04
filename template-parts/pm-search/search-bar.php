<?php

/**
 *  @var int $id_object_type
 *
 *  <code>
 *  $args['class'] // main-color, silver, transparent
 *  $args['headline']
 * </code>
 * @var array $args
 */

if(empty($id_object_type) === true){
    $id_object_type = TS_TOUR_PRODUCTS;
}


?>
<div class="search-wrapper">
    <?php if(!empty($args['headline'])){?>
        <div class="h1 text-md-center mt-0 mb-2 mb-4">
            <?php echo $args['headline'];?>
        </div>
    <?php } ?>
    <?php
    if(!empty(TS_TOUR_PRODUCTS) && !empty(TS_DAYTRIPS_PRODUCTS)){
        require 'search/searchbar-tabs.php';
    }
    require 'search/searchbar-form.php';
    ?>
</div>