<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/buynyakov/engrain-units
 * @since      1.0.0
 *
 * @package    Engrain_Units
 * @subpackage Engrain_Units/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Engrain_Units
 * @subpackage Engrain_Units/public
 * @author     Andrey Buynyakov <buynyakov@gmail.com>
 */
class Engrain_Units_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private $version;

	/**
	 * The post type used by the plugin.
	 *
	 * @since    1.0.0
	 * @var      string		$post_type	Custom post type
	 */
	private $post_type;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0

	 */
	public function __construct( $plugin_name, $version, $post_type) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->post_type = $post_type;

	}

	/**
	 * Hook for a shortcode.
	 *
	 * @since    1.0.0
	 */
	public function add_shortcode(){
		add_shortcode("shortcode_{$this->post_type}_list", array($this, "render_shortcode_content"));
	}

	/**
	 * Renders the units lists for shortcode.
	 *
	 * @since    1.0.0
	 */
	public function render_shortcode_content($args, $content, $shortcode){
		
		$posts = array();

		$posts['Units with area greater than 1'] = get_posts(
			array(
				'post_type' => $this->post_type,
				'post_status' => 'publish',
				'numberposts' => 12,
				'meta_key' => 'area',
				'meta_value' => 1,
				'meta_compare' => '>',
				)
		);
		$posts['Units with an area of 1'] = get_posts(
			array(
				'post_type' => $this->post_type,
				'post_status' => 'publish',
				'numberposts' => 12,
				'meta_key' => 'area',
				'meta_value' => 1,
				'meta_compare' => '=',
				)
		);		

		ob_start();
		
		require( plugin_dir_path( dirname(__FILE__ ))  . "public/partials/engrain-units-public-display.php");

		return ob_get_clean();
		
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/engrain-units-public.css', array(), mt_rand(0,99999) /* $this->version */, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/engrain-units-public.js', array( 'jquery' ), $this->version, false );

	}

}
