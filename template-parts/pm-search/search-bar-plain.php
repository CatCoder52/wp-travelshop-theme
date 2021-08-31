<?php

global $PMTravelShop;
use Pressmind\Travelshop\RouteProcessor;

if(empty($id_object_type) === true){
    $id_object_type = TS_TOUR_PRODUCTS;
}

$search = new Pressmind\Search(
    [
        Pressmind\Search\Condition\Visibility::create(TS_VISIBILTY),
        Pressmind\Search\Condition\ObjectType::create($id_object_type),
    ]
);

/**
 * perform a search to display the item count on the search button,
 * we se a transient to cache the result for about 60 seconds
 */

$transient = 'ts_total_count_'.md5(serialize($search->getConditions()));
if (($total_result = get_transient( $transient)) === false) {
    $mediaObjects = $search->getResults();
    $total_result = $search->getTotalResultCount();
    set_transient($transient, $total_result, 60);
}
?>
<form method="GET">
    <div class="search-wrapper">
        <div class="search-wrapper--inner search-box">
            <div>
                <?php
                require 'search/string-search.php';
                ?>
            </div>

            <div class="travelshop-datepicker">
                <?php
                require 'search/date-picker.php';
                ?>
            </div>

            <?php
            // draw category tree based search fields
            foreach(TS_SEARCH as $searchItem){ ?>
                <div>
                    <?php
                    list($id_tree, $fieldname, $name, $condition_type) = array_values($searchItem);
                    require 'search/category-tree-dropdown.php';
                    ?>
                </div>
                <?php
            } ?>

            <!--
            <div>
                <div class="form-group ">
                    <a class="btn btn-text btn-block" href="<?php echo site_url().'/calendar/'; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-calendar-event" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="#212529" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <rect x="4" y="5" width="16" height="16" rx="2"></rect>
                            <line x1="16" y1="3" x2="16" y2="7"></line>
                            <line x1="8" y1="3" x2="8" y2="7"></line>
                            <line x1="4" y1="11" x2="20" y2="11"></line>
                            <rect x="8" y="15" width="2" height="2"></rect>
                        </svg>
                        Reisekalender
                    </a>
                </div>
            </div>
            -->

            <div>
                <div class="form-group mb-0">
                    <a class="btn btn-primary btn-block" href="<?php echo site_url().'/'.$PMTravelShop->RouteProcessor->get_url_by_object_type(TS_TOUR_PRODUCTS).'/'; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="20" height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <circle cx="10" cy="10" r="7" />
                            <line x1="21" y1="21" x2="15" y2="15" />
                        </svg>
                        <span class="search-bar-total-count" data-default="Suchen" data-total-count-singular="Reise" data-total-count-plural="Reisen"><?php echo empty($total_result) ? 'Suchen' : $total_result. ' Reisen'; ?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>