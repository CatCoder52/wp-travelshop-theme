<?php

class TSPMProductCategoryTeaser extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Category Teaser', 'fl-builder' ),
			'description'     => __( 'Product category teaser based on pressmind media objects', 'fl-builder' ),
			'category'        => __( 'pressmind Teaser', 'fl-builder' ),
			'group'        => __( 'Travelshop', 'fl-builder' ),
			'editor_export'   => false,
			'partial_refresh' => true,
			'icon'            => 'schedule.svg',
            'dir'           => BB_MODULE_TS_DIR . 'modules/pm-product-category-teaser/',
            'url'           => BB_MODULE_TS_URL . 'modules/pm-product-category-teaser/',
		));
	}

}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('TSPMProductCategoryTeaser', array(

    'common' => array(
        'title'    => __( 'Common', 'fl-builder' ),
        'sections' => array(
            'common'    => array(
                'title'  => __( 'Common', 'fl-builder' ),
                'fields' => array(
                    'headline'     => array(
                        'type'    => 'text',
                        'label'   => __( 'Headline', 'fl-builder' ),
                        'default' => 'Reise-Themen',
                    ),

                    'text' => array(
                        'type'    => 'editor',
                        'media_buttons' => false,
                        'wpautop'       => false,
                        'label'   => __( 'Text', 'fl-builder' ),
                        'default' => 'Travel is the movement of people between relatively distant geographical locations, and can involve travel by foot, bicycle, automobile, train, boat, bus, airplane, or other means, with or without luggage, and can be one way or round trip. ',
                    ),

                ),
            ),

        ),
    ),
    'teaser' => array(
        'title'    => __( 'Teaser', 'fl-builder' ),
        'sections' => array(
            'common'    => array(
                'title'  => __( 'Common', 'fl-builder' ),
                'fields' => array(

                    'teaser_count_desktop' => array(
                        'type'    => 'select',
                        'label'   => 'Teaser Items',
                        'default' => '3',
                        'options'       => array(
                            '1'    => '1 on Desktop',
                            '2'    => '2 on Desktop',
                            '3'    => '3 on Desktop',
                            '4'    => '4 on Desktop',
                        ),
                    ),

                ),
            ),
            'Teaser'    => array(
                'title'  => __( 'Teaser', 'fl-builder' ),
                'fields' => array(

                    'teasers'     => array(
                        'type'          => 'form',
                        'label'         => __('Teaser', 'fl-builder'),
                        'form'          => 'product-category-teaser-form', // ID from registered form below
                        'preview_text'  => 'headline', // Name of a field to use for the preview text
                        'multiple'      => true,
                        'limit'      => 4,
                    ),

                ),
            ),

        ),
    ),

));


FLBuilder::register_settings_form('product-category-teaser-form', array(
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
                            'default'       => 'Category Name '
                        ),

                        'text'       => array(
                            'type'          => 'text',
                            'label'         => __('Text', 'fl-builder'),
                            'default'       => 'Some example text'
                        ),


                        'link'     => array(
                            'type'          => 'link',
                            'label'         => __('Button link', 'fl-builder'),
                            'show_target'   => true,
                            'show_nofollow' => false,
                        ),

                        'image'    => array(
                            'type'          => 'photo',
                            'label'         => __('Image', 'fl-builder')
                        ),

                        'image_alt_text'     => array(
                            'type'    => 'text',
                            'label'   => __( 'Image alternative text', 'fl-builder' ),
                            'default' => '',
                        ),

                    )
                )
            )
        ),



        'search'    => array(
            'title' => __( 'Products', 'fl-builder' ),
            'file'  => get_stylesheet_directory() . '/pagebuilders/beaverbuilder/includes/ui_media_object_settings.php',
        ),




        /*
        'test4711'    => array(
            'title' => __( 'Test', 'fl-builder' ),
            'file'  => ABSPATH.'/wp-content/plugins/bb-plugin/includes/ui-loop-settings.php',
        ),
*/


    )
));
