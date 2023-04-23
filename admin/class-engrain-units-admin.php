<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/buynyakov/engrain-units
 * @since      1.0.0
 *
 * @package    Engrain_Units
 * @subpackage Engrain_Units/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    Engrain_Units
 * @subpackage Engrain_Units/admin
 * @author     Andrey Buynyakov <buynyakov@gmail.com>
 */
class Engrain_Units_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string
	 */
	private $version;

	/**
	 * The post type used by the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string
	 */
	private $post_type;

	/**
	 * API endpoint for retrieving units data. 
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string
	 */	
	private $api_endpoint = "https://api.sightmap.com/v1/assets/1273/multifamily/units";
	
	/**
	 * API Key for accessing the endpoint, posted in a header as "API-Key".
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string
	 */		
	private $api_key = "7d64ca3869544c469c3e7a586921ba37";

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
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/engrain-units-admin.css', array(), $this->version, 'all' );
		
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/engrain-units-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register custome post type.
	 *
	 * @since    1.0.0
	 */	
	public function register_post_type() {

		
		register_post_type($this->post_type,
		array(
			'labels'      => array(
				'name'          => __('Units'),
				'singular_name' => __('Unit'),
			),
				'public'      => true,
				'has_archive' => true,
				'supports' => array( 'title', 'custom-fields' )
				//'rewrite'   => array( 'slug' => 'unit' )	
		));
		
	}


	/**
	 * Add an admin page for the plugin to the menu.
	 *
	 * @since    1.0.0
	 */		
	public function add_menu_page() {

		add_menu_page(
			__('Engrain Units'),
			__('Engrain Units'),
			'manage_options',
			plugin_dir_path(  __FILE__  ) . 'partials/engrain-units-admin-display.php',
			null,
			plugin_dir_url(__FILE__) . 'images/icon.png',
			40
		);

	}


	/**
	 * Customize columns for the new post type table.
	 *
	 * @since    1.0.0
	 */		
	public function set_posts_columns($columns){

		 
		$columns = array(
			
			'cb' => '<input type="checkbox" />',
			'title' => __( 'Title' ),
			'floor_plan_id' => __( 'Floor plan ID' ),
			'date' => __( 'Date' )
		);

		return $columns;

	}

	/**
	 * Fill in custom columns with a content.
	 *
	 * @since    1.0.0
	 */		
	public function set_posts_columns_content($column, $post_id){

		if( $column == "floor_plan_id"){
			echo get_post_meta($post_id, $column, true);
		}
	}

	/**
	 * Make custom columns sortable.
	 *
	 * @since    1.0.0
	 */		
	public function set_posts_sortable_columns($columns){

		$columns["floor_plan_id"] = "floor_plan_id";

		return $columns;
	}

	/**
	 * Retrive units from the API, save as a custom type posts. 
	 *  
	 *
	 * @since    1.0.0
	 */	
	public function action_make_a_call(){

		$response = wp_remote_get($this->api_endpoint . "?per-page=250", 
			array("headers" =>
				array("API-Key" => $this->api_key)
			)
		);

		if( !is_wp_error($response)) {

			$units = json_decode(wp_remote_retrieve_body($response));

			if( $units && $units->data){

				foreach($units->data as $unit){
					
					$post_id = wp_insert_post(
						array (
							'post_type' => $this->post_type,
							'post_title' => $unit->unit_number,
							'post_content' => '',
							'post_status' => 'publish',
							'comment_status' => 'published',
							'meta_input' => (array) $unit
					));
				}
			}
		}

		if( isset($post_id) && $post_id){
			wp_safe_redirect($_SERVER["HTTP_REFERER"]."&success=1");
		}
		else{
			wp_safe_redirect($_SERVER["HTTP_REFERER"]."&error=1");
		}
				

	}


}
