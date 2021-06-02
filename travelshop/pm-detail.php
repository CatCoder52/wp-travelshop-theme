<?php
/**
 * @var WP_Query $wp_query
 */

get_header();

$mediaObjects = [];
$id_media_objects = $wp_query->get('id_media_objects');

foreach ($id_media_objects as $id_media_object) {
    $key = 'pm-ts-oc-' . $id_media_object;
    if (empty($_GET['no_cache'])) {
        $buffer = wp_cache_get($key, 'media-object');
    }

    if (empty($buffer) === true) {
        $buffer = new Pressmind\ORM\Object\MediaObject($id_media_object);
        if (empty($_GET['no_cache'])) {
            wp_cache_set($key, $buffer, 'media-object', 60);
        }
    }
    $mediaObjects[] = $buffer;
}

?>
<?php
// this code is for better onboarding and understanding, remove  in production or replace with a multi media object layout
if(count($id_media_objects) > 1 && !empty($_GET['preview'])){ ?>
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
        echo $mediaObjects[0]->render('Detail1');
        ?>

        <div class="small" style="margin: 0;">Template: wp-content/themes/travelshop/pm-detail.php</div>
    </main>
<?php
get_footer();
