<?php

class TSPMProductTeaser extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Product Teaser', 'fl-builder' ),
			'description'     => __( 'Product teaser based on pressmind media objects', 'fl-builder' ),
			'category'        => __( 'pressmind Teaser', 'fl-builder' ),
			'group'        => __( 'Travelshop', 'fl-builder' ),
			'editor_export'   => false,
			'partial_refresh' => true,
			'icon'            => 'schedule.svg',
            'dir'           => BB_MODULE_TS_DIR . 'modules/pm-product-teaser/',
            'url'           => BB_MODULE_TS_URL . 'modules/pm-product-teaser/',
		));
	}

}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('TSPMProductTeaser', array(

    'common' => array(
        'title'    => __( 'Common', 'fl-builder' ),
        'sections' => array(
            'common'    => array(
                'title'  => __( 'Common', 'fl-builder' ),
                'fields' => array(
                    'headline'     => array(
                        'type'    => 'text',
                        'label'   => __( 'Headline', 'fl-builder' ),
                        'default' => 'Reise-Empfehlungen',
                        'help' => 'Tip: use the shortcode [TOTAL_RESULT] in this field to display the amount of found products'

                    ),

                    'text' => array(
                        'type'    => 'editor',
                        'media_buttons' => false,
                        'wpautop'       => false,
                        'label'   => __( 'Text', 'fl-builder' ),
                        'help' => 'Tip: use the shortcode [TOTAL_RESULT] in this field to display the amount of found products',
                        'default' => 'Travel is the movement of people between relatively distant geographical locations, and can involve travel by foot, bicycle, automobile, train, boat, bus, airplane, or other means, with or without luggage, and can be one way or round trip. ',
                    ),
                    'link_top'  => array(
                        'type' => 'select',
                        'label' => __('Button above products', 'fl-builder'),
                        'default'       => 'false',
                        'options'       => array(
                            'false'      => __( 'Yes', 'fl-builder' ),
                            'true'      => __( 'No', 'fl-builder' )
                        ),
                    ),
                    'link_teaser'  => array(
                        'type' => 'select',
                        'label' => __('Button as teaser', 'fl-builder'),
                        'default'       => 'false',
                        'options'       => array(
                            'false'      => __( 'Yes', 'fl-builder' ),
                            'true'      => __( 'No', 'fl-builder' )
                        ),
                    ),
                    'link_bottom'  => array(
                        'type' => 'select',
                        'label' => __('Button underneath products', 'fl-builder'),
                        'default'       => 'false',
                        'options'       => array(
                            'false'      => __( 'Yes', 'fl-builder' ),
                            'true'      => __( 'No', 'fl-builder' )
                        ),
                    ),
                    'link_top_text' => array(
                        'type' => 'text',
                        'label' => __('Button-Text above products', 'fl-builder'),
                        'default' => 'Alle [TOTAL_RESULT] Reisen anzeigen'
                    ),
                    'link_teaser_text' => array(
                        'type' => 'text',
                        'label' => __('Button-Text as teaser', 'fl-builder'),
                        'default' => '[TOTAL_RESULT] weitere Reisen anzeigen'
                    ),
                    'link_bottom_text' => array(
                        'type' => 'text',
                        'label' => __('Button-Text underneath products', 'fl-builder'),
                        'default' => 'Alle [TOTAL_RESULT] Spanien Reisen anzeigen'
                    ),

                ),
            ),


        ),
    ),
	'content2'    => array(
		'title' => __( 'Content', 'fl-builder' ),
		'file'  => get_stylesheet_directory() . '/pagebuilders/beaverbuilder/includes/ui_media_object_settings.php',
	),



));
