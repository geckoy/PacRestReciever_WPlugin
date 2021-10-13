<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://www.facebook.com/geckowebdev.ml/
 * @since      1.0.0
 *
 * @package    Paa
 * @subpackage Paa/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Paa
 * @subpackage Paa/includes
 * @author     Younes Arab nedjadi <younesheissenmann@gmail.com>
 */
class Paa {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Paa_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PAA_VERSION' ) ) {
			$this->version = PAA_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'paa';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		//$this->define_public_hooks();
		$this->define_Endpoint_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Paa_Loader. Orchestrates the hooks of the plugin.
	 * - Paa_i18n. Defines internationalization functionality.
	 * - Paa_Admin. Defines all hooks for the admin area.
	 * - Paa_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-paa-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-paa-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-paa-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		// require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-paa-public.php';
		
		/**
		 * The class responsible for Handling endpoints of the Plugin "REST API'S".
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'endpoint/class-paa-endpoint.php';

		/**
		 * Register Helper function 
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/paa-functions.php';



		$this->loader = new Paa_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Paa_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Paa_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Paa_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		/** 
		 * Display Administration menus hook 
		 */ 
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'Paa_options_page' );
		
		/**
		 *  Register settings for our plugin administration menus
		 */
		$this->loader->add_action( 'admin_init', $plugin_admin, 'Paa_settings_init' );
		
		/**
		 * Public init hook action wordpress
		 */
		$this->loader->add_action( 'init', $plugin_admin, 'Paa_public_init' );
		
		/** 
		 * Meta box for 'more Account details in product edit page'
		 */	
		$this->loader->add_action( 'add_meta_boxes', $plugin_admin, 'admin_product_add_custom_box' );

		/** 
		 * Hook fires after the deletion of post
		 */	
		$this->loader->add_action( 'after_delete_post', $plugin_admin, 'delete_db_data_after_post_deletion' );
		
		/** 
		 * Hook fires when order status get completed
		 */	
		$this->loader->add_action( 'woocommerce_order_status_completed', $plugin_admin, 'order_status_completed' );
		
		/**
		 * hooks fires when order status denined 'cancelled failed refunded'
		 */
		$this->loader->add_action( 'woocommerce_order_status_failed', $plugin_admin, 'order_status_denied' );
		$this->loader->add_action( 'woocommerce_order_status_refunded', $plugin_admin, 'order_status_denied' );
		$this->loader->add_action( 'woocommerce_order_status_cancelled', $plugin_admin, 'order_status_denied' );

		/** 
		 * Hook update the price of product in the db 
		 */	
		$this->loader->add_action( 'admin_init', $plugin_admin, 'update_price' );
		
		/**
		 * Account in csv
		 */
		$this->loader->add_action( 'template_redirect', $plugin_admin, 'csv_accounts' );

		/**
		 * Send Account on purchase
		 */
		$this->loader->add_action( 'woocommerce_payment_complete', $plugin_admin, 'send_account_on_payment' );
		
		// /**
		//  * run Cron job
		//  */
		// $this->loader->add_action( 'paa_cron_delete_jiahua', $plugin_admin, 'paa_cron_delete_jiahua_cp' );

		// /**
		//  * Add custom cron schedule every second
		//  */
		// $this->loader->add_filter( 'cron_schedules', $plugin_admin, 'cron_schedule_every_second' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Paa_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the Endpoint area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_Endpoint_hooks() {
		
		$plugin_endpoint = new Paa_Endpoint( $this->get_plugin_name(), $this->get_version() );

		/** 
		 *  Adding Custom Endpoints to handle the account registering
		 */
		$this->loader->add_action( 'rest_api_init', $plugin_endpoint, 'Paa_rest_api_endpoint' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Paa_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
