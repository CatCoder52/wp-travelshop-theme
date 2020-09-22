<?php
/**
 * @var WP_Query $wp_query
 */

get_header();

$mediaObject = null;
$key = 'pm-ts-oc-'.$wp_query->get('id_media_object');
if(empty($_GET['no_cache'])){
    $mediaObject = wp_cache_get($key, 'media-object');
}
if(empty($mediaObject) === true){
    $mediaObject = new Pressmind\ORM\Object\MediaObject($wp_query->get('id_media_object'));
    if(empty($_GET['no_cache'])) {
        wp_cache_set($key, $mediaObject, 'media-object', 60);
    }
}

?>
    <main>
        <?php
        // @see template-parts/pm-views/
        echo $mediaObject->render('Detail1');
        ?>

        <div class="small" style="margin: 0;">Template: wp-content/themes/travelshop/pm-detail.php</div>
    </main>
<?php
get_footer();
