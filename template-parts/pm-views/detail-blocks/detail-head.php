<?php
use Pressmind\Travelshop\Template;

/**
 * @var array $args
 */
?>
<div class="detail-head">
    <div class="detail-badge">NEU</div>
    <div class="image-slider-wrapper">
        <div class="image-slider">
            <?php foreach ($args['pictures'] as $picture) { ?>
                <div>
                    <img src="<?php echo $picture['url_detail']; ?>" alt="<?php echo $picture['caption']; ?>"
                         loading="lazy"/>
                    <div class="image-slider-copyright">
                        <?php echo $picture['copyright']; ?>
                    </div>
                </div>
            <?php } ?>
        </div>
        <!-- OVERLAYGALLERY: START -->
        <div id="detail-gallery-overlay">
            <button class="detail-gallery-overlay-close">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="28" height="28"
                     viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFFFFF" fill="none" stroke-linecap="round"
                     stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z"/>
                    <line x1="18" y1="6" x2="6" y2="18"/>
                    <line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </button>
            <!-- GALLERY_SLIDER: START -->
            <div class="detail-gallery-overlay-slider">
                <div class="detail-gallery-overlay-inner" id="detail-gallery-overlay-inner">
                    <?php
                    foreach ($args['pictures'] as $picture) {
                        ?>
                        <div class="detail-gallery-overlay-item">
                            <div class="detail-gallery-overlay-item--image">
                                <img src="<?php echo $picture['url_detail_gallery']; ?>" class="w-100 h-100"/>
                            </div>
                            <div class="detail-gallery-overlay-item--caption">
                                <?php echo $picture['caption']; ?>
                                <small><?php echo $picture['copyright']; ?></small>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <!-- GALLERY_SLIDER: END -->
            <!-- GALLERY_THUMBNAILS: START -->
            <div class="detail-gallery-thumbnails" id="detail-gallery-thumbnails">
                <?php
                foreach ($args['pictures'] as $picture) {
                    ?>
                    <div class="detail-gallery-thumbnail-item">
                        <div class="detail-gallery-thumbnail-item--image">
                            <img src="<?php echo $picture['url_thumbnail']; ?>" class="w-100 h-100"/>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <!-- GALLERY_THUMBNAILS: END -->
        </div>
        <!-- OVERLAYGALLERY: END -->
    </div>
    <div class="detail-wrapper">
        <div class="detail-details">
            <?php if (!empty($args['destination']) && !empty($args['travel_type'])) { ?>
                <div class="detail-additional">
                    <small>
                        <span class="country"><?php echo $args['destination']; ?></span>
                        ·
                        <span class="type"><?php echo $args['travel_type']; ?></span>
                    </small>
                    <?php if (!empty($args['code'])) { ?>
                        <small class="code">
                            Code: <?php echo $args['code']; ?>
                        </small>
                    <?php } ?>
                </div>
            <?php } ?>
            <?php
            the_breadcrumb(null, null, $args['breadcrumb']);
            ?>
            <div class="detail-heading">
                <h1><?php echo $args['name']; ?></h1>
                <div data-pm-id="<?php echo $args['id_media_object']; ?>"
                     data-pm-ot="<?php echo $args['id_object_type']; ?>"
                     data-pm-dr="<?php echo !is_null($args['cheapest_price']) ? $args['cheapest_price']->date_arrival->format('Ymd') . '-' . $args['cheapest_price']->date_arrival->format('Ymd') : ''; ?>"
                     data-pm-du="<?php echo !is_null($args['cheapest_price']) ? $args['cheapest_price']->duration : ''; ?>"
                     class="add-to-wishlist">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-heart" width="30"
                         height="30" viewBox="0 0 24 24" stroke-width="1.5" stroke="#06f" fill="none"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path class="wishlist-heart"
                              d="M19.5 13.572l-7.5 7.428l-7.5 -7.428m0 0a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572"/>
                    </svg>
                </div>
            </div>
            <p class="subline"><?php echo $args['subline']; ?></p>
            <?php if (empty($args['usps']) === false) { ?>
                <div class="detail-services-mobile">
                    <?php echo $args['usps']; ?>
                </div>
            <?php } ?>
        </div>
        <?php if (count($args['pictures']) > 1) { ?>
            <div style="background-image: url(<?php echo $args['pictures'][1]['url_thumbnail']; ?>);"  class="detail-gallerythumb">
                 <span class="detail-gallerythumb-count">
                     <?php if (count($args['pictures']) >= 2) { ?>
                         + <?php echo count($args['pictures']) - 1; ?>
                     <?php } ?>
                 </span>
            </div>
        <?php } ?>
    </div>
</div>