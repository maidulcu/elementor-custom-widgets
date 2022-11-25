<?php
namespace DwlElementorAddon;

use DwlElementorAddon\PageSettings\Page_Settings;

/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.2.0
 */
class Plugin {

	/**
	 * Instance
	 *
	 * @since 1.2.0
	 * @access private
	 * @static
	 *
	 * @var Plugin The single instance of the class.
	 */
	private static $_instance = null;

	/**
	 * Instance
	 *
	 * Ensures only one instance of the class is loaded or can be loaded.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * widget_scripts
	 *
	 * Load required plugin core files.
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function widget_scripts() {

		//wp_register_script( 'unitek-elementor-main', plugin_dir_url(__FILE__).'assets/js/main.js', [ 'jquery' ], time(), true );
		
	}
	 
	public function frontend_assets_styles() {

		wp_enqueue_style('dwl-slick', plugin_dir_url(__FILE__).'lib/slick-slider/slick/slick.css', [], '1.0');
		wp_enqueue_style('dwl-slick-theme', plugin_dir_url(__FILE__).'lib/slick-slider/slick/slick-theme.css', [], '1.0');
		wp_enqueue_style('dwl-testimonial', plugin_dir_url(__FILE__).'assets/css/testimonial.css', [], '1.0');
		
	}

	public function frontend_assets_scripts() {

		wp_enqueue_script('dwl-slick', plugin_dir_url(__FILE__).'lib/slick-slider/slick/slick.min.js', ['jquery'], time(), true);
		wp_enqueue_script('dwl-main', plugin_dir_url(__FILE__).'assets/js/main.js', ['jquery'], time(), true);
		
	}

	/**
	 * Editor scripts
	 *
	 * Enqueue plugin javascripts integrations for Elementor editor.
	 *
	 * @since 1.2.1
	 * @access public
	 */
	public function editor_scripts() {
		add_filter( 'script_loader_tag', [ $this, 'editor_scripts_as_a_module' ], 10, 2 );
		
		wp_enqueue_script(
			'unitek-elementor-editor',
			plugins_url( '/assets/js/editor/editor.js', __FILE__ ),
			[
				'elementor-editor',
			],
			'1.2.1',
			true
		);
	}

	/**
	 * Force load editor script as a module
	 *
	 * @since 1.2.1
	 *
	 * @param string $tag
	 * @param string $handle
	 *
	 * @return string
	 */
	public function editor_scripts_as_a_module( $tag, $handle ) {
		if ( 'unitek-elementor-editor' === $handle ) {
			$tag = str_replace( '<script', '<script type="module"', $tag );
		}

		return $tag;
	}

	/**
	 * Register Widgets
	 *
	 * Register new Elementor widgets.
	 *
	 * @since 1.2.0
	 * @access public
	 *
	 * @param Widgets_Manager $widgets_manager Elementor widgets manager.
	 */
	public function register_widgets( $widgets_manager ) {
		// Its is now safe to include Widgets files
	

		require_once( __DIR__ . '/widgets/testimonial-slider.php' );


		$widgets_manager->register( new Widgets\Testimonial_Slider() );
	}

	/**
	 * Add page settings controls
	 *
	 * Register new settings for a document page settings.
	 *
	 * @since 1.2.1
	 * @access private
	 */
	private function add_page_settings_controls() {
		require_once( __DIR__ . '/page-settings/manager.php' );
		new Page_Settings();
	}

	/**
	 *  Plugin class constructor
	 *
	 * Register plugin action hooks and filters
	 *
	 * @since 1.2.0
	 * @access public
	 */
	public function __construct() {

		// Register widget scripts
		add_action( 'elementor/frontend/after_register_scripts', [ $this, 'widget_scripts' ] );

		// Register widgets
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );

		// Register editor scripts
		add_action( 'elementor/editor/after_enqueue_scripts', [ $this, 'editor_scripts' ] );

		add_action( "elementor/frontend/after_enqueue_styles", [ $this, 'frontend_assets_styles' ] );
		add_action( "elementor/frontend/after_enqueue_scripts", [ $this, 'frontend_assets_scripts' ] );
		add_action( "elementor/editor/before_enqueue_scripts", [ $this, 'frontend_assets_scripts' ] );

		
		$this->add_page_settings_controls();
	}
}

// Instantiate Plugin Class
Plugin::instance();
