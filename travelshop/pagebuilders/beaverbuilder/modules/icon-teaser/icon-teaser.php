<?php

class TSWPIconTeaser extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Icon/USP Teaser', 'fl-builder' ),
			'description'     => __( 'Just a simple icon teaser', 'fl-builder' ),
			'category'        => __( 'Content Modules', 'fl-builder' ),
			'group'        => __( 'Travelshop', 'fl-builder' ),
			'editor_export'   => false,
			'partial_refresh' => true,
			'icon'            => 'star-filled.svg',
            'dir'           => BB_MODULE_TS_DIR . 'modules/icon-teaser/',
            'url'           => BB_MODULE_TS_URL . 'modules/icon-teaser/',
		));
	}

}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('TSWPIconTeaser', array(

    'general' => array(
        'title'    => __( 'General', 'fl-builder' ),
        'sections' => array(
            'general'    => array(
                'title'  => __( 'General', 'fl-builder' ),
                'fields' => array(
                    'headline'     => array(
                        'type'    => 'text',
                        'label'   => __( 'Headline', 'fl-builder' ),
                        'default' => 'Headline',
                    ),

                    'text'     => array(
                        'type'    => 'editor',
                        'media_buttons' => false,
                        'wpautop'       => false,
                        'label'   => __( 'Text', 'fl-builder' ),
                        'default' => 'Some more informations'
                    ),
                ),
            ),

        ),
    ),
    'teasers' => array(
        'title'    => __( 'Teaser', 'fl-builder' ),
        'sections' => array(
            'common'    => array(
                'title'  => __( 'Teaser', 'fl-builder' ),
                'fields' => array(
                    'teasers'     => array(
                        'type'          => 'form',
                        'label'         => __('Teaser', 'fl-builder'),
                        'form'          => 'icon-teaser-form', // ID from registered form below
                        'preview_text'  => 'headline', // Name of a field to use for the preview text
                        'multiple'      => true,
                        'limit'      => 4,
                    ),

                ),
            ),

        ),
    ),


));

FLBuilder::register_settings_form('icon-teaser-form', array(
    'title' => __('Teaser', 'fl-builder'),
    'tabs'  => array(
        'general'      => array( // Tab
            'title'         => __('General', 'fl-builder'), // Tab title
            'sections'      => array( // Tab Sections
                'general'       => array( // Section
                    'title'         => '', // Section Title
                    'fields'        => array( // Section Fields
                        'headline'       => array(
                            'type'          => 'text',
                            'label'         => __('Headline', 'fl-builder'),
                            'default'       => 'We make it! '
                        ),

                        'text'       => array(
                            'type'          => 'text',
                            'label'         => __('Text', 'fl-builder'),
                            'default'       => 'Some example text'
                        ),

                        'priority'     => array(
                            'type'          => 'select',
                            'label'         => __('Priority', 'fl-builder'),
                            'help' => 'The background color of the icon',
                            'default' => 'icon-inner-primary',
                            'options'       => array(
                                ''    => __( 'None', 'fl-builder' ),
                                'icon-inner-secondary'    => __( 'Secondary', 'fl-builder' ),
                                'icon-inner-primary'    => __( 'Primary', 'fl-builder' ),

                            ),

                        ),

                        'btn_link'     => array(
                            'type'          => 'link',
                            'label'         => __('Button link', 'fl-builder'),
                            'show_target'   => true,
                            'show_nofollow' => false,
                        ),

                        'btn_label'     => array(
                            'type'    => 'text',
                            'label'   => __( 'Button label', 'fl-builder' ),
                            'default' => 'Jetzt entdecken',
                        ),

                        'svg_icon'       => array(
                            'type'          => 'code',
                            'help'  => 'Place svg code here. Use https://tablericons.com/ for getting icons (size: 52, stroke-width: 1.5 is recommend)',
                            'editor'        => 'html',
                            'rows'          => '18',
                            'label'         => __('SVG icon', 'fl-builder'),
                            'default'       => '<!-- Use https://tablericons.com/ for getting icons (stroke-width: 1.5 is recommend) -->
<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-bell" width="52" height="52" viewBox="0 0 24 24" stroke-width="1.5" stroke="#FFFFFF" fill="none" stroke-linecap="round" stroke-linejoin="round">
    <path stroke="none" d="M0 0h24v24H0z"/>
    <path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
    <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
</svg>'
                        ),
                    )
                )
            )
        ),

    )
));
