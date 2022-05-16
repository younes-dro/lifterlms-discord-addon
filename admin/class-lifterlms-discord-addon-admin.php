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
	 * Instance of Lifterlms_Discord_Addon_Public class
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      Lifterlms_Discord_Addon_Public
	 */
	private $lifterlms_discord_public_instance;

	/**
	 * Static property to define log file name
	 *
	 * @param None
	 * @return string $log_file_name
	 */
	public static $log_file_name = 'lifterlms_discord_api_logs.txt';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $lifterlms_discord_public_instance ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->lifterlms_discord_public_instance = $lifterlms_discord_public_instance;                

	}

	/*
		Adding child menu under top level lifterlms menu
	*/

	public function ets_lifterlms_add_admin_menu() {
		add_submenu_page(
			'lifterlms',
			_( 'Discord Settings' ),
			_( 'Discord Settings' ),
			'manage_options',
			'lifterlms-discord-addon',
			array( $this, 'ets_lifterlms_discord_view' ),
			999
		);
	}
	/*
		Details of page
	*/

	public function ets_lifterlms_discord_view() {
		if ( ! current_user_can( 'administrator' ) ) {
			return;
		}
		wp_enqueue_style( $this->plugin_name . 'skeletabs.css' );
		wp_enqueue_style( $this->plugin_name . 'select2.css' );
		wp_enqueue_style( $this->plugin_name );                
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'jquery-ui-draggable' );
		wp_enqueue_script( 'jquery-ui-droppable' );
		wp_enqueue_script( $this->plugin_name . 'select2.js' );
		wp_enqueue_script( $this->plugin_name . 'skeletabs.js' );
		wp_enqueue_script( $this->plugin_name );                
		require_once LIFTERLMS_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/lifterlms-discord-addon-admin-display.php';
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
		wp_register_style( $this->plugin_name . 'skeletabs.css', plugin_dir_url( __FILE__ ) . 'css/skeletabs.css', array(), $this->version, 'all' );
		wp_register_style( $this->plugin_name . 'select2.css', plugin_dir_url( __FILE__ ) . 'css/select2.min.css', array(), $this->version, 'all' );
		//wp_register_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/lifterlms-discord-admin.min.css', array(), $this->version, 'all' );
		wp_register_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/lifterlms-discord-addon-admin.css', array(), $this->version, 'all' );

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
		wp_register_script( $this->plugin_name . 'select2.js', plugin_dir_url( __FILE__ ) . 'js/select2.min.js', array( 'jquery' ), $this->version, false );

		wp_register_script( $this->plugin_name . 'skeletabs.js', plugin_dir_url( __FILE__ ) . 'js/skeletabs.js', array( 'jquery' ), $this->version, false );

		// /wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/lifterlms-discord-admin.min.js', array( 'jquery' ), $this->version, false );

		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/lifterlms-discord-addon-admin.js', array( 'jquery', 'wp-color-picker' ), $this->version, false );
		$script_params = array(
			'admin_ajax'                  => admin_url( 'admin-ajax.php' ),
			'permissions_const'           => LIFTERLMS_DISCORD_BOT_PERMISSIONS,
			'is_admin'                    => is_admin(),
			'ets_lifterlms_discord_nonce' => wp_create_nonce( 'ets-lifterlms-discord-ajax-nonce' ),
		);
		wp_localize_script( $this->plugin_name, 'ets_lifterlms_js_params', $script_params );
	}

	/**
	 * Save application details on Server
	 */

	public function ets_lifterlms_discord_save_application_details() {
		if ( ! current_user_can( 'administrator' ) ) {
			wp_send_json_error( 'You do not have sufficient rights', 403 );
			exit();
		}

		if ( wp_verify_nonce( $_POST['ets_lifterlms_discord_save_settings'], 'save_lifterlms_discord_settings' ) ) {

			$ets_lifterlms_discord_client_id        = isset( $_POST['ets_lifterlms_discord_client_id'] ) ? sanitize_text_field( trim( $_POST['ets_lifterlms_discord_client_id'] ) ) : '';
			$ets_lifterlms_discord_client_secret    = isset( $_POST['ets_lifterlms_discord_client_secret'] ) ? sanitize_text_field( trim( $_POST['ets_lifterlms_discord_client_secret'] ) ) : '';
			$ets_lifterlms_discord_redirect_page_id = isset( $_POST['ets_lifterlms_discord_redirect_page_id'] ) ? sanitize_text_field( trim( $_POST['ets_lifterlms_discord_redirect_page_id'] ) ) : '';
			$ets_lifterlms_discord_bot_token        = isset( $_POST['ets_lifterlms_discord_bot_token'] ) ? sanitize_text_field( trim( $_POST['ets_lifterlms_discord_bot_token'] ) ) : '';
			$ets_lifterlms_discord_server_id        = isset( $_POST['ets_lifterlms_discord_server_id'] ) ? sanitize_text_field( trim( $_POST['ets_lifterlms_discord_server_id'] ) ) : '';
			$ets_lifterlms_discord_redirect_url     = ets_get_lifterlms_discord_formated_discord_redirect_url( $ets_lifterlms_discord_redirect_page_id );
			$current_url                            = isset( $_POST['current_url'] ) ? sanitize_text_field( trim( $_POST['current_url'] ) ) : '';
			$ets_lifterlms_admin_redirect_url       = isset( $_POST['ets_lifterlms_admin_redirect_url'] ) ? sanitize_text_field( trim( $_POST['ets_lifterlms_admin_redirect_url'] ) ) : '';

			if ( $ets_lifterlms_admin_redirect_url ) {
				update_option( 'ets_lifterlms_admin_redirect_url', $ets_lifterlms_admin_redirect_url );
			}

			if ( $ets_lifterlms_discord_client_id ) {
				update_option( 'ets_lifterlms_discord_client_id', $ets_lifterlms_discord_client_id );
			}
			if ( $ets_lifterlms_discord_redirect_url ) {
				update_option( 'ets_lifterlms_discord_redirect_url', $ets_lifterlms_discord_redirect_url );
			}

			if ( $ets_lifterlms_discord_client_secret ) {
				update_option( 'ets_lifterlms_discord_client_secret', $ets_lifterlms_discord_client_secret );
			}

			if ( $ets_lifterlms_discord_bot_token ) {
				update_option( 'ets_lifterlms_discord_bot_token', $ets_lifterlms_discord_bot_token );
			}

			if ( $ets_lifterlms_discord_redirect_page_id ) {

				update_option( 'ets_lifterlms_discord_redirect_page_id', $ets_lifterlms_discord_redirect_page_id );
			}

			if ( $ets_lifterlms_discord_server_id ) {
				update_option( 'ets_lifterlms_discord_server_id', $ets_lifterlms_discord_server_id );
			}

			/**
			 *   return username from discord
			 */
			$bot_username = $this->ets_lifterlms_discord_get_bot_name( $ets_lifterlms_discord_bot_token );

			if ( $bot_username ) {
				update_option( 'ets_lifterlms_discord_bot_username', $bot_username );
			}

			$message = 'Your settings are saved successfully.';
			if ( isset( $current_url ) ) {
				$pre_location = $current_url . '&save_settings_msg=' . $message . '#lifterlms_general_settings';
				wp_safe_redirect( $pre_location );
			}
		}
	}

	private function ets_lifterlms_discord_get_bot_name( $bot_token ) {
		if ( ! current_user_can( 'administrator' ) ) {
			return;
		}

		$discord_cuser_api_url = LIFTERLMS_DISCORD_API_URL . 'users/@me';
		$param                 = array(
			'headers' => array(
				'Content-Type'  => 'application/x-www-form-urlencoded',
				'Authorization' => 'Bot ' . $bot_token,
			),

		);
		$bot_response = wp_remote_get( $discord_cuser_api_url, $param );
		$response_arr = json_decode( wp_remote_retrieve_body( $bot_response ), true );
		return $response_arr['username'];
	}

	/*
	Catch the Connect to Bot action from admin.
	*/
	public function ets_lifterlms_discord_action_connect_bot() {

		if ( isset( $_GET['action'] ) && $_GET['action'] == 'lifterlms-discord-connectToBot') {
			if ( ! current_user_can( 'administrator' ) ) {
				wp_send_json_error( 'You do not have sufficient rights', 403 );
				exit();
			}
			
			$discord_authorise_api_url = LIFTERLMS_DISCORD_API_URL . 'oauth2/authorize';
			$params                    = array(
				'client_id'            => sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_client_id' ) ) ),
				'permissions'          => LIFTERLMS_DISCORD_BOT_PERMISSIONS,
				'scope'                => 'bot',
				'guild_id'             => sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_server_id' ) ) ),
				'disable_guild_select' => 'true',
				'redirect_uri'         => sanitize_text_field( trim( get_option( 'ets_lifterlms_admin_redirect_url' ) ) ),
				'response_type'        => 'code',
			);

			$discord_authorise_api_url = LIFTERLMS_DISCORD_API_URL . 'oauth2/authorize?' . http_build_query( $params );
			wp_redirect( $discord_authorise_api_url, 302, get_site_url() );
			exit;
		}
	}

	/* 
	  Role-level-screen develop
	*/
	public function ets_lifterlms_discord_role_mapping() {
		if ( ! current_user_can( 'administrator' ) ) {
			wp_send_json_error( 'You do not have sufficient rights', 403 );
			exit();
		}
		$ets_discord_roles   = isset( $_POST['ets_lifterlms_discord_role_mapping'] ) ? sanitize_textarea_field( trim( $_POST['ets_lifterlms_discord_role_mapping'] ) ) : '';
		
		$ets_lifterlms_discord_default_role_id = isset( $_POST['defaultRole'] ) ? sanitize_textarea_field( trim( $_POST['defaultRole'] ) ) : '';

		$allow_none_member = isset( $_POST['allow_none_member'] ) ? sanitize_textarea_field( trim( $_POST['allow_none_member'] ) ) : '';

		$ets_discord_roles   = stripslashes( $ets_discord_roles );
		
		$current_url_role    = isset( $_POST['current_url_role'] ) ? sanitize_text_field( trim( $_POST['current_url_role'] ) ) : '';
		$save_mapping_status = update_option( 'ets_lifterlms_discord_role_mapping', $ets_discord_roles );
			
		if ( isset( $_POST['ets_lifterlms_discord_role_mappings_nonce'] ) && wp_verify_nonce( $_POST['ets_lifterlms_discord_role_mappings_nonce'], 'discord_role_mappings_nonce' ) ) {
			
			if ( ( $save_mapping_status || isset( $_POST['ets_lifterlms_discord_role_mapping'] ) ) && ! isset( $_POST['flush'] ) ) {
				
				if ( $ets_lifterlms_discord_default_role_id ) {
					update_option( 'ets_lifterlms_discord_default_role_id', $ets_lifterlms_discord_default_role_id );
				}
				
				if ( $allow_none_member ) {
					update_option( 'ets_lifterlms_allow_none_member', $allow_none_member );
				}
				
				
				$message = 'Your mappings are saved successfully.';
				if ( isset( $current_url_role ) ) {
					$pre_location = $current_url_role . '&save_settings_msg=' . $message . '#lifterlms_role_level';
					wp_safe_redirect( $pre_location );
				}
			}
			if ( isset( $_POST['flush'] ) ) {
				delete_option( 'ets_lifterlms_discord_role_mapping' );
				$message = ' Your settings are flushed successfully.';
				if ( isset( $_SERVER['HTTP_REFERER'] ) ) {
					$pre_location = $_SERVER['HTTP_REFERER'] . '&save_settings_msg=' . $message . '#lifterlms_role_level';
					wp_safe_redirect( $pre_location );
				}
			}
		}		
	}
	/**
	 *
	 * GET OBJECT REST API response
	 */
	public function ets_lifterlms_load_discord_roles() {
		if ( ! current_user_can( 'administrator' ) ) {
			wp_send_json_error( 'You do not have sufficient rights', 403 );
			exit();
		}
		// Check for nonce security.
		if ( ! wp_verify_nonce( $_POST['ets_lifterlms_discord_nonce'], 'ets-lifterlms-discord-ajax-nonce' ) ) {
			wp_send_json_error( 'You do not have sufficient rights', 403 );
			exit();
		}
		$user_id           = get_current_user_id();
		$server_id         = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_server_id' ) ) );
		$discord_bot_token = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_bot_token' ) ) );

		if ( $server_id && $discord_bot_token ) {
			$discod_server_roles_api = LIFTERLMS_DISCORD_API_URL . 'guilds/' . $server_id . '/roles';
			$guild_args              = array(
				'method'  => 'GET',
				'headers' => array(
					'Content-Type'  => 'application/json',
					'Authorization' => 'Bot ' . $discord_bot_token,
				),
			);

			$guild_response          = wp_remote_post( $discod_server_roles_api, $guild_args );
			$response_arr = json_decode( wp_remote_retrieve_body( $guild_response ), true );

			if ( is_array( $response_arr ) && ! empty( $response_arr ) ) {
				if ( array_key_exists( 'code', $response_arr ) || array_key_exists( 'error', $response_arr ) ) {
					ets_lifterlms_write_api_response_logs( $response_arr, $user_id, debug_backtrace()[0] );
				} else {
					$response_arr['previous_mapping'] = get_option( 'ets_lifterlms_discord_role_mapping' );

					$discord_roles = array();
					foreach ( $response_arr as $key => $value ) {
						$isbot = false;
						if ( is_array( $value ) ) {
							if ( array_key_exists( 'tags', $value ) ) {
								if ( array_key_exists( 'bot_id', $value['tags'] ) ) {
									$isbot = true;
								}
							}
						}
						if ( 'previous_mapping' !== $key && false === $isbot && isset( $value['name'] ) && $value['name'] != '@everyone' ) {
							$discord_roles[ $value['id'] ] = $value['name'];
							$discord_roles_color[ $value['id'] ] = $value['color'];                                                        
						}
					}
					update_option( 'ets_lifterlms_discord_all_roles', serialize( $discord_roles ) );
					update_option( 'ets_lifterlms_discord_roles_color', serialize( $discord_roles_color ) );                                                                                
				}
			}
			/*
			   $response_arr = json_decode( '[{"id": "697464405281210408", "name": "@everyone", "permissions": 0, "position": 0, "color": 0, "hoist": false, "managed": false, "mentionable": false, "icon": null, "unicode_emoji": null, "permissions_new": "1071594340352"}, {"id": "793091232107986946", "name": "MathBot", "permissions": 117824, "position": 19, "color": 0, "hoist": true, "managed": true, "mentionable": true, "icon": null, "unicode_emoji": null, "tags": {"bot_id": "134073775925886976"}, "permissions_new": "6442568768"}, {"id": "800663607074750475", "name": "spectator", "permissions": 254921793, "position": 10, "color": 3447003, "hoist": true, "managed": false, "mentionable": true, "icon": null, "unicode_emoji": null, "permissions_new": "6697372737"}, {"id": "801000713366667314", "name": "contentator", "permissions": 120704065, "position": 11, "color": 15844367, "hoist": true, "managed": false, "mentionable": true, "icon": null, "unicode_emoji": null, "permissions_new": "6563155009"}, {"id": "857193694129684490", "name": "new role", "permissions": 0, "position": 9, "color": 15277667, "hoist": false, "managed": false, "mentionable": false, "icon": null, "unicode_emoji": null, "permissions_new": "109521666048"}, {"id": "857511112702558250", "name": "New Role", "permissions": 0, "position": 8, "color": 0, "hoist": false, "managed": false, "mentionable": false, "icon": null, "unicode_emoji": null, "permissions_new": "109521666048"}, {"id": "885134685007675402", "name": "Trial Memberpress", "permissions": 0, "position": 7, "color": 3066993, "hoist": false, "managed": false, "mentionable": false, "icon": null, "unicode_emoji": null, "permissions_new": "521838526464"}, {"id": "885139683896623125", "name": "new role", "permissions": 0, "position": 6, "color": 0, "hoist": false, "managed": false, "mentionable": false, "icon": null, "unicode_emoji": null, "permissions_new": "521838526464"}, {"id": "920938521102008361", "name": "ultimate-member", "permissions": 8, "position": 17, "color": 0, "hoist": false, "managed": true, "mentionable": false, "icon": null, "unicode_emoji": null, "tags": {"bot_id": "920936082118443049"}, "permissions_new": "8"}, {"id": "923587208554876999", "name": "Restrictcontentpro discord addon", "permissions": 8, "position": 18, "color": 0, "hoist": false, "managed": true, "mentionable": false, "icon": null, "unicode_emoji": null, "tags": {"bot_id": "923586881113960458"}, "permissions_new": "8"}, {"id": "928267478054879233", "name": "wc-discord", "permissions": 8, "position": 16, "color": 0, "hoist": false, "managed": true, "mentionable": false, "icon": null, "unicode_emoji": null, "tags": {"bot_id": "928267171073785856"}, "permissions_new": "8"}, {"id": "935062985620197436", "name": "Gold Role", "permissions": 0, "position": 5, "color": 16766720, "hoist": false, "managed": false, "mentionable": false, "icon": null, "unicode_emoji": null, "permissions_new": "0"}, {"id": "938080152565481514", "name": "Zapier", "permissions": 2146958591, "position": 4, "color": 0, "hoist": false, "managed": true, "mentionable": false, "icon": null, "unicode_emoji": null, "tags": {"bot_id": "368105370532577280"}, "permissions_new": "2146958591"}, {"id": "943033610615816235", "name": "MEE6", "permissions": 1945627743, "position": 3, "color": 0, "hoist": false, "managed": true, "mentionable": false, "icon": null, "unicode_emoji": null, "tags": {"bot_id": "159985870458322944"}, "permissions_new": "1945627743"}, {"id": "943765597659992087", "name": "Excuseme_IamNext", "permissions": 8, "position": 2, "color": 0, "hoist": false, "managed": true, "mentionable": false, "icon": null, "unicode_emoji": null, "tags": {"bot_id": "943553617003175957"}, "permissions_new": "8"}, {"id": "945186904972857356", "name": "ets-lifter-lms", "permissions": 8, "position": 1, "color": 0, "hoist": false, "managed": true, "mentionable": false, "icon": null, "unicode_emoji": null, "tags": {"bot_id": "945186562755424266"}, "permissions_new": "8"}, {"id": "946788807649394761", "name": "NewPluginInstall", "permissions": 8, "position": 14, "color": 0, "hoist": false, "managed": true, "mentionable": false, "icon": null, "unicode_emoji": null, "tags": {"bot_id": "863801582851325983"}, "permissions_new": "8"}, {"id": "950700255601627189", "name": "wp-learndash", "permissions": 8, "position": 15, "color": 0, "hoist": false, "managed": true, "mentionable": false, "icon": null, "unicode_emoji": null, "tags": {"bot_id": "923202091722358795"}, "permissions_new": "8"}, {"id": "950756944036106243", "name": "MemberPress Discord", "permissions": 8, "position": 12, "color": 0, "hoist": false, "managed": true, "mentionable": false, "icon": null, "unicode_emoji": null, "tags": {"bot_id": "865181205379940373"}, "permissions_new": "8"}, {"id": "951003472956895285", "name": "wp-learnpress", "permissions": 8, "position": 13, "color": 0, "hoist": false, "managed": true, "mentionable": false, "icon": null, "unicode_emoji": null, "tags": {"bot_id": "940488526963802183"}, "permissions_new": "8"}]' );
			*/
			return wp_send_json( $response_arr );
		}
	}

	public function ets_lifterlms_discord_update_redirect_url(  ) {
           
		if ( ! current_user_can( 'administrator' ) ) {
			wp_send_json_error( 'You do not have sufficient rights', 403 );
			exit();
		}
		// Check for nonce security
		if ( ! wp_verify_nonce( $_POST['ets_lifterlms_discord_nonce'], 'ets-lifterlms-discord-ajax-nonce' ) ) {
			wp_send_json_error( 'You do not have sufficient rights', 403 );
			exit();
		}

		$page_id = $_POST['ets_lifterlms_page_id'];
		if( isset( $page_id ) ){
			$formated_discord_redirect_url = ets_get_lifterlms_discord_formated_discord_redirect_url( $page_id );
			update_option( 'ets_lifterlms_discord_redirect_page_id' ,$page_id );
			update_option( 'ets_lifterlms_discord_redirect_url' ,$formated_discord_redirect_url );
			$res = array(
				'formated_discord_redirect_url' => $formated_discord_redirect_url,
			);
			wp_send_json( $res );
		
		}
		exit();
                
	}
        
	/**
	 * Save advanced settings
	 *
	 * @param NONE
	 * @return NONE
	 */        
	public function ets_lifterlms_discord_save_advance_settings() {

		if ( ! current_user_can( 'administrator' ) || ! wp_verify_nonce( $_POST['ets_lifterlms_discord_advance_settings_nonce'], 'lifterlms_discord_advance_settings_nonce' ) ) {
			wp_send_json_error( 'You do not have sufficient rights', 403 );
			exit();
		}

			$ets_lifterlms_discord_welcome_message = isset( $_POST['ets_lifterlms_discord_welcome_message'] ) ? sanitize_textarea_field( trim( $_POST['ets_lifterlms_discord_welcome_message'] ) ) : '';
			$ets_lifterlms_discord_quiz_complete_message = isset( $_POST['ets_lifterlms_discord_quiz_complete_message'] ) ? sanitize_textarea_field( trim( $_POST['ets_lifterlms_discord_quiz_complete_message'] ) ) : '';                        
			$retry_failed_api                           = isset( $_POST['retry_failed_api'] ) ? sanitize_textarea_field( trim( $_POST['retry_failed_api'] ) ) : '';
			$kick_upon_disconnect                       = isset( $_POST['kick_upon_disconnect'] ) ? sanitize_textarea_field( trim( $_POST['kick_upon_disconnect'] ) ) : '';                        
			$retry_api_count                            = isset( $_POST['ets_lifterlms_retry_api_count'] ) ? sanitize_textarea_field( trim( $_POST['ets_lifterlms_retry_api_count'] ) ) : '';
			$set_job_cnrc                               = isset( $_POST['set_job_cnrc'] ) ? sanitize_textarea_field( trim( $_POST['set_job_cnrc'] ) ) : '';
			$set_job_q_batch_size                       = isset( $_POST['set_job_q_batch_size'] ) ? sanitize_textarea_field( trim( $_POST['set_job_q_batch_size'] ) ) : '';
			$log_api_res                                = isset( $_POST['log_api_res'] ) ? sanitize_textarea_field( trim( $_POST['log_api_res'] ) ) : '';
			$ets_current_url = sanitize_text_field( trim( $_POST['current_url'] ) ) ;                                                                

		if ( isset( $_POST['ets_lifterlms_discord_advance_settings_nonce'] ) && wp_verify_nonce( $_POST['ets_lifterlms_discord_advance_settings_nonce'], 'lifterlms_discord_advance_settings_nonce' ) ) {
			if ( isset( $_POST['adv_submit'] ) ) {

				if ( isset( $_POST['ets_lifterlms_discord_send_welcome_dm'] ) ) {
					update_option( 'ets_lifterlms_discord_send_welcome_dm', true );
				} else {
					update_option( 'ets_lifterlms_discord_send_welcome_dm', false );
				}
				if ( isset( $_POST['ets_lifterlms_discord_welcome_message'] ) && $_POST['ets_lifterlms_discord_welcome_message'] != '' ) {
					update_option( 'ets_lifterlms_discord_welcome_message', $ets_lifterlms_discord_welcome_message );
				} else {
					update_option( 'ets_lifterlms_discord_welcome_message', '' );
				}
				if ( isset( $_POST['ets_lifterlms_discord_send_quiz_complete_dm'] ) ) {
					update_option( 'ets_lifterlms_discord_send_quiz_complete_dm', true );
				} else {
					update_option( 'ets_lifterlms_discord_send_quiz_complete_dm', false );
				}
				if ( isset( $_POST['ets_lifterlms_discord_quiz_complete_message'] ) && $_POST['ets_lifterlms_discord_quiz_complete_message'] != '' ) {
					update_option( 'ets_lifterlms_discord_quiz_complete_message', $ets_lifterlms_discord_quiz_complete_message );
				} else {
					update_option( 'ets_lifterlms_discord_quiz_complete_message', '' );
				}                                
				if ( isset( $_POST['retry_failed_api'] ) ) {
					update_option( 'ets_lifterlms_discord_retry_failed_api', true );
				} else {
					update_option( 'ets_lifterlms_discord_retry_failed_api', false );
				}
				if ( isset( $_POST['kick_upon_disconnect'] ) ) {
					update_option( 'ets_lifterlms_discord_kick_upon_disconnect', true );
				} else {
					update_option( 'ets_lifterlms_discord_kick_upon_disconnect', false );
				}                                
				if ( isset( $_POST['ets_lifterlms_retry_api_count'] ) ) {
					if ( $retry_api_count < 1 ) {
						update_option( 'ets_lifterlms_discord_retry_api_count', 1 );
					} else {
						update_option( 'ets_lifterlms_discord_retry_api_count', $retry_api_count );
					}
				}
				if ( isset( $_POST['set_job_cnrc'] ) ) {
					if ( $set_job_cnrc < 1 ) {
						update_option( 'ets_lifterlms_discord_job_queue_concurrency', 1 );
					} else {
						update_option( 'ets_lifterlms_discord_job_queue_concurrency', $set_job_cnrc );
					}
				}
				if ( isset( $_POST['set_job_q_batch_size'] ) ) {
					if ( $set_job_q_batch_size < 1 ) {
						update_option( 'ets_lifterlms_discord_job_queue_batch_size', 1 );
					} else {
						update_option( 'ets_lifterlms_discord_job_queue_batch_size', $set_job_q_batch_size );
					}
				}
				if ( isset( $_POST['log_api_res'] ) ) {
					update_option( 'ets_lifterlms_discord_log_api_response', true );
				} else {
					update_option( 'ets_lifterlms_discord_log_api_response', false );
				}

				$message = 'Your settings are saved successfully.';
				$pre_location = $ets_current_url . '&save_settings_msg=' . $message . '#lifterlms_discord_advanced';
				wp_safe_redirect( $pre_location );
				
			}
		}

	}
	/**
	 * Save appearance settings
	 *
	 * @param NONE
	 * @return NONE
	 */        
	public function ets_lifterlms_discord_save_appearance_settings() {

		if ( ! current_user_can( 'administrator' ) || ! wp_verify_nonce( $_POST['ets_lifterlms_discord_appearance_settings_nonce'], 'lifterlms_discord_appearance_settings_nonce' ) ) {
			wp_send_json_error( 'You do not have sufficient rights', 403 );
			exit();
		}  
		$ets_lifterlms_discord_connect_button_bg_color = isset( $_POST['ets_lifterlms_discord_connect_button_bg_color'] ) ? sanitize_textarea_field( trim( $_POST['ets_lifterlms_discord_connect_button_bg_color'] ) ) : '';
		$ets_lifterlms_discord_disconnect_button_bg_color = isset( $_POST['ets_lifterlms_discord_disconnect_button_bg_color'] ) ? sanitize_textarea_field( trim( $_POST['ets_lifterlms_discord_disconnect_button_bg_color'] ) ) : '';                
		$ets_lifterlms_discord_loggedin_button_text = isset( $_POST['ets_lifterlms_discord_loggedin_button_text'] ) ? sanitize_textarea_field( trim( $_POST['ets_lifterlms_discord_loggedin_button_text'] ) ) : '';                                
		$ets_lifterlms_discord_non_login_button_text = isset( $_POST['ets_lifterlms_discord_non_login_button_text'] ) ? sanitize_textarea_field( trim( $_POST['ets_lifterlms_discord_non_login_button_text'] ) ) : '';                                                
		$ets_lifterlms_discord_disconnect_button_text = isset( $_POST['ets_lifterlms_discord_disconnect_button_text'] ) ? sanitize_textarea_field( trim( $_POST['ets_lifterlms_discord_disconnect_button_text'] ) ) : '';                                                                
		$ets_current_url = sanitize_text_field( trim( $_POST['current_url'] ) ) ;                                                        

		if ( isset( $_POST['ets_lifterlms_discord_appearance_settings_nonce'] ) && wp_verify_nonce( $_POST['ets_lifterlms_discord_appearance_settings_nonce'], 'lifterlms_discord_appearance_settings_nonce' ) ) {
			if ( isset( $_POST['appearance_submit'] ) ) {

				if ( isset( $_POST['ets_lifterlms_discord_connect_button_bg_color'] ) ) {
					update_option( 'ets_lifterlms_discord_connect_button_bg_color', $ets_lifterlms_discord_connect_button_bg_color );
				} else {
					update_option( 'ets_lifterlms_discord_connect_button_bg_color', '' );
				}
				if ( isset( $_POST['ets_lifterlms_discord_disconnect_button_bg_color'] ) ) {
					update_option( 'ets_lifterlms_discord_disconnect_button_bg_color', $ets_lifterlms_discord_disconnect_button_bg_color );
				} else {
					update_option( 'ets_lifterlms_discord_disconnect_button_bg_color', '' );
				}                                
				if ( isset( $_POST['ets_lifterlms_discord_loggedin_button_text'] ) ) {
					update_option( 'ets_lifterlms_discord_loggedin_button_text', $ets_lifterlms_discord_loggedin_button_text );
				} else {
					update_option( 'ets_lifterlms_discord_loggedin_button_text', '' );
				}
				if ( isset( $_POST['ets_lifterlms_discord_non_login_button_text'] ) ) {
					update_option( 'ets_lifterlms_discord_non_login_button_text', $ets_lifterlms_discord_non_login_button_text );
				} else {
					update_option( 'ets_lifterlms_discord_non_login_button_text', '' );
				} 
				if ( isset( $_POST['ets_lifterlms_discord_disconnect_button_text'] ) ) {
					update_option( 'ets_lifterlms_discord_disconnect_button_text', $ets_lifterlms_discord_disconnect_button_text );
				} else {
					update_option( 'ets_lifterlms_discord_disconnect_button_text', '' );
				}                                

				$message = 'Your settings are saved successfully.';

				$pre_location = $ets_current_url . '&save_settings_msg=' . $message . '#lifterlms_discord_appearance';
				wp_safe_redirect( $pre_location );

			}
		}

	}

	/**
	 * Admin assigns a course to student
	 *
	 * @param int $user_id WP User ID.
	 * @param int $course_id WP Post ID of the course or membership. 
	 * @return NONE
	 */        
	public function ets_lifterlms_discord_admin_enroll_user_course( $user_id, $course_id ) {
            
		$this->lifterlms_discord_public_instance->ets_lifterlms_discord_update_user_course_enrollment( $user_id, $course_id );           
        }

	/**
	 * Enrollment has been deleted
	 *
	 * @param int $user_id WP User ID.
	 * @param int $course_id WP Post ID of the course or membership.
	 * @param string $enrollment_trigger The enrollment trigger..  
	 * @return NONE
	 */        
	public function ets_lifterlms_discord_admin_delete_user_enrollment_course( $user_id, $course_id, $enrollment_trigger ) {
            
		$this->lifterlms_discord_public_instance->ets_lifterlms_discord_update_user_course_enrollment( $user_id, $course_id , true );           
        }

           
                

}  
