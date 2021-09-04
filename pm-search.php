<?php
/**
 * @var WP_Query $wp_query
 */

get_header();

/**
 * @var int $id_object_type ($wp_query->get('id_object_type') is defined in config-routing.php, see ts_search_hook())
 */
$id_object_type = (int)$wp_query->get('id_object_type');

?>
<main>
    <?php
    $args = [];
    $args['headline'] = 'Finde deine Traumreise!';
    load_template_transient(get_template_directory() . '/template-parts/layout-blocks/search-header.php', false, $args, );
    ?>
    <?php the_breadcrumb(null); ?>
    <div class="content-main">
        <div class="container">

            <div class="row">
                <div class="col-12 col-md-4 col-lg-3">
                    <nav id="search-filter">
                        <?php
                            // this content will be replaced by ajax during the search, @see travelshop/assets/js/ajax.js
                            load_template(get_template_directory() . '/template-parts/pm-search/filter-vertical.php', false);

                            ?>
                    </nav>
                </div>
                <div class="col-12 col-md-8 col-lg-9">
                    <div id="search-result">
                        <?php
                            // this content will be replaced by ajax during the search, @see travelshop/assets/js/ajax.js
                            load_template(get_stylesheet_directory() . '/template-parts/pm-search/result.php');
                            ?>
                    </div>
                </div>
            </div>

            <hr class="mt-0 mb-0">
            <?php load_template(get_template_directory() . '/template-parts/layout-blocks/info-teaser.php'); ?>
        </div>
    </div>

</main>
<?php
get_footer();