<?php
/**
 * @var object $settings defined by beaver builder module
 */

$args = [];
foreach($settings->slides as $slide){

    if($slide->type == 'content'){
        $args['items'][] = [
            'type' => $slide->type,
            'title' => $slide->headline,
            'text' => $slide->text,
            'image_post_id' => $slide->image,
            'image' => $slide->image_src,
            'image_alt_tag' => $slide->image_alt_text,
            'btn_link' => $slide->btn_link,
            'btn_link_target' => $slide->btn_link_target,
            'btn_label' => $slide->btn_label,
        ];
    }else if($slide->type == 'product'){
        $args['items'][] = [
            'type' => $slide->type,
            'pm-id' => trim($slide->{'pm-id'}),
            'image_type' => $slide->product_image_type,
            'image' => $slide->product_custom_image_src,
            'image_alt_tag' => $slide->product_custom_image_alt_text,
        ];
    }
}
load_template_transient(get_template_directory() . '/template-parts/layout-blocks/content-slider.php', false,  $args);
