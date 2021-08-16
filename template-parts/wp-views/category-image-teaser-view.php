<?php

/**
 * @var $current_post WP_Post
 */
$teaser = $args;
?>

<div class="teaser-category-image">
    <a href="<?php echo $teaser['link'];?>" target="<?php echo !empty($teaser['link_target']) ? $teaser['link_target'] : '_self';?>">
        <div class="teaser-image" <?php
                // check if featured image is available and set its URL as background-image
                if($teaser['image']) {
                    echo ' style="background-image: url(' . $teaser['image'] . ');" ';
                } else {
                    // fallback image if there is no featured image
                    echo ' style="background-image: url(' . get_stylesheet_directory_uri() . '/assets/img/slide-1-mobile.jpg' . ');" ';
                }
            ?>>
        </div>
        <div class="teaser-body">
            <h1 class="teaser-title h5">
                <?php echo $teaser['headline']; ?>
            </h1>
        </div>
    </a>
</div>