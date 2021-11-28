<?php

/**
 * @var array $args
 */

if(empty($args["map_url_detail"])){
    return;
}

$id_modal = uniqid();
?>
<div class="travelshop-gmaps-box">
    <a class="show-map" data-modal="true" data-modal-id="<?php echo $id_modal; ?>">
      <img class="travelshop-gmaps-box-image" src="<?php echo $args["map_url_detail"];?>">
    </a>
    <?php load_template(get_template_directory().'/template-parts/pm-views/detail-blocks/contact-box.php', false, $args);?>
</div>
<?php 
    // Google Maps Modal
    $args_maps = [];
    $args_maps['id_modal'] = $id_modal;
    $args_maps['title'] = 'Reise-Etappen';
    $args_maps['content'] = '<img class="travelshop-gmaps-box-image" src="'.$args["map_url_detail"].'">';
    load_template(get_template_directory() . '/template-parts/layout-blocks/modalscreen.php', false, $args_maps);
