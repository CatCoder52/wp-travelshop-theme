<?php
get_header();
?>
    <main>
        <?php echo do_shortcode('[ts-layoutblock f="search-header"]'); ?>
        <div class="content-main">
            <div class="container">
                <?php load_template(get_template_directory().'/template-parts/layout-blocks/image-teaser.php');?>
                <hr class="mt-0 mb-0">
                <?php load_template(get_template_directory().'/template-parts/layout-blocks/product-teaser.php');?>
                <hr class="mt-0 mb-0">
                <?php load_template(get_template_directory().'/template-parts/layout-blocks/info-teaser.php');?>
                <hr class="mt-0 mb-0">
                <?php load_template(get_template_directory().'/template-parts/layout-blocks/icon-teaser.php');?>
            </div>
        </div>
        <?php load_template(get_template_directory().'/template-parts/layout-blocks/jumbotron.php');?>
    </main>
<?php
get_footer();
