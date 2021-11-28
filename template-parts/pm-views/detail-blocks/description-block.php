<?php
/**
 * @var array $args
 */
?>
<section class="travelshop-lodgings-wrapper">
    <?php
    foreach ($args['descriptions'] as $description) {
        ?>
        <h2><?php echo $description['headline']; ?></h2>
        <hr/>
        <?php foreach ($description['items'] as $k => $item) { ?>
            <div class="travelshop-lodgings-element <?php echo $k == 0 ? 'lodging-open' : ''; ?>">
                <h3>
                    <div class="travelshop-lodgings-element-title">
                        <span><?php echo $item['name']; ?></span>
                        <?php
                        if (!empty($item['icons'])) {
                            ?>
                            <div class="lodging-star-rating">
                                <?php echo $item['icons']; // svg or img ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="icon icon-tabler icon-tabler-plus travelshop-itinerary-step-open" width="30" height="30"
                         viewBox="0 0 24 24" stroke-width="2.5" stroke="#06f" fill="none" stroke-linecap="round"
                         stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <line x1="12" y1="5" x2="12" y2="19"/>
                        <line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                </h3>
                <div class="travelshop-lodgings-element-more">
                    <?php echo $item['text']; ?>
                    <div class="travelshop-lodgings-element-gallery lod-gallery-<?php echo $k; ?>">
                        <?php foreach ($item['pictures'] as $picture) { ?>
                            <a href="<?php echo $picture->getUri('detail'); ?>"
                               data-lightbox="lodging-gallery-<?php echo $k; ?>">
                                <img src="<?php echo $picture->getUri('teaser'); ?>"
                                     alt="<?php echo $picture->alt; ?>"/>
                                <div class="travelshop-lodgings-element-gallery-copyright">
                                    <?php echo $picture->copyright; ?>
                                </div>
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <hr/>
        <?php } ?>
        <?php
    }
    ?>
</section>