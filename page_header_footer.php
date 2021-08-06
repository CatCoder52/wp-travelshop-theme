<?php
/**
 * Template Name: Header & Footer only
 * Template Post Type: page
 */
get_header();
?>
    <main>
        <?php
        if ( have_posts() ) {
            while ( have_posts() ) {
                the_post();
                load_template( get_stylesheet_directory().'/template-parts/content/content-page-header-footer-only.php', false);
            }
        }
        ?>
    </main>
<?php
get_footer();