<?php

class TSWPPMSliderMixed extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Slider (mixed Content)', 'fl-builder' ),
			'description'     => __( 'This slider can contain pure content slides or pressmind based product slides', 'fl-builder' ),
			'category'        => __( 'Content Modules', 'fl-builder' ),
			'group'        => __( 'Travelshop', 'fl-builder' ),
			'editor_export'   => false,
			'partial_refresh' => true,
			'icon'            => 'star-filled.svg',
            'dir'           => BB_MODULE_TS_DIR . 'modules/slider-mixed-content/',
            'url'           => BB_MODULE_TS_URL . 'modules/slider-mixed-content/',
		));
	}

}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('TSWPPMSliderMixed', array(

    'general' => array(
        'title'    => __( 'General', 'fl-builder' ),
        'sections' => array(
            'general'    => array(
                'title'  => __( 'General', 'fl-builder' ),
                'fields' => array(
                    'slides'     => array(
                        'type'          => 'form',
                        'label'         => __('Slides', 'fl-builder'),
                        'form'          => 'mixed-slide-form', // ID from registered form below
                        'preview_text'  => 'slide_label', // Name of a field to use for the preview text
                        'multiple'      => true,
                        'limit'      => 5,
                    ),
                ),
            ),

        ),
    ),

));

FLBuilder::register_settings_form('mixed-slide-form', array(
    'title' => __('Teaser', 'fl-builder'),
    'tabs'  => array(
        'general'      => array( // Tab
            'title'         => __('General', 'fl-builder'), // Tab title
            'sections'      => array( // Tab Sections
                'general'       => array( // Section
                    'title'         => '', // Section Title
                    'fields'        => array( // Section Fields
                        'slide_label'       => array(
                            'type'          => 'text',
                            'label'         => __('Name (internal)', 'fl-builder'),
                            'default'       => ''
                        ),

                        'slide_type'     => array(
                            'type'          => 'select',
                            'label'         => __('Slide-Type', 'fl-builder'),
                            'help' => '',
                            'default' => 'content',
                            'options'       => array(
                                'content'    => 'Content-Slide',
                                'product'    => 'Product-Slide (pressmind based)',
                            ),
                            'toggle'        => array(
                                'content'      => array(
                                    'sections'          => array( 'content_slide' )
                                ),
                                'product'      => array(
                                    'sections'          => array( 'product_slide' )
                                ),
                            ),
                        ),

                    )
                ),
                'content_slide'       => array( // Section
                    'title'         => '', // Section Title
                    'fields'        => array( // Section Fields
                        'media_type' => array(
                            'type' => 'select',
                            'label' => __('Media-Type', 'fl-builder'),
                            'default' => 'image',
                            'options' => array(
                                'image' => 'Image',
                                'video' => 'Video'
                            ),
                            'toggle' => array(
                                'image' => array(
                                    'fields' => array('image', 'image_alt_text')
                                ),
                                'video' => array(
                                    'fields' => array('video')
                                )
                            )
                        ),

                        'video'    => array(
                            'type'          => 'video',
                            'label'         => __('Slide-Video', 'fl-builder'),
                        ),

                        'image'    => array(
                            'type'          => 'photo',
                            'label'         => __('Slide-Image', 'fl-builder'),
                        ),

                        'image_alt_text'     => array(
                            'type'    => 'text',
                            'label'   => __( 'Image alternative text', 'fl-builder' ),
                            'default' => '',
                        ),

                        'headline'       => array(
                            'type'          => 'text',
                            'label'         => __('Headline', 'fl-builder'),
                            'default'       => 'Travel is a movement'
                        ),

                        'text'       => array(
                            'type'          => 'text',
                            'label'         => __('Text', 'fl-builder'),
                            'default'       => 'Travel is the movement of people between relatively distant geographical locations.'
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
                            'default' => 'Mehr dazu',
                        ),


                    )
                ),
                'product_slide'       => array( // Section
                    'title'         => '', // Section Title
                    'fields'        => array( // Section Fields

                        'pm-id'       => array(
                            'type'          => 'text',
                            'label'         => 'pressmind ID',
                            'default'       => '',
                            'placeholder' => '12345'
                        ),

                        'product_image_type'     => array(
                            'type'          => 'select',
                            'label'         => 'Image type',
                            'help' => '',
                            'default' => 'content',
                            'options'       => array(
                                'from_product'    => 'from product',
                                'custom'    => 'custom image',
                            ),
                            'toggle'        => array(
                                'custom'      => array(
                                    'fields'          => array( 'product_custom_image', 'product_custom_image_alt_text')
                                ),
                                'from_product'      => array(
                                    'fields'          => array( 'product_image_list_item' )
                                ),
                            ),
                        ),

                        'product_custom_image'    => array(
                            'type'          => 'photo',
                            'label'         => 'Slide Image'
                        ),

                        'product_custom_image_alt_text'     => array(
                            'type'    => 'text',
                            'label'   => __( 'Image alternative text', 'fl-builder' ),
                            'default' => '',
                        ),

                    )
                )


            )
        ),

    )
));
