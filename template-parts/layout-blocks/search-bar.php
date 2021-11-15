<?php
/**
 *  <code>
 *  $args['class'] // main-color, silver, transparent
 *
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
<section class="layout-block layout-block-search-bar">
    <div class="layout-block-search-bar--search <?php echo empty($args['class']) ? '' : $args['class']; ?>">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 ">
                    <?php require  get_stylesheet_directory().'/template-parts/pm-search/search-bar-plain.php';?>
                </div>
            </div>
        </div>
    </div>
</section>