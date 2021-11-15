<?php
/**
 * @var object $settings defined by beaver builder module
 */
$args = [];
$args['query'] = FLBuilderLoop::query( $settings )->query;
$args['headline'] = $settings->headline;
$args['text'] = $settings->text;
load_template_transient(get_template_directory() . '/template-parts/layout-blocks/info-teaser.php', false,  $args);
