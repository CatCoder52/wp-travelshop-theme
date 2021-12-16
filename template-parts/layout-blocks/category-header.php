
<div class="category-header">

    <?php ## Media handling ?>

    <div class="category-header-media category-header-media--<?php echo $args['media_type']; ?>">
        <div class="category-header-media-holder">
            <?php if ( $args['media_type'] == 'image' ) { ?>
                <?php
                $image = wp_get_attachment_image_url( $args['image'], 'bigslide');
                ?>
                <div class="media-image">
                    <div style="background-image: url('<?php echo $image; ?>');"></div>
                </div>
            <?php } else { ?>
                <?php
                $video = wp_get_attachment_url( $args['video'] );
                ?>
                <div class="media-video">
                    <video autoplay muted loop style="pointer-events: none;">
                        <source src="<?php echo $video; ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            <?php } ?>
        </div>
    </div>

    <?php ## Content ?>
    <?php if ( $args['headline'] ) { ?>
        <div class="category-header-content-wrapper content-header-vertical--<?php echo $args['content_alignment_vertical']; ?> content-header-horizontal--<?php echo $args['content_alignment_horizontal']; ?>">
            <div class="container">
                <article class="category-header-content category-header-content--<?php echo $args['content_box_type']; ?>">
                    <h1 class="category-header-title" <?php if ( !empty($args['headline_color']) ) { ?>style="color: <?php echo $args['headline_color']; ?>"<?php } ?>>
                        <?php echo $args['headline']; ?>
                    </h1>

                    <?php if ( !empty($args['subline']) ) { ?>
                        <div class="category-header-subline">
                            <?php echo $args['subline']; ?>
                        </div>
                    <?php } ?>

                    <?php if ( !empty($args['text']) ) { ?>
                        <div class="category-header-subline">
                            <?php echo $args['text']; ?>
                        </div>
                    <?php } ?>

                    <?php if ( !empty($args['btn_link']) ) { ?>
                        <div class="category-header-button">
                            <a class="btn btn-primary" href="<?php echo $args['btn_link']; ?>" title="<?php if ( !empty($args['btn_label']) ) { echo $args['btn_label']; } else { echo $args['headline']; } ?>" target="<?php echo $args['btn_link_target']; ?>">
                                <?php
                                if ( !empty($args['btn_label']) ) { echo $args['btn_label']; } else { echo "Mehr lesen"; };
                                ?>
                            </a>
                        </div>
                    <?php } ?>
                </article>
            </div>
        </div>

    <?php } ?>

    <?php ## Overlay handling ?>
    <?php if ( $args['background_overlay_type'] !== 'none' ) { ?>
        <div class="category-header-overlay category-header-overlay--<?php echo $args['background_overlay_type']; ?>">
        </div>
    <?php } ?>
</div>