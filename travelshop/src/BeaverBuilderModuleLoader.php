<?php

/**
 * A class that handles loading custom modules and custom
 * fields if the builder is installed and activated.
 */
class BeaverBuilderModuleLoader{

    /**
     * Setup hooks if the builder is installed and activated.
     */
    static public function init() {

        if ( ! class_exists( 'FLBuilder' ) ) {
            return;
        }

        // Load custom modules.
        add_action( 'init', __CLASS__ . '::load_modules' );

        // Register custom fields.
        add_filter( 'fl_builder_custom_fields', __CLASS__ . '::register_fields' );

        // Enqueue custom field assets.
        add_action( 'init', __CLASS__ . '::enqueue_field_assets' );
    }

    /**
     * Loads our custom modules.
     */
    static public function load_modules() {
        require_once BB_MODULE_TS_DIR . 'modules/basic-example/basic-example.php';
        require_once BB_MODULE_TS_DIR . 'modules/example/example.php';
    }

    /**
     * Registers our custom fields.
     */
    static public function register_fields( $fields ) {
        $fields['my-custom-field'] = BB_MODULE_TS_DIR . 'fields/my-custom-field.php';
        return $fields;
    }

    /**
     * Enqueues our custom field assets only if the builder UI is active.
     */
    static public function enqueue_field_assets() {
        if ( ! FLBuilderModel::is_builder_active() ) {
            return;
        }

        wp_enqueue_style( 'my-custom-fields', BB_MODULE_TS_URL . 'assets/css/fields.css', array(), '' );
        wp_enqueue_script( 'my-custom-fields', BB_MODULE_TS_URL . 'assets/js/fields.js', array(), '', true );
    }
}
