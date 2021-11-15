<?php
/**
 * <code>
 *  $args['headline']
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

<section class="layout-block layout-block-search-header">
    <div class="layout-block-search-header--search">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-11 col-xl-10">
                <?php require  get_template_directory().'/template-parts/pm-search/search-bar.php';?>
                </div>
            </div>
        </div>
    </div>
</section>