<?php
/**
 * Main plugin class
 */

class Elementor_Concierge_Addons {

	/**
	 * Instance of the class
	 */
	private static $instance = null;

	/**
	 * Get instance
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->init_hooks();
	}

	/**
	 * Initialize hooks
	 */
	private function init_hooks() {
		add_action( 'elementor/elements/categories_registered', [ $this, 'register_category' ] );
		add_action( 'elementor/widgets/register', [ $this, 'register_widgets' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_assets' ] );
		add_action( 'elementor/editor/footer', [ $this, 'editor_scripts' ] );
	}

	/**
	 * Register custom category
	 */
	public function register_category( $elements_manager ) {
		$elements_manager->add_category(
			'concierge-golf',
			[
				'title' => esc_html__( 'Concierge Golf', 'elementor-concierge-addons' ),
				'icon'  => 'fa fa-golf-ball',
			]
		);
	}

	/**
	 * Register widgets
	 */
	public function register_widgets( $widgets_manager ) {
		// Register Sidebar Nav Title widget
		require_once ELEMENTOR_CONCIERGE_ADDONS_PATH . 'includes/widgets/sidebar-nav-title.php';
		$widgets_manager->register( new \Elementor_Sidebar_Nav_Title() );

		// Register Sidebar Nav widget
		require_once ELEMENTOR_CONCIERGE_ADDONS_PATH . 'includes/widgets/sidebar-nav.php';
		$widgets_manager->register( new \Elementor_Sidebar_Nav() );

		// Register Tour Toggle widget
		require_once ELEMENTOR_CONCIERGE_ADDONS_PATH . 'includes/widgets/tour-toggle.php';
		$widgets_manager->register( new \Elementor_Tour_Toggle() );
	}

	/**
	 * Enqueue frontend assets
	 */
	public function enqueue_assets() {
		// Register and enqueue CSS
		wp_register_style(
			'elementor-concierge-addons-css',
			ELEMENTOR_CONCIERGE_ADDONS_URL . 'assets/css/elementor-addons.css',
			[],
			ELEMENTOR_CONCIERGE_ADDONS_VERSION
		);
		wp_enqueue_style( 'elementor-concierge-addons-css' );

		// Register and enqueue JS
		wp_register_script(
			'elementor-concierge-addons-js',
			ELEMENTOR_CONCIERGE_ADDONS_URL . 'assets/js/elementor-addons.js',
			[ 'jquery' ],
			ELEMENTOR_CONCIERGE_ADDONS_VERSION,
			true
		);
		wp_enqueue_script( 'elementor-concierge-addons-js' );
	}

	/**
	 * Load editor scripts
	 */
	public function editor_scripts() {
		// Add any Elementor editor scripts if needed
	}

}
