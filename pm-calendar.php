<?php
/**
 * @var WP_Query $wp_query
 */
get_header();
?>
    <main>
        <?php the_breadcrumb(null); ?>
        <div class="content-main">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <?php
                        $args = [
                            'headline' => 'Reisekalender',
                            'text' => 'Travel is the movement of people between relatively distant geographical locations, and can involve travel by foot, bicycle, automobile, train, boat, bus, airplane, or other means, with or without luggage, and can be one way or round trip.',
                        ];
                        load_template_transient(get_stylesheet_directory() . '/template-parts/layout-blocks/product-calendar.php', false, $args);
                        ?>
                    </div>
                </div>
                <?php //load_template(get_template_directory() . '/template-parts/layout-blocks/info-teaser.php'); ?>
            </div>
        </div>
    </main>
<?php
get_footer();