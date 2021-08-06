<?php
/**
 * @var $id_object_type
 */


if (empty($_GET['pm-ot']) === true) { // if the id_object_type is not defined by search, we use the information from the route
    $_GET['pm-ot'] = $id_object_type;
} else {
    $id_object_type = (int)$_GET['pm-ot'];
}


$search = BuildSearch::fromRequest($_GET, 'pm', false);
?>
<div class="content-block content-block-list-filter">
    <form id="filter" action="" method="GET">
        <input type="hidden" name="pm-ot" value="<?php echo $id_object_type; ?>">
        <div class="list-filter">
            <div class="h4 mt-0 mb-4"><i class="la la-filter"></i> Filter</div>

            <button class="list-filter-close">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="28" height="28"
                     viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFFFFF" fill="none" stroke-linecap="round"
                     stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z"/>
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
            <div class="list-filter-boxes">
                <?php
                require 'filter/order.php';
                require 'filter/price-range.php';
                require 'filter/duration-range.php';

                // remove the filter from the search result, to allow access to all items in the filter
                // if you remove this lines, the filter will be collapsed to the possible items that matches
                // to the current search
                $remove_items = [];
                foreach(TS_FILTERS as $filter){
                    $remove_items[] = 'pm-'.$filter['condition_type'].'['.$filter['fieldname'].']';
                }
                //$filter_fieldnames[] = 'pm-ho';

                $filter_search = BuildSearch::rebuild($remove_items);

                // draw filters
                foreach(TS_FILTERS as $filter){
                    list($id_tree, $fieldname, $name, $condition_type) = array_values($filter);
                    require 'filter/category-tree.php';
                }

                ?>
                <div class="list-filter-box list-filter-box-submit">
                    <button type="button" class="btn btn-primary btn-block filter-prompt">Filter anwenden</button>
                </div>
            </div>
        </div>

    </form>
</div>