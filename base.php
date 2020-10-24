<?php 

use \Elementor\Plugin as Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

final class Mc_Extension {
	
	const VERSION = '1.0.0';
	const MINIMUM_ELEMENTOR_VERSION = '2.6.0';
	const MINIMUM_PHP_VERSION = '5.6';


	private static $_instance = null;

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	

	public function __construct() {

		add_action( 'init', [ $this, 'i18n' ] );
		add_action( 'plugins_loaded', [ $this, 'init' ] );

	}

	public function i18n() {
		load_plugin_textdomain( 'mc' );
	}

	

	public function init() {
		// Check if Elementor installed and activated
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}
		// Check for required Elementor version
		if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
			return;
		}

		// Check for required PHP version
		if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
			return;
		}

		//add_action( 'elementor/editor/after_enqueue_styles', array ( $this, 'pawelements_editor_styles' ) );
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
		add_action( 'wp_enqueue_scripts', array( $this, 'mc_register_frontend_styles' ), 10 );
		add_action( 'elementor/elements/categories_registered',[$this,'register_new_category']);
		
	}
	


	function mc_register_frontend_styles(){
		wp_enqueue_style(
			'mc-style',
			 MC_ADDONS_ASSETS .'/css/style.css',
			 null, MC_VERSION
		);
	}
	
	/**
	 * Widgets Catgory
	 *
	*/
	public function register_new_category($manager){
	   $manager->add_category('mc',
			[
				'title' => __( 'Mc Companion  Addons', 'pawelements-companion' ),
			]);
	}

	public function admin_notice_minimum_php_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'pawelements-companion' ),
			'<strong>' . esc_html__( 'Elementor Mc Extension', 'pawelements-companion' ) . '</strong>',
			'<strong>' . esc_html__( 'PHP', 'pawelements-companion' ) . '</strong>',
			 self::MINIMUM_PHP_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );
		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor */
			esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 'pawelements-companion' ),
			'<strong>' . esc_html__( 'Elementor Mc Extension', 'pawelements-companion' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'pawelements-companion' ) . '</strong>'
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	public function admin_notice_minimum_elementor_version() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = sprintf(
			/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
			esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 'pawelements-companion' ),
			'<strong>' . esc_html__( 'Elementor Mc Extension', 'pawelements-companion' ) . '</strong>',
			'<strong>' . esc_html__( 'Elementor', 'pawelements-companion' ) . '</strong>',
			 self::MINIMUM_ELEMENTOR_VERSION
		);

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	public function init_widgets() {

		$widgets_manager = \Elementor\Plugin::instance()->widgets_manager;
		//Include Widget files

		//Button Widget
		require_once( MC_ADDONS_DIR . 'blog-post/blog-post.php' );
		$widgets_manager->register_widget_type( new \Mc\Widgets\Elementor\Mc_blog() );

		
		

	}


}

Mc_Extension::instance();
