<?php

class TSPMSearchHeader extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Search Header', 'fl-builder' ),
			'description'     => __( 'The pressmind search bar embedded in a hero image', 'fl-builder' ),
			'category'        => __( 'pressmind Searchbars', 'fl-builder' ),
			'group'        => __( 'Travelshop', 'fl-builder' ),
			'editor_export'   => false,
			'partial_refresh' => true,
			'icon'            => 'slides.svg',
            'dir'           => BB_MODULE_TS_DIR . 'modules/pm-search-header/',
            'url'           => BB_MODULE_TS_URL . 'modules/pm-search-header/',
		));
	}

}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('TSPMSearchHeader', array(

    'common' => array(
        'title'    => __( 'Common', 'fl-builder' ),
        'sections' => array(
            'common'    => array(
                'title'  => __( 'Common', 'fl-builder' ),
                'fields' => array(
                    'headline'     => array(
                        'type'    => 'text',
                        'label'   => __( 'Headline', 'fl-builder' ),
                        'default' => 'Finde deine Traumreise!',
                    ),
                ),
            ),

        ),
    ),


));
