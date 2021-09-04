<?php
/**
 * @var int $id_object_type
 */
?>
<div class="search-wrapper--tabs">
    <?php if (!empty(TS_TOUR_PRODUCTS)) {?>
    <button class="search-wrapper--tabs_btn <?php echo TS_TOUR_PRODUCTS == $id_object_type ? 'is--active' : ''; ?>" data-pm-ot="<?php echo TS_TOUR_PRODUCTS; ?>">
        Rundreisen
    </button>
    <?php } ?>
    <?php
    if (empty(!TS_DAYTRIPS_PRODUCTS)) {
        ?>
        <button class="search-wrapper--tabs_btn <?php echo TS_DAYTRIPS_PRODUCTS == $id_object_type ? 'is--active' : ''; ?>" data-pm-ot="<?php echo TS_DAYTRIPS_PRODUCTS; ?>">
            Tagesfahrten
        </button>
    <?php } ?>
</div>