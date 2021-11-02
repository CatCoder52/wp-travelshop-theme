<?php
/**
 * This hook will abort all image uploads that have a filesize bigger than the defined value.
 * it's protects the website performance against st*p*d users.
 */
add_filter('wp_handle_upload_prefilter', function ($file) {
    if(WP_IMAGE_MAX_UPLOAD_SIZE == null){
        return $file;
    }
    $is_image = strpos($file['type'], 'image') !== false;
    if ($is_image && ($file['size'] / 1024) > WP_IMAGE_MAX_UPLOAD_SIZE) {
        $file['error'] = 'Das Bild ist zu groß ('.(round($file['size'] / 1024,0)).'kb). 
        Es ist maximal eine Größe von ' . WP_IMAGE_MAX_UPLOAD_SIZE.'kb erlaubt. Wir schützen mit dieser 
        Sperre die Performance, die User-Experience und das Ranking der Website.';
    }
    return $file;
});

/**
 * This hook will reduce the original images after upload to the defined size
 * it's protects the website performance against st*p*d users.
 */
add_filter( 'wp_handle_upload', function($data){

    if(!isset($data['file']) || !isset($data['type']) || WP_IMAGE_ORIGINAL_RESIZE_TO === null){
        return $data;
    }

    if( in_array( $data['type'], [ 'image/jpg', 'image/jpeg' ] ) )
    {
        $image_editor = wp_get_image_editor( $data['file'] );
        $size = $image_editor->get_size();
        if( ! is_wp_error( $image_editor ) ) {
            if ((isset($size['width']) && $size['width'] > WP_IMAGE_ORIGINAL_RESIZE_TO) ||
                (isset($size['height']) && $size['height'] > WP_IMAGE_ORIGINAL_RESIZE_TO)) {
                $image_editor->resize(WP_IMAGE_ORIGINAL_RESIZE_TO, WP_IMAGE_ORIGINAL_RESIZE_TO, false);
                // $image_editor->set_quality(100);
                $image_editor->save($data['file']);
            }
        }
    }
    return $data;
});