<?php

class TSWPTeam extends FLBuilderModule {

    /**
     * @method __construct
     */
    public function __construct() {
        parent::__construct(array(
            'name'            => __( 'Team', 'fl-builder' ),
            'description'     => __( 'Just a simple Team overview', 'fl-builder' ),
            'category'        => __( 'Content Modules', 'fl-builder' ),
            'group'        => __( 'Travelshop', 'fl-builder' ),
            'editor_export'   => false,
            'partial_refresh' => true,
            'icon'            => 'star-filled.svg',
            'dir'           => BB_MODULE_TS_DIR . 'modules/history/',
            'url'           => BB_MODULE_TS_URL . 'modules/history/',
        ));
    }

}

/**
 * Register the module and its form settings.
 */
FLBuilder::register_module('TSWPTeam', array(
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
        'title'    => __( 'Team', 'fl-builder' ),
        'sections' => array(
            'common'    => array(
                'title'  => __( 'Team-Items', 'fl-builder' ),
                'fields' => array(
                    'teasers'     => array(
                        'type'          => 'form',
                        'label'         => __('Items', 'fl-builder'),
                        'form'          => 'team-item-form', // ID from registered form below
                        'preview_text'  => 'name', // Name of a field to use for the preview text
                        'multiple'      => true,
                        'limit'      => 100,
                    ),

                ),
            ),

        ),
    ),


));

FLBuilder::register_settings_form('team-item-form', array(
    'title' => __('Team', 'fl-builder'),
    'tabs'  => array(

        'general'      => array( // Tab
            'title'         => __('General', 'fl-builder'), // Tab title
            'sections'      => array( // Tab Sections
                'general'       => array( // Section
                    'title'         => '', // Section Title
                    'fields'        => array( // Section Fields
                        'image'    => array(
                            'type'          => 'photo',
                            'label'         => __('Image', 'fl-builder'),
                        ),

                        'name'       => array(
                            'type'          => 'text',
                            'label'         => __('Name', 'fl-builder'),
                            'default'       => 'Max Mustermann'
                        ),

                        'position'       => array(
                            'type'          => 'text',
                            'label'         => __('Position', 'fl-builder'),
                            'default'       => 'Reiseexperte'
                        ),

                        'text'       => array(
                            'type'          => 'text',
                            'label'         => __('Text', 'fl-builder'),
                            'default'       => ''
                        ),

                        'mail'       => array(
                            'type'          => 'text',
                            'label'         => __('Mail', 'fl-builder'),
                            'default'       => ''
                        ),

                        'phone'       => array(
                            'type'          => 'text',
                            'label'         => __('Phone', 'fl-builder'),
                            'default'       => ''
                        ),

                        'btn_text' => array(
                            'type' => 'text',
                            'label' => __('Button text', 'fl-builder'),
                            'default' => 'Über mich'
                        ),

                        'btn_link' => array(
                            'type' => 'link',
                            'label' => __('Button link', 'fl-builder')
                        )
                    )
                )
            )
        ),

    )
));
