<?php

/**
 * @var $current_post WP_Post
 */
$current_post = $args;

$id_post_thumbnail = get_post_thumbnail_id($current_post);

?>
<div class="col-12 col-sm-12 col-lg-4">
    <div class="teaser image-teaser">
        <div class="teaser-image">
            <img class="w-100 h-auto"
                 src="<?php echo wp_get_attachment_image_url($id_post_thumbnail, 'medium'); ?>"
                 alt="<?php echo get_the_post_thumbnail_caption($current_post); ?>" loading="lazy"/>
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