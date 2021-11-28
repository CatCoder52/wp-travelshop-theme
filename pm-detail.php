<?php
/**
 * @var WP_Query $wp_query
 */

get_header();

/**
 * get the currently requested media objects (previosly set in config-routing.php:ts_detail_hook() )
 * @var \Pressmind\ORM\Object\MediaObject[] $mediaObjects
 */
$mediaObjects = $wp_query->get('media_objects');

// this code is for better onboarding and understanding, remove  in production or replace with a multi media object layout
if(count($mediaObjects) > 1 && !empty($_GET['preview'])){ ?>
    <div class="alert alert-warning" role="alert">
        <b>! Warning</b> the requested url <b><?php echo $mediaObjects[0]->getPrettyUrl(TS_LANGUAGE_CODE); ?></b> has registered more than one media objects:<br>
        this detail page is showing the <b>first object</b> listed below.<br>
        <ul>
            <?php
                foreach ($mediaObjects as $mediaObject) { ?>
                <li><?php echo $mediaObject->getId();?></li>
                <?php
            } ?>
        </ul>
        <b>to solve this problem:</b><br>
        - your url strategy is wrong, see <i>pm-config.php</i>, url strategy must be "count-up" or "unique" <br>
        - edit your theme <i>pm-detail.php</i> and make multiple media objects as product variants running.<br>
    </div>
<?php } ?>
    <main>
        <?php
        // @see template-parts/pm-views/
        echo $mediaObjects[0]->render('Detail2');
        ?>
    </main>
<?php
get_footer();
