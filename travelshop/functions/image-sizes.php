<?php

/**
 * @todo: make the s3 plugin stateless ready
 *
 * image sizes are planned for a viewport of 1140px width
 * image ratio 1:6
 * the "thumb"-size is used for a 4 columns
 * the "medium"-size is used for a 3 columns
 * the "large"-size is used for 75% of the viewport (9/12)
 *
 * if you edit this file run: php travelshop/cli/regenerate-images.php --all` on your cli to generate new image derivated
 *
 */

    update_option( 'thumbnail_size_w', 255 );
    update_option( 'thumbnail_size_h', 159 );
    update_option( 'thumbnail_crop', 1 );

    // do not forgot the post_thumb  :-|
    set_post_thumbnail_size( 255, 159, true );

    update_option( 'medium_size_w', 350 );
    update_option( 'medium_size_h', 218 );
    update_option( 'medium_crop', 1 );

    //medium_large
    update_option( 'large_size_w', 825 );
    update_option( 'large_size_h', 515 );
    update_option( 'large_crop', 1);

    // theme specific sizes
    //add_image_size( 'image-name', 220, 180 );