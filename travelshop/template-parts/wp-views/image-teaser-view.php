<?php

/**
 * @var $current_post WP_Post
 */
$current_post = $args;

$id_post_thumbnail = get_post_thumbnail_id($current_post);
$url_post_thumbnail = wp_get_attachment_image_url($id_post_thumbnail, 'medium');
?>
<div class="col-12 col-sm-12 col-lg-4">
    <div class="teaser image-teaser">
        <div class="teaser-image"
            <?php 
                // check if featured image is available and set its URL as background-image
                if($url_post_thumbnail) {
                    echo ' style="background-image: url(' . $url_post_thumbnail . ');" ';
                } else {
                    // fallback image if there is no featured image
                    echo ' style="background-image: url(' . get_stylesheet_directory_uri() . '/assets/img/slide-1.jpg' . ');" ';
                }
            ?>
        >
        </div>
        <div class="teaser-body">
            <div class="teaser-title h5">
                <?php echo $current_post->post_title; ?>
            </div>
            <p>
                <?php echo $current_post->post_excerpt; ?>
            </p>
            <a href="<?php echo get_permalink($current_post); ?>"
               class="btn btn-primary btn-block">Mehr erfahren</a>
        </div>
    </div>
</div>