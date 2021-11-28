<?php
/**
 * @var array $args
 */
?>
<div class="travelshop-detail-head">
    <div class="travelshop-detail-badge">NEU</div>
    <div class="travelshop-image-slider-wrapper">
        <div class="travelshop-image-slider">
            <?php foreach ($args['pictures'] as $picture) { ?>
                <div>
                    <img src="<?php echo $picture['url_detail']; ?>" alt="<?php echo $picture['alt']; ?>"
                         loading="lazy"/>
                    <div class="travelshop-image-slider-copyright">
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
                                <img src="<?php echo $picture['url_detail']; ?>" class="w-100 h-100"/>
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
                            <img src="<?php echo $picture['url_detail']; ?>" class="w-100 h-100"/>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <!-- GALLERY_THUMBNAILS: END -->
        </div>
        <!-- OVERLAYGALLERY: END -->
    </div>
    <div class="travelshop-detail-wrapper">
        <div class="travelshop-detail-details">
            <?php if (!empty($args['destination']) && !empty($args['travel_type'])) { ?>
                <div class="travelshop-detail-additional">
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
            // HARD BREADCRUMB BECAUSE OF BUG
            //echo '<section class="breadcrumb-wrapper"><div class="container"><nav aria-label="breadcrumb"><ol itemscope="" itemtype="https://schema.org/BreadcrumbList" class="breadcrumb"><li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem" class="breadcrumb-item breadcrumb-home"><a itemprop="item" href="https://travelshop.michaelamting.de"> <span class="breadcrumb-name" itemprop="name">Travelshop <span class="breadcrumb-sep"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="#777" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><polyline points="9 6 15 12 9 18"></polyline></svg></span></span></a> <meta itemprop="position" content="2"></li><li class="bc-separator" style="display: none;"> <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-left" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="#777" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><polyline points="15 6 9 12 15 18"></polyline></svg><a itemprop="item" href="https://travelshop.michaelamting.de/reise-suche/?pm-c[reiseart_default]=kF332DCB8-FEF6-71C4-F9B9-0435E23EEAE5">Radreisen anzeigen</a></li> <li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem" class="breadcrumb-item "><a itemprop="item" href="https://travelshop.michaelamting.de/reise-suche/?pm-c[reiseart_default]=kF332DCB8-FEF6-71C4-F9B9-0435E23EEAE5"> <span class="breadcrumb-name" itemprop="name">Radreisen <span class="breadcrumb-sep"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="#777" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><polyline points="9 6 15 12 9 18"></polyline></svg></span></span></a> <meta itemprop="position" content="3"></li><li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem" class="breadcrumb-item "><a itemprop="item" href="https://travelshop.michaelamting.de/reise-suche/?pm-c[zielgebiet_default]=F846ED62-9CC5-E3C4-E3E1-14B8DD7EC50E"> <span class="breadcrumb-name" itemprop="name">Schweiz <span class="breadcrumb-sep"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="#777" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><polyline points="9 6 15 12 9 18"></polyline></svg></span></span></a> <meta itemprop="position" content="4"></li><li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem" class="breadcrumb-item "><a itemprop="item" href="https://travelshop.michaelamting.de/reise-suche/?pm-c[zielgebiet_default]=kD83342A3-9861-8672-9330-4251E13556F1"> <span class="breadcrumb-name" itemprop="name">St. Moritz <span class="breadcrumb-sep"><svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-chevron-right" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="#777" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><polyline points="9 6 15 12 9 18"></polyline></svg></span></span></a> <meta itemprop="position" content="5"></li><li itemprop="itemListElement" itemscope="" itemtype="https://schema.org/ListItem" class="breadcrumb-item "><span class="breadcrumb-name" itemprop="name">Große Schweiz-Rundreise <span class="breadcrumb-sep"></span></span><meta itemprop="position" content="6"></li></ol></nav></div></section>';
            the_breadcrumb(null, null, $args['breadcrumb']);
            ?>
            <div class="travelshop-detail-heading">
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
                <div class="travelshop-detail-services-mobile">
                    <?php echo $args['usps']; ?>
                </div>
            <?php } ?>
        </div>
        <?php if (count($args['pictures']) > 1) { ?>
            <div style="background-image: url(<?php echo $args['pictures'][1]['url_detail_thumb']; ?>);"  class="travelshop-detail-gallerythumb">
                 <span class="travelshop-detail-gallerythumb-count">
                     <?php if (count($args['pictures']) >= 3) { ?>
                         + <?php echo count($args['pictures']) - 2; ?>
                     <?php } ?>
                 </span>
            </div>
        <?php } ?>
    </div>
</div>