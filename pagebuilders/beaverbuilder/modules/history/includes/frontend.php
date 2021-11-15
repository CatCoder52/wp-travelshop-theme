<?php
/**
 * @var object $settings defined by beaver builder module
 */

$args = [];
$args['items'] = [];
if (!empty($settings->teasers) ) {
    foreach ( $settings->teasers as $item ) {
        $args['items'][] = [
            'headline' => $item->headline,
            'text' => $item->text,
            'date' => $item->date,
            'dot_type' => $item->dot_type,
            'dot_color' => '#' . $item->dot_color,
            'dot_svg' => $item->dot_svg,
            'image' => $item->image_src,
            'image_id' => $item->image,
            'image_alt_text' => $item->custom_image_alt_text,
            'image_caption_text' => $item->custom_image_caption_text
        ];
    }
}
load_template_transient(get_template_directory() . '/template-parts/layout-blocks/history.php', false,  $args);