<?php

class TSWPJumbotron extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Jumbotron', 'fl-builder' ),
			'description'     => __( 'Just a simple Jumbotron', 'fl-builder' ),
			'category'        => __( 'Content Modules', 'fl-builder' ),
			'group'        => __( 'Travelshop', 'fl-builder' ),
			'editor_export'   => false,
			'partial_refresh' => true,
			'icon'            => 'slides.svg',
            'dir'           => BB_MODULE_TS_DIR . 'modules/jumbotron/',
            'url'           => BB_MODULE_TS_URL . 'modules/jumbotron/',
		));
	}

}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('TSWPJumbotron', array(

    'common' => array(
        'title'    => __( 'Common', 'fl-builder' ),
        'sections' => array(
            'common'    => array(
                'title'  => __( 'Common', 'fl-builder' ),
                'fields' => array(
                    'headline'     => array(
                        'type'    => 'text',
                        'label'   => __( 'Headline', 'fl-builder' ),
                        'default' => 'Headline',
                    ),

                    'subline'     => array(
                        'type'    => 'text',
                        'label'   => __( 'Subline', 'fl-builder' ),
                        'default' => 'Subline',
                    ),

                    'lead'     => array(
                        'type'    => 'text',
                        'label'   => __( 'Lead', 'fl-builder' ),
                        'default' => 'Lead text for a nice travel product.',
                    ),

                    'text'     => array(
                        'type'    => 'editor',
                        'media_buttons' => false,
                        'wpautop'       => false,
                        'label'   => __( 'Text', 'fl-builder' ),
                        'default' => 'Some more informations'
                    ),

                    'btn_link'     => array(
                        'type'          => 'link',
                        'label'         => __('Button link', 'fl-builder'),
                        'show_target'   => true,
                        'show_nofollow' => true,
                    ),

                    'btn_label'     => array(
                        'type'    => 'text',
                        'label'   => __( 'Button label', 'fl-builder' ),
                        'default' => 'Jetzt entdecken',
                    ),

                    'bg_image'    => array(
                        'type'          => 'photo',
                        'label'         => __('Image', 'fl-builder')
                    ),

                    'bg_image_alt_text'     => array(
                        'type'    => 'text',
                        'label'   => __( 'Image alternative text', 'fl-builder' ),
                        'default' => '',
                    ),
                ),
            ),

        ),
    ),


));
