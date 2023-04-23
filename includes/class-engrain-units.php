<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/buynyakov/engrain-units
 * @since      1.0.0
 *
 * @package    Engrain_Units
 * @subpackage Engrain_Units/includes
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
 * @package    Engrain_Units
 * @subpackage Engrain_Units/includes
 * @author     Andrey Buynyakov <buynyakov@gmail.com>
 */
class Engrain_Units {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @var      Engrain_Units_Loader
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @var      string
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @var      string
	 */
	protected $version;

	/**
	 * The post type used by the plugin.
	 *
	 * @since    1.0.0
	 * @var      string
	 */
	protected $post_type;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'ENGRAIN_UNITS_VERSION' ) ) {
			$this->version = ENGRAIN_UNITS_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'engrain-units';
		$this->post_type = 'unit';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Engrain_Units_Loader. Orchestrates the hooks of the plugin.
	 * - Engrain_Units_i18n. Defines internationalization functionality.
	 * - Engrain_Units_Admin. Defines all hooks for the admin area.
	 * - Engrain_Units_Public. Defines all hooks for the public side of the site.
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
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-engrain-units-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-engrain-units-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-engrain-units-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-engrain-units-public.php';

		$this->loader = new Engrain_Units_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Engrain_Units_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Engrain_Units_i18n();

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

		$plugin_admin = new Engrain_Units_Admin( $this->get_plugin_name(), $this->get_version(), $this->get_post_type() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'init', $plugin_admin, 'register_post_type');
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_menu_page');
		$this->loader->add_action( 'admin_action_make_a_call', $plugin_admin, 'action_make_a_call');
		$this->loader->add_action( 'manage_'.$this->get_post_type().'_posts_columns', $plugin_admin, 'set_posts_columns');
		$this->loader->add_action( 'manage_'.$this->get_post_type().'_posts_custom_column', $plugin_admin, 'set_posts_columns_content', 10, 2);
		$this->loader->add_filter( 'manage_edit-'.$this->get_post_type().'_sortable_columns', $plugin_admin, 'set_posts_sortable_columns');


	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Engrain_Units_Public( $this->get_plugin_name(), $this->get_version(), $this->get_post_type());

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'init', $plugin_public, 'add_shortcode');

		
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
	 * @return    Engrain_Units_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Retrieve the custom post type name.
	 *
	 * @since     1.0.0
	 * @return    string
	 */
	public function get_post_type() {
		return $this->post_type;
	}

}
