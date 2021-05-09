<?php
/**
 @var array $args
 */

?>
<section class="layout-block layout-block-search-bar">
    <div class="layout-block-search-bar--search <?php echo empty($args['class']) ? '' : $args['class']; ?>">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-11 col-xl-10">
                    <?php require  get_stylesheet_directory().'/template-parts/pm-search/search-bar-plain.php';?>
                </div>
            </div>
        </div>
    </div>
</section>