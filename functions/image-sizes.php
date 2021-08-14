<?php

return;

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