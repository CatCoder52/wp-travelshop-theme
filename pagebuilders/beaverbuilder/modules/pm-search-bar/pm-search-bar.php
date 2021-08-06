<?php

class TSPMSearchBar extends FLBuilderModule {

	/**
	 * @method __construct
	 */
	public function __construct() {
		parent::__construct(array(
			'name'            => __( 'Searchbar', 'fl-builder' ),
			'description'     => __( 'The pressmind searchbar', 'fl-builder' ),
			'category'        => __( 'pressmind Searchbars', 'fl-builder' ),
			'group'        => __( 'Travelshop', 'fl-builder' ),
			'editor_export'   => false,
			'partial_refresh' => true,
			'icon'            => 'minus.svg',
            'dir'           => BB_MODULE_TS_DIR . 'modules/pm-search-bar/',
            'url'           => BB_MODULE_TS_URL . 'modules/pm-search-bar/',
		));
	}

}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('TSPMSearchBar', array(

    'common' => array(
        'title'    => __( 'Common', 'fl-builder' ),
        'sections' => array(
            'common'    => array(
                'title'  => __( 'Common', 'fl-builder' ),
                'fields' => array(
                    'color_scheme'     => array(
                        'type'    => 'select',
                        'label'   => __( 'Color Scheme', 'fl-builder' ),
                        'default' => 'main-color',
                        'options'       => array(
                            'main-color'    => __( 'main-color', 'fl-builder' ),
                            'transparent'   => __( 'transparent', 'fl-builder' ),
                            'silver'        => __( 'silver', 'fl-builder' )
                        ),
                    ),
                ),
            ),

        ),
    ),


));
