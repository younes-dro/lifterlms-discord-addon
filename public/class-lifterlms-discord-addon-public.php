<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.expresstechsoftwares.com
 * @since      1.0.0
 *
 * @package    Lifterlms_Discord_Addon
 * @subpackage Lifterlms_Discord_Addon/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Lifterlms_Discord_Addon
 * @subpackage Lifterlms_Discord_Addon/public
 * @author     ExpressTech Softwares Solutions Pvt Ltd <contact@expresstechsoftwares.com>
 */
class Lifterlms_Discord_Addon_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/lifterlms-discord-addon-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/lifterlms-discord-addon-public.js', array( 'jquery' ), $this->version, false );

	}

	// public function ets_lifterlms_discord_discord_api_callback() {
	// 	if ( is_user_logged_in() ) {
			
	// 		if ( isset( $_GET['action'] ) && 'lifterlms-discord-login' === $_GET['action'] ) {
	// 			$params                    = array(
	// 				'client_id'     => sanitize_text_field( get_option( 'ets_lifterlms_discord_client_id' ) ),
	// 				'redirect_uri'  => sanitize_text_field( get_option( 'ets_lifterlms_admin_redirect_url' ) ),
	// 				'response_type' => 'code',
	// 				'scope'         => 'identify email connections guilds guilds.join messages.read',
	// 			);
	// 			$discord_authorise_api_url = LIFTERLMS_DISCORD_API_URL . 'oauth2/authorize?' . http_build_query( $params );
 
	// 			wp_redirect( $discord_authorise_api_url, 302, get_site_url() );
	// 			exit;
	// 		}
	// 		if ( isset( $_GET['action'] ) && 'discord-connectToBot' === $_GET['action'] ) {
	// 			$params                    = array(
	// 				'client_id'   => sanitize_text_field( get_option( 'ets_lifterlms_discord_client_id' ) ),
	// 				'permissions' => LIFTERLMS_DISCORD_BOT_PERMISSIONS,
	// 				'scope'       => 'bot',
	// 				'guild_id'    => sanitize_text_field( get_option( 'ets_lifterlms_discord_server_id' ) ),
	// 			);
	// 			$discord_authorise_api_url = LIFTERLMS_DISCORD_API_URL . 'oauth2/authorize?' . http_build_query( $params );

	// 			wp_redirect( $discord_authorise_api_url, 302, get_site_url() );
	// 			exit;
	// 		}
	// 	}
	// }


		/**
	 * Add discord connection buttons.
	 *
	 * @since    1.0.0
	 */
	public function ets_lifterlms_discord_add_connect_button() {
		if ( ! is_user_logged_in() ) {
			wp_send_json_error( 'Unauthorized user', 401 );
			exit();
		}
		wp_enqueue_style($this->plugin_name . 'public_css');
		wp_enqueue_style($this->plugin_name . 'font_awesome_css');
		wp_enqueue_script($this->plugin_name . 'public_js');
		$user_id                              = sanitize_text_field( trim( get_current_user_id() ) );
		$access_token                         = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_access_token', true ) ) );
		$allow_none_member                    = sanitize_text_field( trim( get_option( 'ets_lifterlms_allow_none_member' ) ) );
		$default_role                         = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_default_role_id' ) ) );
		$ets_lifterlms_discord_role_mapping = json_decode( get_option( 'ets_lifterlms_discord_role_mapping' ), true );
		$all_roles                            = json_decode( get_option( 'ets_lifterlms_discord_all_roles' ), true );
		$mapped_role_names                    = array();
       
		
		
		//print_r($all_roles);

	}

		/**
	 * Save plugin general settings.
	 *
	 * @since    1.0.0
	 */
	/*public function ets_memberpress_discord_role_mapping() {
		if ( ! current_user_can( 'administrator' ) ) {
			wp_send_json_error( 'You do not have sufficient rights', 403 );
			exit();
		}

		$ets_discord_roles = isset( $_POST['ets_memberpress_discord_role_mapping'] ) ? sanitize_textarea_field( trim( $_POST['ets_memberpress_discord_role_mapping'] ) ) : '';

		$ets_memberpress_discord_default_role_id = isset( $_POST['defaultRole'] ) ? sanitize_textarea_field( trim( $_POST['defaultRole'] ) ) : '';

		$allow_none_member = isset( $_POST['allow_none_member'] ) ? sanitize_textarea_field( trim( $_POST['allow_none_member'] ) ) : '';

		$ets_discord_roles   = stripslashes( $ets_discord_roles );
		$save_mapping_status = update_option( 'ets_memberpress_discord_role_mapping', $ets_discord_roles );
		
		if ( isset( $_POST['ets_memberpress_discord_role_mappings_nonce'] ) && wp_verify_nonce( $_POST['ets_memberpress_discord_role_mappings_nonce'], 'discord_role_mappings_nonce' ) ) {
			
			if ( ( $save_mapping_status || isset( $_POST['ets_memberpress_discord_role_mapping'] ) ) && ! isset( $_POST['flush'] ) ) {
				
				if ( $ets_memberpress_discord_default_role_id ) {
					update_option( 'ets_memberpress_discord_default_role_id', $ets_memberpress_discord_default_role_id );
				}

				if ( $allow_none_member ) {
					update_option( 'ets_memberpress_allow_none_member', $allow_none_member );
				}

				$message = 'Your mappings are saved successfully.';
				if ( isset( $_SERVER['HTTP_REFERER'] ) ) {
					$pre_location = $_SERVER['HTTP_REFERER'] . '&save_settings_msg=' . $message . '#mepr_role_mapping';
					wp_safe_redirect( $pre_location );
				}
			}
			if ( isset( $_POST['flush'] ) ) {
				delete_option( 'ets_memberpress_discord_role_mapping' );
				delete_option( 'ets_memberpress_discord_default_role_id' );
				delete_option( 'ets_memberpress_allow_none_member' );
				$message = ' Your settings flushed successfully.';
				if ( isset( $_SERVER['HTTP_REFERER'] ) ) {
					$pre_location = $_SERVER['HTTP_REFERER'] . '&save_settings_msg=' . $message . '#mepr_role_mapping';
					wp_safe_redirect( $pre_location );
				}
			}
		}
	}
*/



	

}
