<?php
/**
 * @var int $id_object_type
 */

use Pressmind\Travelshop\RouteHelper;

global $id_object_type;

if(empty($id_object_type) === true){
    $id_object_type = TS_TOUR_PRODUCTS;
}

$search = new Pressmind\Search(
    [
        Pressmind\Search\Condition\Visibility::create(TS_VISIBILTY),
        Pressmind\Search\Condition\ObjectType::create($id_object_type),
    ]
);


$mediaObjects = $search->getResults();
$total_result = $search->getTotalResultCount();

?>
<div class="search-wrapper">
    <?php

    require 'search/searchbar-tabs.php';

    ?>
    <form method="GET">
        <input type="hidden" name="pm-ot" value="<?php echo $id_object_type;?>">
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
            foreach(TS_SEARCH[$id_object_type] as $searchItem){ ?>
                    <?php
                    list($id_tree, $fieldname, $name, $condition_type) = array_values($searchItem);
                    require 'search/category-tree-dropdown.php';
                    ?>
                <?php
            } ?>


            <div>
                <div class="form-group mb-0">
                    <a class="btn btn-primary btn-block" href="<?php echo SITE_URL.'/'.RouteHelper::get_url_by_object_type($id_object_type).'/'; ?>">
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
    </form>
</div>