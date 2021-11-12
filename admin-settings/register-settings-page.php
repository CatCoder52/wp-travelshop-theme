<?php
class WPSFRegisterSettingsPage {

	/**
	 * @var WordPressSettingsFramework
	 */
	private $wpsf;

	/**
	 * WPSFTest constructor.
	 */
	public function __construct($setting_config_file, $option_group = false) {

		// Include and create a new WordPressSettingsFramework
		require_once( 'wp-settings-framework.php' );
		$this->wpsf = new WordPressSettingsFramework( $setting_config_file, $option_group );

		// Add admin menu
		add_action( 'admin_menu', array( $this, 'add_settings_page' ), 20 );
		
		// Add an optional settings validation filter (recommended)
		//add_filter( $this->wpsf->get_option_group() . '_settings_validate', array( &$this, 'validate_settings' ) );
	}

	/**
	 * Add settings page.
	 */
	public function add_settings_page() {
		$this->wpsf->add_settings_page( array(
			'parent_slug' => '',
			'page_title'  => 'Travelshop Settings',
			'menu_title'  => 'Travelshop Settings',
			'capability'  => 'edit_pages',
		) );
	}

	/**
	 * Validate settings.
	 * 
	 * @param $input
	 *
	 * @return mixed
	 */
	public function validate_settings( $input ) {
		// Do your settings validation here
		// Same as $sanitize_callback from http://codex.wordpress.org/Function_Reference/register_setting
		return $input;
	}
}
$WPSFRegisterSettingsPage = new WPSFRegisterSettingsPage('travelshop-settings.php', 'travelshop_wpsf');
