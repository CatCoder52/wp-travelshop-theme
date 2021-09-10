<?php

/**
 *  @var int $id_object_type
 */

use Pressmind\Travelshop\RouteHelper;

$search = new Pressmind\Search(
    [
        Pressmind\Search\Condition\Visibility::create(TS_VISIBILTY),
        Pressmind\Search\Condition\ObjectType::create($id_object_type),
    ]
);

// get the whole object count for displaying the item count in the search button
$mediaObjects = $search->getResults();
$total_result = $search->getTotalResultCount();


// NO WORDPRESS FUNCTIONS HERE! (also used in ajax calls)
?>

<form id="main-search" method="GET">
    <input type="hidden" name="pm-ot" value="<?php echo $id_object_type; ?>">

    <div class="search-wrapper--inner search-box">

        <div class="row">

            <div class="col-12 col-md-3">
                <?php
                require 'string-search.php';
                ?>
            </div>

            <div class="col-12 col-md-3 travelshop-datepicker">
                <?php
                require 'date-picker.php';
                ?>
            </div>

            <?php
            // draw category tree based search fields
            if(empty(TS_SEARCH[$id_object_type]) === false){
                foreach (TS_SEARCH[$id_object_type] as $searchItem) { ?>
                    <div class="col-12 col-md-3">
                        <?php
                        list($id_tree, $fieldname, $name, $condition_type) = array_values($searchItem);
                        require 'category-tree-dropdown.php';
                        ?>
                    </div>
                    <?php
                }
            } ?>

            <div class="col-12 col-md-3 mb-md-0">
                <div class="form-group mb-0">
                    <label class="d-none d-md-block">&nbsp;</label>
                    <a class="btn btn-primary btn-block"
                       href="<?php echo SITE_URL . '/' . RouteHelper::get_url_by_object_type($id_object_type) . '/'; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-search" width="20"
                             height="20" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ffffff" fill="none"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <circle cx="10" cy="10" r="7"/>
                            <line x1="21" y1="21" x2="15" y2="15"/>
                        </svg>
                        <span class="search-bar-total-count" data-default="Suchen" data-total-count-singular="Reise"
                              data-total-count-plural="Reisen"><?php echo empty($total_result) ? 'Suchen' : $total_result . ' Reisen'; ?></span>
                    </a>
                </div>
            </div>
        </div>

    </div>
</form>