<?php
/**
 * @var object $settings defined by beaver builder module
 */

$args = [];
$args['headline'] = $settings->headline;
$args['text'] = $settings->text;
$args['items'] = [];
if (!empty($settings->teasers)){
    foreach ( $settings->teasers as $item ){
        $args['items'][] = [
            'image' => $item->image_src,
            'image_id' => $item->image,
            'name' => $item->name,
            'position' => $item->position,
            'text' => $item->text,
            'mail' => $item->mail,
            'phone' => $item->phone,
            'btn_text' => $item->btn_text,
            'btn_link' => $item->btn_link,
        ];
    }
}
load_template_transient(get_template_directory() . '/template-parts/layout-blocks/team.php', false,  $args);