<!-- CONTENT_SECTION_LIST_FILTER: START -->
<?php
/**
 * @var $id_object_type
 */


if(empty($_GET['pm-ot']) === true){ // if the id_object_type is not defined by search, we use the information from the route
    $_GET['pm-ot'] = $id_object_type;
}else{
    $id_object_type = (int)$_GET['pm-ot'];
}



/**
 * build the filter based on the current search request
 */

$search = new Pressmind\Search(
    [
        //Pressmind\Search\Condition\Category::create('zielgebiet_default', ['304E15ED-302F-CD33-9153-14B8C6F955BD', '4C5833CB-F29A-A0F4-5A10-14B762FB4019', '78321653-CF81-2EF1-ED02-9D07E01651C1']),
        //Pressmind\Search\Condition\PriceRange::create(100, 3000),
        //Pressmind\Search\Condition\DurationRange::create(0, 30),
        //Pressmind\Search\Condition\Visibility::create([10,30]),
        Pressmind\Search\Condition\ObjectType::create($id_object_type),
    ]
);

$search = BuildSearch::fromRequest($_GET, 'pm', false);

?>
<div class="content-block content-block-list-filter">

    <form id="filter" action="" method="GET">

        <input type="hidden" name="pm-ot" value="<?php echo $id_object_type;?>">
        <div class="list-filter">
            <div class="h4 mt-0 mb-4"><i class="la la-filter"></i> Filter</div>

            <button class="list-filter-close">
                <i class="la la-times"></i>
            </button>

            <div class="list-filter-boxes">

                <!-- FILTER_SORT: START -->
               <?php
               require 'filter/order.php';
               ?>
                <!-- FILTER_SORT: END -->

                <!-- FILTER_PRICE: START -->
                <?php require 'filter/price-range.php'; ?>
                <!-- FILTER_PRICE: END -->

                <!-- FILTER_DESTINATION: START -->
                <?php

                // @todo all Items as
                $id_tree = 1207;
                $name = 'Zielgebiete';
                $fieldname = 'zielgebiet_default';

                require 'filter/category-tree.php';

                ?>
                <!-- FILTER_DESTINATION: END -->

                <!-- FILTER_ANREISE: START -->
                <?php

                $id_tree = 1206;
                $name = 'Reiseart';
                $fieldname = 'reiseart_default';
                require 'filter/category-tree.php';

                ?>
                <!-- FILTER_ANREISE: END -->

                <!-- FILTER_ANREISE: START -->
                <?php

                $id_tree = 2655;
                $name = 'Beförderung';
                $fieldname = 'befoerderung_default';
                require 'filter/category-tree.php';

                ?>
                <!-- FILTER_ANREISE: END -->


                <!-- FILTER_ANREISE: START -->
                <?php

                $id_tree = 1204;
                $name = 'Saison';
                $fieldname = 'saison_default';
                require 'filter/category-tree.php';

                ?>
                <!-- FILTER_ANREISE: END -->

                <!-- FILTER_SUBMIT: START -->
                <div class="list-filter-box list-filter-box-submit">
                    <button type="button" class="btn btn-outline-primary btn-block filter-prompt">Filter anwenden</button>
                </div>
                <!-- FILTER_SUBMIT: END -->

            </div>
        </div>

    </form>
</div>
<!-- CONTENT_SECTION_LIST_FILTER: END -->