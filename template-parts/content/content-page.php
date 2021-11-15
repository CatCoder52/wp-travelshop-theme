<?php the_breadcrumb(null);?>
<div class="content-main" id="content-main">
    <?php if ( !is_front_page() ) { ?>
        <section class="content-block content-page">
            <div class="container">
                <?php the_content(); ?>
            </div>
        </section>
    <?php } else { ?>
        <?php the_content(); ?>
    <?php } ?>
</div>