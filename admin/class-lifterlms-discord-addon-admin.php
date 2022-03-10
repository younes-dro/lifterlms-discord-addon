<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.expresstechsoftwares.com
 * @since      1.0.0
 *
 * @package    Lifterlms_Discord_Addon
 * @subpackage Lifterlms_Discord_Addon/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Lifterlms_Discord_Addon
 * @subpackage Lifterlms_Discord_Addon/admin
 * @author     ExpressTech Softwares Solutions Pvt Ltd <contact@expresstechsoftwares.com>
 */
class Lifterlms_Discord_Addon_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/* 
		Adding child menu under top level lifterlms menu
	*/

	public function ets_lifterlms_add_admin_menu() {
		add_submenu_page( 'lifterlms', 
		_( 'Discord Settings'),
		 _( 'Discord Settings'), 
		 'manage_options', 
		 'lifterlms-discord-addon',
		  array( $this, 'ets_lifterlms_discord_view' ), 999 );
	}
    /* 
		Details of page
	*/

	public function ets_lifterlms_discord_view(){
		if ( !current_user_can('administrator') ) {
			return;
		}
		require_once LIFTERLMS_DISCORD_PLUGIN_DIR_PATH.'admin/partials/lifterlms-discord-addon-admin-display.php';
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Lifterlms_Discord_Addon_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Lifterlms_Discord_Addon_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style( $this->plugin_name .'skeletabs.css', plugin_dir_url( __FILE__ ) . 'css/skeletabs.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/lifterlms-discord-admin.min.css', array(), $this->version, 'all' );
		
		wp_enqueue_style( $this->plugin_name."select2.css", plugin_dir_url( __FILE__ ) . 'css/select2.min.css', array(), $this->version, 'all' );
		
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/lifterlms-discord-addon-admin.css', array(), $this->version, 'all' );
		
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Lifterlms_Discord_Addon_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Lifterlms_Discord_Addon_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/lifterlms-discord-addon-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/lifterlms-discord-admin.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'select2', plugin_dir_url( __FILE__ ) . 'js/select2.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name.'skeletabs.js', plugin_dir_url( __FILE__ ) . 'js/skeletabs.js', array( 'jquery' ), $this->version, false );
		
	}

	/**
	 * Save application details on Server 
	 * 
	 */

	public function ets_lifterlms_discord_save_application_details(){
		if ( ! current_user_can( 'administrator' ) ) {
			wp_send_json_error( 'You do not have sufficient rights', 403 );
			exit();
		}
		$ets_lifterlms_discord_client_id = isset( $_POST['ets_lifterlms_discord_client_id'] ) ? sanitize_text_field( trim( $_POST['ets_lifterlms_discord_client_id'] ) ) : '';		
		$ets_lifterlms_discord_client_secret = isset( $_POST['ets_lifterlms_discord_client_secret'] ) ? sanitize_text_field( trim( $_POST['ets_lifterlms_discord_client_secret'] ) ) : '';		
		$ets_lifterlms_discord_redirect_url = isset( $_POST['ets_lifterlms_discord_redirect_url'] ) ? sanitize_text_field( trim( $_POST['ets_lifterlms_discord_redirect_url'] ) ) : '';	
		$ets_lifterlms_discord_bot_token = isset( $_POST['ets_lifterlms_discord_bot_token'] ) ? sanitize_text_field( trim( $_POST['ets_lifterlms_discord_bot_token'] ) ) : '';		
		$ets_lifterlms_discord_server_id = isset( $_POST['ets_lifterlms_discord_server_id'] ) ? sanitize_text_field( trim( $_POST['ets_lifterlms_discord_server_id'] ) ) : '';
		
	    if ( isset( $_POST['submit'] ) ) {
			if ( wp_verify_nonce( $_POST['ets_lifterlms_discord_save_settings'], 'save_lifterlms_discord_settings' ) ) {
				
				if ( $ets_lifterlms_discord_client_id ) {
					update_option( 'ets_lifterlms_discord_client_id', $ets_lifterlms_discord_client_id );
				}

				if ( $ets_lifterlms_discord_client_secret ) {
					update_option( 'ets_lifterlms_discord_client_secret', $ets_lifterlms_discord_client_secret );
				}

				if ( $ets_lifterlms_discord_bot_token ) {
					update_option( 'ets_lifterlms_discord_bot_token', $ets_lifterlms_discord_bot_token );
				}

				if ( $ets_lifterlms_discord_redirect_url) {
					
					update_option( 'ets_lifterlms_discord_redirect_url', $ets_lifterlms_discord_redirect_url );
				}

				if ( $ets_lifterlms_discord_server_id ) {
					update_option( 'ets_lifterlms_discord_server_id', $ets_lifterlms_discord_server_id );
				}

				$message = 'Your settings are saved successfully.';
				if ( isset( $_SERVER['HTTP_REFERER'] ) ) {
					$pre_location = $_SERVER['HTTP_REFERER'] . '&save_settings_msg=' . $message . '#lifterlms_general_settings';
					wp_safe_redirect( $pre_location );
				}
		    }	
	    }
    }
}
