<?php

class TSWPImageTeaser extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'WP image teaser', 'fl-builder' ),
			'description'     => __( 'Image Teaser, based on post types', 'fl-builder' ),
			'category'        => __( 'WordPress Posts & Pages', 'fl-builder' ),
			'group'        => __( 'Travelshop', 'fl-builder' ),
			'editor_export'   => false,
			'partial_refresh' => true,
			'icon'            => 'schedule.svg',
            'dir'           => BB_MODULE_TS_DIR . 'modules/wp-image-teaser/',
            'url'           => BB_MODULE_TS_URL . 'modules/wp-image-teaser/',
		));
	}

}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('TSWPImageTeaser', array(

    'common' => array(
        'title'    => __( 'Common', 'fl-builder' ),
        'sections' => array(
            'common'    => array(
                'title'  => __( 'Common', 'fl-builder' ),
                'fields' => array(
                    'headline'     => array(
                        'type'    => 'text',
                        'label'   => __( 'Headline', 'fl-builder' ),
                        'default' => 'Beliebte Reiseziele',
                    ),

                    'text'     => array(
                        'type'    => 'editor',
                        'media_buttons' => false,
                        'wpautop'       => false,
                        'label'   => __( 'Text', 'fl-builder' ),
                        'default' => 'Travel is the movement of people between relatively distant geographical locations, and can involve travel by foot, bicycle, automobile, train, boat, bus, airplane, or other means, with or without luggage, and can be one way or round trip. ',
                    ),
                    'posts_per_page'     => array(
                        'type' => 'unit',
                        'label' => 'Items per page',
                        'default' => '10',
                        'placeholder' => '10',
                        'sanitize' => 'absint',
                        'slider' => array(
                            'min' => 1,
                            'max' => 100,
                            'step' => 1,
                        ),
                    ),

                ),
            ),

        ),
    ),
	'content'    => array(
		'title' => __( 'Content', 'fl-builder' ),
		'file'  => FL_BUILDER_DIR . 'includes/loop-settings.php',
	),

));
