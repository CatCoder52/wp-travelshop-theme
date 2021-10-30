<?php
/**
 * @var int $id_object_type
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
<div class="search-wrapper--tabs">
    <?php if (!empty(TS_TOUR_PRODUCTS)) {?>
    <button class="search-wrapper--tabs_btn <?php echo TS_TOUR_PRODUCTS == $args['id_object_type'] ? 'is--active' : ''; ?>" data-pm-ot="<?php echo TS_TOUR_PRODUCTS; ?>">
        Rundreisen
    </button>
    <?php } ?>
    <?php
    if (empty(!TS_DAYTRIPS_PRODUCTS)) {
        ?>
        <button class="search-wrapper--tabs_btn <?php echo TS_DAYTRIPS_PRODUCTS == $args['id_object_type'] ? 'is--active' : ''; ?>" data-pm-ot="<?php echo TS_DAYTRIPS_PRODUCTS; ?>">
            Tagesfahrten
        </button>
    <?php } ?>
</div>