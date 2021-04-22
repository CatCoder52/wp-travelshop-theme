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


$search = BuildSearch::fromRequest($_GET, 'pm', false);

?>
<div class="content-block content-block-list-filter">

    <form id="filter" action="" method="GET">

        <input type="hidden" name="pm-ot" value="<?php echo $id_object_type;?>">
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
                    <button type="button" class="btn btn-primary btn-block filter-prompt">Filter anwenden</button>
                </div>
                <!-- FILTER_SUBMIT: END -->

            </div>
        </div>

    </form>
</div>
<!-- CONTENT_SECTION_LIST_FILTER: END -->