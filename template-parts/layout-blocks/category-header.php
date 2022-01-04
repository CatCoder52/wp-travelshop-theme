
<div class="category-header category-header--<?php echo $args['uid']; ?> category-header--<?php echo $args['content_box_type']; ?> <?php if (  $args['content_box_type'] == 'boxed' ) { ?>category-header--<?php echo $args['content_box_break'];  }?> <?php if ( $args['content_box_type'] == 'docked' ) { ?> category-header-docked--<?php echo $args['content_alignment_horizontal']; ?> <?php } ?>">

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

        <?php ## Overlay handling ?>
        <?php if ( $args['background_overlay_type'] !== 'none' ) { ?>
            <?php
            ## Style tag
            $overlay_style = '';

            if ( $args['background_overlay_type'] == 'color' ) {
                if ( !empty($args['background_overlay_color']) ) {
                    if ( strlen($args['background_overlay_color']) < 8 ) {
                        $overlay_style = 'style="background-color: #'.$args['background_overlay_color'].';"';
                    } else {
                        $overlay_style = 'style="background-color: '.$args['background_overlay_color'].';"';
                    }
                } else {
                    $overlay_style = 'style="background-color: rgba(0,0,0,.25);"';
                }
            } else {
                $overlay_style = 'style="background-image: '. $args['background_overlay_gradient'] .'"';
            }
            ?>

            <div class="category-header-overlay category-header-overlay--<?php echo $args['background_overlay_type']; ?>" <?php echo $overlay_style; ?>>
            </div>
        <?php } ?>
    </div>

    <?php ## Content ?>
    <?php if ( $args['headline'] ) { ?>
        <div class="category-header-content-wrapper" <?php if ( $args['content_box_type'] !== 'docked' ) { ?>style="padding: <?php echo $args['content_inner_padding']; ?>px;"<?php } ?>>
            <div class="container-fluid">
                <div class="category-header-content-positioning content-header-vertical--<?php echo $args['content_alignment_vertical']; ?>
                content-header-vertical-medium--<?php echo $args['content_alignment_vertical_medium']; ?>
                content-header-vertical-small--<?php echo $args['content_alignment_vertical_responsive']; ?>
                content-header-horizontal--<?php echo $args['content_alignment_horizontal']; ?>
                content-header-horizontal-medium--<?php echo $args['content_alignment_horizontal_medium']; ?>
                content-header-horizontal-small--<?php echo $args['content_alignment_horizontal_responsive']; ?>">
                    <article class="category-header-content <?php echo $args['content_box_text_align']; ?> category-header-content--<?php echo $args['content_box_type']; ?> <?php if ( ($args['content_box_type'] == 'boxed' || $args['content_box_type']== 'docked') && ( !empty($args['content_box_background']) ) ) { ?> category-header-content--<?php echo $args['content_box_background']; ?><?php } ?>
                    ">
                        <<?php echo $args['headline_type']; ?>> class="category-header-title" <?php if ( !empty($args['headline_color']) ) { ?>style="color: <?php if ( strlen($args['headline_color']) < 8 ) { ?>#<?php } ?><?php echo $args['headline_color']; ?>"<?php } ?>>
                            <?php echo $args['headline']; ?>
                        </<?php echo $args['headline_type']; ?>>

                        <?php if ( !empty($args['subline']) ) { ?>
                            <div class="category-header-subline <?php echo $args['subline_type']; ?>" <?php if ( !empty($args['subline_color']) ) { ?>style="color: <?php if ( strlen($args['subline_color']) < 8 ) { ?>#<?php } ?><?php echo $args['subline_color']; ?>"<?php } ?>>
                                <?php echo $args['subline']; ?>
                            </div>
                        <?php } ?>

                        <?php if ( !empty($args['text']) ) { ?>
                            <div class="category-header-text" <?php if ( !empty($args['text_color']) ) { ?>style="color: <?php if ( strlen($args['text_color']) < 8 ) { ?>#<?php } ?><?php echo $args['text_color']; ?>"<?php } ?>>
                                <?php echo $args['text']; ?>
                            </div>
                        <?php } ?>
                    </article>
                </div>
            </div>
        </div>

    <?php } ?>

    <?php
    // generate style for image height
    ?>
    <style>
        <?php if ( !empty($args['background_height_responsive']) ) { ?>
        .category-header.category-header--<?php echo $args['uid']; ?> .category-header-media-holder > div {
            padding-bottom: <?php echo $args['background_height_responsive']; ?>px;
            min-height: <?php echo $args['background_height_responsive']; ?>px;
        }
        <?php } ?>

        <?php if ( !empty($args['background_height_medium']) ) { ?>
        @media( min-width: 768px ) {
            .category-header.category-header--<?php echo $args['uid']; ?> .category-header-media-holder > div {
                padding-bottom: <?php echo $args['background_height_medium']; ?>px;
                min-height: <?php echo $args['background_height_medium']; ?>px;
            }
        }
        <?php } ?>

        <?php if ( !empty($args['background_height']) ) { ?>
        @media( min-width: 1200px ) {
            .category-header.category-header--<?php echo $args['uid']; ?> .category-header-media-holder > div {
                padding-bottom: <?php echo $args['background_height']; ?>px;
                min-height: <?php echo $args['background_height']; ?>px;
            }
        }
        <?php } ?>

        <?php if ( !empty($args['content_box_max_height']) && $args['content_box_max_height'] !== '0' && $args['content_box_type'] == 'boxed' && $args['content_box_break'] == 'break' )  { ?>
        @media( min-width: 768px ) {
            .category-header.category-header--<?php echo $args['uid']; ?> .category-header-content-wrapper .container-fluid .category-header-content-positioning .category-header-content {
                max-width: <?php echo $args['content_box_max_height']; ?>px;
                width: 100%;
            }
        }
        <?php } ?>

        <?php if ( !empty($args['content_box_max_height']) && $args['content_box_max_height'] !== '0' && $args['content_box_type'] == 'boxed' && $args['content_box_break'] == 'no-break' )  { ?>
        .category-header.category-header--<?php echo $args['uid']; ?> .category-header-content-wrapper .container-fluid .category-header-content-positioning .category-header-content {
            max-width: <?php echo $args['content_box_max_height']; ?>px;
            width: 100%;
        }
        <?php } ?>

        <?php if ( !empty($args['content_box_max_height']) && $args['content_box_max_height'] !== '0' && $args['content_box_type'] == 'docked' ) { ?>
        @media( min-width: 768px ) {
            .category-header.category-header--<?php echo $args['uid']; ?> .category-header-content-wrapper  {
                max-width: <?php echo $args['content_box_max_height']; ?>px;
                flex: 0 0 <?php echo $args['content_box_max_height']; ?>px;
            }
        }
        <?php } ?>
    </style>
</div>
