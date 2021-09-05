<?php

class TSPMCalendar extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Travel-Calendar', 'fl-builder' ),
			'description'     => __( 'Travel Calendar date by date', 'fl-builder' ),
            'category'        => __( 'pressmind Travel Calendar', 'fl-builder' ),
            'group'        => __( 'Travelshop', 'fl-builder' ),
			'editor_export'   => false,
			'partial_refresh' => true,
			'icon'            => 'editor-table.svg',
            'dir'           => BB_MODULE_TS_DIR . 'modules/pm-calendar/',
            'url'           => BB_MODULE_TS_URL . 'modules/pm-calendar/',
		));
	}

}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('TSPMCalendar', array(

    'general' => array(
        'title'    => __( 'General', 'fl-builder' ),
        'sections' => array(
            'general'    => array(
                'title'  => __( 'General', 'fl-builder' ),
                'fields' => array(
                    'headline'     => array(
                        'type'    => 'text',
                        'label'   => __( 'Headline', 'fl-builder' ),
                        'default' => 'Die besten Reiseziele für jeden Monat',
                    ),

                    'text'     => array(
                        'type'    => 'editor',
                        'media_buttons' => false,
                        'wpautop'       => false,
                        'label'   => __( 'Text', 'fl-builder' ),
                        'default' => 'Travel is the movement of people between relatively distant geographical locations, and can involve travel by foot, bicycle, automobile, train, boat, bus, airplane, or other means, with or without luggage, and can be one way or round trip.'
                    ),
                ),
            ),

        ),
    ),



));
