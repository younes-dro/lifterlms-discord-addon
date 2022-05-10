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
		wp_enqueue_style( $this->plugin_name . 'public_css', plugin_dir_url( __FILE__ ) . 'css/lifterlms-discord-public.min.css', array(), $this->version, 'all' );
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
		$script_params = array(
			'admin_ajax'                  => admin_url( 'admin-ajax.php' ),
			'permissions_const'           => LIFTERLMS_DISCORD_BOT_PERMISSIONS,
			'ets_lifterlms_discord_nonce' => wp_create_nonce( 'ets-lifterlms-ajax-nonce' ),
		);
		wp_localize_script( $this->plugin_name, 'etsLifterlmspublicParams', $script_params );
	}

		/**
	 * Add discord connection buttons.
	 *
	 * @since    1.0.0
	 */
	public function ets_lifterlms_discord_add_connect_button() {
		
		$user_id                              = sanitize_text_field( get_current_user_id() );
		$access_token                         = sanitize_text_field( get_user_meta( $user_id, 'ets_lifterlms_discord_access_token', true ) );
		$allow_none_member                    = sanitize_text_field( get_option( 'ets_lifterlms_allow_none_member' ) );
		$default_role                         = sanitize_text_field( get_option( 'ets_lifterlms_discord_default_role_id' ) );
		$ets_lifterlms_discord_role_mapping   = json_decode( get_option( 'ets_lifterlms_discord_role_mapping' ), true );
		$all_roles                            = json_decode( get_option( 'ets_lifterlms_discord_all_roles' ), true );
		$mapped_role_names                    = array();
        

			if ( $access_token ) {
				?>
				<label class="ets-connection-lbl">
					<?php echo __( 'Discord connection', 'lifterlms-discord-addon' ); ?>
				</label>
				<a href="#" class="ets-btn btn-disconnect" id="disconnect-discord" data-user-id="<?php echo esc_attr( $user_id ); ?>"><?php echo __( 'Disconnect From Discord ', 'lifterlms-discord-addon' ); ?><i class='fab fa-discord'></i></a>
				<span class="ets-spinner"></span>
				<?php
			} else {
				?>
				<label class="ets-connection-lbl"><br>
					<?php echo __( 'Discord connection', 'lifterlms-discord-addon' ); ?>
				</label><br>
				
				<a href="?action=lifterlms-discord-login" class="btn-connect ets-btn" ><?php echo __( 'Connect To Discord', 'lifterlms-discord-addon' ); ?> <i class='fab fa-discord'></i></a>
				
				<?php
			}
		
	}

	/**
	 *  initialize discord authentication.
	 *
	 */

	public function ets_lifterlms_discord_login() {
		if ( is_user_logged_in() ) {
			$user_id = get_current_user_id();
			if ( isset( $_GET['action'] ) && $_GET['action'] == 'lifterlms-discord-login' ) {
				$params                    = array(
					'client_id'     => sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_client_id' ) ) ),
					'redirect_uri'  => sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_redirect_url' ) ) ),
					'response_type' => 'code',
					'scope'         => 'identify email connections guilds guilds.join',
				);
				$discord_authorise_api_url = LIFTERLMS_DISCORD_API_URL . 'oauth2/authorize?' . http_build_query( $params );

				wp_redirect( $discord_authorise_api_url, 302, get_site_url() );
				exit;
			}

			if ( isset( $_GET['code'] ) && isset( $_GET['via'] ) && $_GET['via'] == 'lifterlms-discord' ) {
				$code     = sanitize_text_field( trim( $_GET['code'] ) );
				$response = $this->ets_lifterlms_discord_auth_token( $code, $user_id );

				if ( ! empty( $response ) && ! is_wp_error( $response ) ) {
					$res_body              = json_decode( wp_remote_retrieve_body( $response ), true );

					if ( is_array( $res_body ) ) {

						if ( array_key_exists( 'access_token', $res_body ) ) {

							$access_token = sanitize_text_field( trim( $res_body['access_token'] ) );
							update_user_meta( $user_id, '_ets_lifterlms_discord_access_token', $access_token );
							if ( array_key_exists( 'refresh_token', $res_body ) ) {
								$refresh_token = sanitize_text_field( trim( $res_body['refresh_token'] ) );
								update_user_meta( $user_id, '_ets_lifterlms_discord_refresh_token', $refresh_token );
							}
							if ( array_key_exists( 'expires_in', $res_body ) ) {
								$expires_in = $res_body['expires_in'];
								$date       = new DateTime();
								$date->add( DateInterval::createFromDateString( '' . $expires_in . ' seconds' ) );
								$token_expiry_time = $date->getTimestamp();
								update_user_meta( $user_id, '_ets_lifterlms_discord_expires_in', $token_expiry_time );
							}
							$user_body = $this->get_discord_current_user( $access_token );

							if ( is_array( $user_body ) && array_key_exists( 'discriminator', $user_body ) ) {
								$discord_user_number           = $user_body['discriminator'];
								$discord_user_name             = $user_body['username'];
								$discord_user_name_with_number = $discord_user_name . '#' . $discord_user_number;
								update_user_meta( $user_id, '_ets_lifterlms_discord_username', $discord_user_name_with_number );
							}
							if ( is_array( $user_body ) && array_key_exists( 'id', $user_body ) ) {
								$_ets_lifterlms_discord_user_id = sanitize_text_field( trim( $user_body['id'] ) );
//								if ( $discord_exist_user_id === $_ets_lifterlms_discord_user_id ) {
//									$courses = map_deep( ets_lifterlms_discord_get_student_courses_id( $user_id ), 'sanitize_text_field' );
//									if ( is_array( $courses ) ) {
//										foreach ( $courses as $course_id ) {
//											$_ets_lifterlms_discord_role_id = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_role_id_for_' . $course_id, true ) ) );
//											if ( ! empty( $_ets_lifterlms_discord_role_id ) && $_ets_lifterlms_discord_role_id != 'none' ) {
//												$this->delete_discord_role( $user_id, $_ets_lifterlms_discord_role_id );
//											}
//										}
//									}
//								}
								update_user_meta( $user_id, '_ets_lifterlms_discord_user_id', $_ets_lifterlms_discord_user_id );
								$this->add_discord_member_in_guild( $_ets_lifterlms_discord_user_id, $user_id, $access_token );
							}
						} 
					}
				}
			}                    
		}            

}

     /**
	 *  Responce/auth_token
	 *
	 */
	public function ets_lifterlms_discord_auth_token( $code, $user_id ) {
	
                
		$response              = '';
		$refresh_token         = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_refresh_token', true ) ) );
		$token_expiry_time     = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_expires_in', true ) ) );
		$discord_token_api_url = LIFTERLMS_DISCORD_API_URL . 'oauth2/token';
		if ( $refresh_token ) {
			$date              = new DateTime();
			$current_timestamp = $date->getTimestamp();
			if ( $current_timestamp > $token_expiry_time ) {
				$args     = array(
					'method'  => 'POST',
					'headers' => array(
						'Content-Type' => 'application/x-www-form-urlencoded',
					),
					'body'    => array(
						'client_id'     => sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_client_id' ) ) ),
						'client_secret' => sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_client_secret' ) ) ),
						'grant_type'    => 'refresh_token',
						'refresh_token' => $refresh_token,
						'redirect_uri'  => sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_redirect_url' ) ) ),
						'scope'         => LIFTERLMS_DISCORD_OAUTH_SCOPES,
					),
				);
				$response = wp_remote_post( $discord_token_api_url, $args );
				//ets_lifterlms_discord_log_api_response( $user_id, $discord_token_api_url, $args, $response );
				//if ( ets_lifterlms_discord_check_api_errors( $response ) ) {
				//	$response_arr = json_decode( wp_remote_retrieve_body( $response ), true );
				//	LIFTERLMS_Discord_Add_On_Logs::write_api_response_logs( $response_arr, $user_id, debug_backtrace()[0] );
				//}
			}
		} else {
			$args     = array(
				'method'  => 'POST',
				'headers' => array(
					'Content-Type' => 'application/x-www-form-urlencoded',
				),
				'body'    => array(
					'client_id'     => sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_client_id' ) ) ),
					'client_secret' => sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_client_secret' ) ) ),
					'grant_type'    => 'authorization_code',
					'code'          => $code,
					'redirect_uri'  => sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_redirect_url' ) ) ),
					'scope'         => LIFTERLMS_DISCORD_OAUTH_SCOPES,
				),
			);
			$response = wp_remote_post( $discord_token_api_url, $args );
			//ets_lifterlms_discord_log_api_response( $user_id, $discord_token_api_url, $args, $response );
			//if ( ets_lifterlms_discord_check_api_errors( $response ) ) {
			//	$response_arr = json_decode( wp_remote_retrieve_body( $response ), true );
			//	LIFTERLMS_Discord_Add_On_Logs::write_api_response_logs( $response_arr, $user_id, debug_backtrace()[0] );
			//}
		}
		return $response;                
	}

	/**
	 * Add new member into discord guild
	 *
	 * @param INT    $_ets_lifterlms_discord_user_id
	 * @param INT    $user_id
	 * @param STRING $access_token
	 * @return NONE
	 */
	public function add_discord_member_in_guild( $_ets_lifterlms_discord_user_id, $user_id, $access_token ) {
//		if ( ! is_user_logged_in() ) {
//			wp_send_json_error( 'Unauthorized user', 401 );
//			exit();
//		}
		//$enrolled_courses = map_deep( ets_lifterlms_discord_get_student_courses_id( $user_id ), 'sanitize_text_field' );
		//if ( $enrolled_courses !== null ) {
			// It is possible that we may exhaust API rate limit while adding members to guild, so handling off the job to queue.
			as_schedule_single_action( ets_lifterlms_discord_get_random_timestamp( ets_lifterlms_discord_get_highest_last_attempt_timestamp() ), 'ets_lifterlms_discord_as_handle_add_member_to_guild', array( $_ets_lifterlms_discord_user_id, $user_id, $access_token ), LIFTERLMS_DISCORD_AS_GROUP_NAME );
		///}
	}

	/**
	 * Method to add new members to discord guild.
	 *
	 * @param INT    $_ets_lifterlms_discord_user_id
	 * @param INT    $user_id
	 * @param STRING $access_token
	 * @return NONE
	 */
	public function ets_lifterlms_discord_as_handler_add_member_to_guild( $_ets_lifterlms_discord_user_id, $user_id, $access_token ) {
		// Since we using a queue to delay the API call, there may be a condition when a member is delete from DB. so put a check.
		if ( get_userdata( $user_id ) === false ) {
			return;
		}
		$guild_id                           = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_server_id' ) ) );
		$discord_bot_token                  = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_bot_token' ) ) );
		$default_role                       = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_default_role_id' ) ) );
		$ets_lifterlms_discord_role_mapping = json_decode( get_option( 'ets_lifterlms_discord_role_mapping' ), true );
		$discord_role                       = '';
		$discord_roles                      = array();
		//$courses                            = map_deep( ets_lifterlms_discord_get_student_courses_id( $user_id ), 'sanitize_text_field' );

		$ets_lifterlms_discord_send_welcome_dm = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_send_welcome_dm' ) ) );
//		if ( is_array( $courses ) ) {
//			foreach ( $courses as $course_id ) {
//
//				if ( is_array( $ets_lifterlms_discord_role_mapping ) && array_key_exists( 'learndash_course_id_' . $course_id, $ets_lifterlms_discord_role_mapping ) ) {
//					$discord_role = sanitize_text_field( trim( $ets_lifterlms_discord_role_mapping[ 'learndash_course_id_' . $course_id ] ) );
//					array_push( $discord_roles, $discord_role );
//					update_user_meta( $user_id, '_ets_lifterlms_discord_role_id_for_' . $course_id, $discord_role );
//				}
//			}
//		}

		$guilds_memeber_api_url = LIFTERLMS_DISCORD_API_URL . 'guilds/' . $guild_id . '/members/' . $_ets_lifterlms_discord_user_id;
		$guild_args             = array(
			'method'  => 'PUT',
			'headers' => array(
				'Content-Type'  => 'application/json',
				'Authorization' => 'Bot ' . $discord_bot_token,
			),
			'body'    => json_encode(
				array(
					'access_token' => $access_token,
				)
			),
		);
		$guild_response         = wp_remote_post( $guilds_memeber_api_url, $guild_args );

		//ets_lifterlms_discord_log_api_response( $user_id, $guilds_memeber_api_url, $guild_args, $guild_response );
		if ( ets_lifterlms_discord_check_api_errors( $guild_response ) ) {

			//$response_arr = json_decode( wp_remote_retrieve_body( $guild_response ), true );
			//L_Discord_Add_On_Logs::write_api_response_logs( $response_arr, $user_id, debug_backtrace()[0] );
			// this should be catch by Action schedule failed action.
			throw new Exception( 'Failed in function ets_lifterlms_discord_as_handler_add_member_to_guild' );
		}

//		foreach ( $discord_roles as $discord_role ) {
//
//			if ( $discord_role && $discord_role != 'none' && isset( $user_id ) ) {
//				$this->put_discord_role_api( $user_id, $discord_role );
//
//			}
//		}

		if ( $default_role && $default_role != 'none' && isset( $user_id ) ) {
			update_user_meta( $user_id, '_ets_lifterlms_discord_last_default_role', $default_role );
			//$this->put_discord_role_api( $user_id, $default_role );
		}
		if ( empty( get_user_meta( $user_id, '_ets_lifterlms_discord_join_date', true ) ) ) {
			update_user_meta( $user_id, '_ets_lifterlms_discord_join_date', current_time( 'Y-m-d H:i:s' ) );
		}

		// Send welcome message.
//		if ( $ets_lifterlms_discord_send_welcome_dm == true ) {
//			as_schedule_single_action( ets_lifterlms_discord_get_random_timestamp( ets_lifterlms_discord_get_highest_last_attempt_timestamp() ), 'ets_lifterlms_discord_as_send_dm', array( $user_id, $courses, 'welcome' ), LEARNDASH_DISCORD_AS_GROUP_NAME );
//		}
	}

	/**
	 * Get Discord user details from API
	 *
	 * @param STRING $access_token
	 * @return OBJECT REST API response
	 */
	public function get_discord_current_user( $access_token ) {
		if ( ! is_user_logged_in() ) {
			wp_send_json_error( 'Unauthorized user', 401 );
			exit();
		}
		$user_id = get_current_user_id();

		$discord_cuser_api_url = LIFTERLMS_DISCORD_API_URL . 'users/@me';
		$param                 = array(
			'headers' => array(
				'Content-Type'  => 'application/x-www-form-urlencoded',
				'Authorization' => 'Bearer ' . $access_token,
			),
		);
		$user_response         = wp_remote_get( $discord_cuser_api_url, $param );
		//ets_lifterlms_discord_log_api_response( $user_id, $discord_cuser_api_url, $param, $user_response );

		//$response_arr = json_decode( wp_remote_retrieve_body( $user_response ), true );
		//LearnDash_Discord_Add_On_Logs::write_api_response_logs( $response_arr, $user_id, debug_backtrace()[0] );
		$user_body = json_decode( wp_remote_retrieve_body( $user_response ), true );
		return $user_body;

	}
	

}
