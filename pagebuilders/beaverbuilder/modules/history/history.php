<?php
class TSWPHistory extends FLBuilderModule {

    /**
     * @method __construct
     */
    public function __construct() {
        parent::__construct(array(
            'name'            => __( 'History Timeline', 'fl-builder' ),
            'description'     => __( 'Just a simple history', 'fl-builder' ),
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
FLBuilder::register_module('TSWPHistory', array(
    'teasers' => array(
        'title'    => __( 'History-Items', 'fl-builder' ),
        'sections' => array(
            'common'    => array(
                'title'  => __( 'History-Items', 'fl-builder' ),
                'fields' => array(
                    'teasers'     => array(
                        'type'          => 'form',
                        'label'         => __('Items', 'fl-builder'),
                        'form'          => 'history-item-form', // ID from registered form below
                        'preview_text'  => 'headline', // Name of a field to use for the preview text
                        'multiple'      => true,
                    ),

                ),
            ),

        ),
    ),
));

FLBuilder::register_settings_form('history-item-form', array(
    'title' => __('History', 'fl-builder'),
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

                        'date' => array(
                            'type'  => 'text',
                            'label' => __('Date', 'fl-builder'),
                            'default'       => 'April 2020'
                        ),

                        'dot_type'     => array(
                            'type'          => 'select',
                            'label'         => __('Dot type', 'fl-builder'),
                            'help' => '',
                            'default' => 'content',
                            'options'       => array(
                                'default'    => 'Default',
                                'svg'    => 'Icon',
                            ),
                            'toggle' => array(
                                'default' => array(
                                    'fields' => array('dot_color')
                                ),
                                'svg' => array(
                                    'fields' => array('dot_svg', 'dot_color')
                                )
                            )
                        ),

                        'dot_svg'       => array(
                            'type'          => 'code',
                            'help'  => 'Place svg code here. Use https://tablericons.com/ for getting icons (size: 52, stroke-width: 1.5 is recommend)',
                            'editor'        => 'html',
                            'rows'          => '18',
                            'label'         => __('SVG icon', 'fl-builder'),
                            'default'       => '<svg enable-background="new 0 0 430.23 430.23" version="1.1" viewBox="0 0 430.23 430.23" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="m217.88 159.67c-24.237 0-43.886 19.648-43.886 43.886 0 24.237 19.648 43.886 43.886 43.886 24.237 0 43.886-19.648 43.886-43.886s-19.648-43.886-43.886-43.886zm0 66.873c-12.696 0-22.988-10.292-22.988-22.988s10.292-22.988 22.988-22.988 22.988 10.292 22.988 22.988-10.292 22.988-22.988 22.988z"/><path d="m392.9 59.357-285.26-32.391c-11.071-1.574-22.288 1.658-30.824 8.882-8.535 6.618-14.006 16.428-15.151 27.167l-5.224 42.841h-16.197c-22.988 0-40.229 20.375-40.229 43.363v213.68c-0.579 21.921 16.722 40.162 38.644 40.741 0.528 0.014 1.057 0.017 1.585 0.01h286.82c22.988 0 43.886-17.763 43.886-40.751v-8.359c7.127-1.377 13.888-4.224 19.853-8.359 8.465-7.127 13.885-17.22 15.151-28.212l24.033-212.11c2.45-23.041-14.085-43.768-37.094-46.499zm-42.841 303.54c0 11.494-11.494 19.853-22.988 19.853h-286.82c-10.383 0.305-19.047-7.865-19.352-18.248-0.016-0.535-9e-3 -1.07 0.021-1.605v-38.661l80.98-59.559c9.728-7.469 23.43-6.805 32.392 1.567l56.947 50.155c8.648 7.261 19.534 11.32 30.825 11.494 8.828 0.108 17.511-2.243 25.078-6.792l102.92-59.559v101.36zm0-125.91-113.89 66.351c-9.78 5.794-22.159 4.745-30.825-2.612l-57.469-50.678c-16.471-14.153-40.545-15.021-57.992-2.09l-68.963 50.155v-148.9c0-11.494 7.837-22.465 19.331-22.465h286.82c12.28 0.509 22.197 10.201 22.988 22.465v87.771zm59.057-133.96c-7e-3 0.069-0.013 0.139-0.021 0.208l-24.555 212.11c0.042 5.5-2.466 10.709-6.792 14.106-2.09 2.09-6.792 3.135-6.792 4.18v-184.42c-0.825-23.801-20.077-42.824-43.886-43.363h-249.73l4.702-40.751c1.02-5.277 3.779-10.059 7.837-13.584 4.582-3.168 10.122-4.645 15.674-4.18l284.74 32.914c11.488 1.091 19.918 11.29 18.827 22.78z"/></svg>'
                        ),

                        'dot_color' => array(
                            'type'          => 'color',
                            'label'         => __( 'Dot color', 'fl-builder' ),
                            'default'       => 'adb5bd',
                            'show_reset'    => true,
                            'show_alpha'    => true
                        ),

                        'image'    => array(
                            'type'          => 'photo',
                            'label'         => __('Image', 'fl-builder'),
                        ),

                        'custom_image_alt_text'     => array(
                            'type'    => 'text',
                            'label'   => __( 'Image alternative text', 'fl-builder' ),
                            'default' => '',
                        ),

                        'custom_image_caption_text'     => array(
                            'type'    => 'text',
                            'label'   => __( 'Image caption text', 'fl-builder' ),
                            'default' => '',
                        ),
                    )
                )
            )
        ),

    )
));
