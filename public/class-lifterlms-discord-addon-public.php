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
	 * The single object Lifterlms_Discord_Addon_Public
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var Lifterlms_Discord_Addon_Public
	 */
	private static $instance;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	public static function get_lifterlms_discord_public_instance( $plugin_name, $version ) {

		if ( ! self::$instance ) {
			self::$instance = new Lifterlms_Discord_Addon_Public( $plugin_name, $version );

		}
		return self::$instance;
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
		$min_js = ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) ? '' : '.min';
		wp_register_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/lifterlms-discord-addon-public' . $min_js . '.css', array(), $this->version, 'all' );

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
		$min_js = ( defined( 'WP_DEBUG' ) && true === WP_DEBUG ) ? '' : '.min';
		wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/lifterlms-discord-addon-public' . $min_js . '.js', array( 'jquery' ), $this->version, false );
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

		$user_id = sanitize_text_field( trim( get_current_user_id() ) );

		$access_token                                     = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_access_token', true ) ) );
		$_ets_lifterlms_discord_username                  = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_username', true ) ) );
		$discord_user_id                                  = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_user_id', true ) ) );
		$allow_none_student                               = sanitize_text_field( trim( get_option( 'ets_lifterlms_allow_none_member' ) ) );
		$ets_lifterlms_discord_connect_button_bg_color    = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_connect_button_bg_color' ) ) );
		$ets_lifterlms_discord_disconnect_button_bg_color = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_disconnect_button_bg_color' ) ) );
		$ets_lifterlms_discord_disconnect_button_text     = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_disconnect_button_text' ) ) );
		$ets_lifterlms_discord_loggedin_button_text       = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_loggedin_button_text' ) ) );
		$default_role                                     = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_default_role_id' ) ) );
		$ets_lifterlms_discord_role_mapping               = json_decode( get_option( 'ets_lifterlms_discord_role_mapping' ), true );
		$all_roles                                        = unserialize( get_option( 'ets_lifterlms_discord_all_roles' ) );
		$roles_color                                      = unserialize( get_option( 'ets_lifterlms_discord_roles_color' ) );
		$enrolled_courses                                 = ets_lifterlms_discord_get_student_courses_id( $user_id );
		$mapped_role_name                                 = '';
		if ( is_array( $enrolled_courses ) && is_array( $all_roles ) && is_array( $ets_lifterlms_discord_role_mapping ) ) {
			$lastKey = array_key_last( $enrolled_courses );
			foreach ( $enrolled_courses as $key => $enrolled_course_id ) {
				if ( array_key_exists( 'course_id_' . $enrolled_course_id, $ets_lifterlms_discord_role_mapping ) ) {

					$mapped_role_id = $ets_lifterlms_discord_role_mapping[ 'course_id_' . $enrolled_course_id ];

					if ( array_key_exists( $mapped_role_id, $all_roles ) ) {
						$mapped_role_name .= '<span> <i style="background-color:#' . dechex( $roles_color[ $mapped_role_id ] ) . '"></i>' . $all_roles[ $mapped_role_id ] . '</span>';
					}
				}
			}
		}

		$default_role_name = '';
		if ( is_array( $all_roles ) ) {
			if ( $default_role != 'none' && array_key_exists( $default_role, $all_roles ) ) {
				$default_role_name = '<span><i style="background-color:#' . dechex( $roles_color[ $default_role ] ) . '"></i> ' . $all_roles[ $default_role ] . '</span>';
			}
		}

		$restrictcontent_discord = '';

		if ( ets_lifterlms_discord_check_saved_settings_status() ) {

			if ( $access_token ) {
				$discord_user_avatar      = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_avatar', true ) ) );
				$disconnect_btn_bg_color  = 'style="background-color:' . $ets_lifterlms_discord_disconnect_button_bg_color . '"';
				$restrictcontent_discord .= '<div class="">';
				$restrictcontent_discord .= '<div class="">';
				$restrictcontent_discord .= '<label class="ets-connection-lbl">' . esc_html__( 'Discord connection', 'connect-lifterlms-discord' ) . '</label>';
				$restrictcontent_discord .= '</div>';
				$restrictcontent_discord .= '<div class="">';
				$restrictcontent_discord .= '<a href="#" class="ets-btn lifterlms-discord-addon-btn-disconnect"' . $disconnect_btn_bg_color . ' id="lifterlms-discord-addon-disconnect-discord" data-user-id="' . esc_attr( $user_id ) . '">' . esc_html__( $ets_lifterlms_discord_disconnect_button_text ) . Lifterlms_Discord_Addon::get_discord_logo_white() . '</a>';
				$restrictcontent_discord .= '<span class="ets-spinner"></span>';
				$restrictcontent_discord .= '<p>' . esc_html__( sprintf( 'Connected account: %s', $_ets_lifterlms_discord_username ), 'connect-lifterlms-discord' ) . '</p>';
				$restrictcontent_discord  = ets_lifterlms_discord_get_user_avatar( $discord_user_id, $discord_user_avatar, $restrictcontent_discord );
				$restrictcontent_discord  = ets_lifterlms_discord_roles_assigned_message( $mapped_role_name, $default_role_name, $restrictcontent_discord );
				$restrictcontent_discord .= '</div>';
				$restrictcontent_discord .= '</div>';

			} elseif ( ( ets_lifterlms_discord_get_student_courses_id( $user_id ) && $mapped_role_name )
								|| ( ets_lifterlms_discord_get_student_courses_id( $user_id ) && ! $mapped_role_name && $default_role_name )
								|| ( $allow_none_student == 'yes' ) ) {

				$connect_btn_bg_color     = 'style="background-color:' . $ets_lifterlms_discord_connect_button_bg_color . '"';
				$restrictcontent_discord .= '<div class="">';
				$restrictcontent_discord .= '<h3 class="llms-sd-section-title">' . esc_html__( 'Discord connection', 'connect-lifterlms-discord' ) . '</h3>';
				$restrictcontent_discord .= '<div class="">';
				$restrictcontent_discord .= '<a href="?action=lifterlms-discord-login" class="lifterlms-discord-addon-btn-connect ets-btn"' . $connect_btn_bg_color . ' >' . $ets_lifterlms_discord_loggedin_button_text . Lifterlms_Discord_Addon::get_discord_logo_white() . '</a>';
				$restrictcontent_discord .= '</div>';
				$restrictcontent_discord  = ets_lifterlms_discord_roles_assigned_message( $mapped_role_name, $default_role_name, $restrictcontent_discord );

				$restrictcontent_discord .= '</div>';

			}
		}
		wp_enqueue_style( $this->plugin_name );
		wp_enqueue_script( $this->plugin_name );

		return $restrictcontent_discord;

	}

	/**
	 * Add connect discord button on student profile page at the end of [lifterlms_my_account] shortcode.
	 *
	 * @since    1.0.0
	 */
	public function ets_lifterlms_show_discord_button( $output, $tag, $attr ) {

		if ( 'lifterlms_my_account' != $tag ) {
			return $output;
		}
		$output .= $this->ets_lifterlms_discord_add_connect_button();

		return $output;
	}

	/**
	 *  Initialize discord authentication.
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

			if ( isset( $_GET['code'] ) && isset( $_GET['via'] ) && $_GET['via'] == 'connect-lifterlms-discord' ) {
				$code     = sanitize_text_field( wp_unslash( trim( $_GET['code'] ) ) );
				$response = $this->ets_lifterlms_discord_auth_token( $code, $user_id );

				if ( ! empty( $response ) && ! is_wp_error( $response ) ) {
					$res_body              = json_decode( wp_remote_retrieve_body( $response ), true );
					$discord_exist_user_id = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_user_id', true ) ) );
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
								$discord_user_avatar           = $user_body['avatar'];
								$discord_user_name_with_number = $discord_user_name . '#' . $discord_user_number;
								update_user_meta( $user_id, '_ets_lifterlms_discord_username', $discord_user_name_with_number );
								update_user_meta( $user_id, '_ets_lifterlms_discord_avatar', $discord_user_avatar );
							}
							if ( is_array( $user_body ) && array_key_exists( 'id', $user_body ) ) {
								$_ets_lifterlms_discord_user_id = sanitize_text_field( trim( $user_body['id'] ) );
								if ( $discord_exist_user_id === $_ets_lifterlms_discord_user_id ) {
									$courses = map_deep( ets_lifterlms_discord_get_student_courses_id( $user_id ), 'sanitize_text_field' );
									if ( is_array( $courses ) ) {
										foreach ( $courses as $course_id ) {
											$_ets_lifterlms_discord_role_id = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_role_id_for_' . $course_id, true ) ) );
											if ( ! empty( $_ets_lifterlms_discord_role_id ) && $_ets_lifterlms_discord_role_id != 'none' ) {
												$this->delete_discord_role( $user_id, $_ets_lifterlms_discord_role_id );
											}
										}
									}
								}
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
				ets_lifterlms_discord_log_api_response( $user_id, $discord_token_api_url, $args, $response );
				if ( ets_lifterlms_discord_check_api_errors( $response ) ) {
					$response_arr = json_decode( wp_remote_retrieve_body( $response ), true );
					Lifterlms_Discord_Addon_Logs::write_api_response_logs( $response_arr, $user_id, debug_backtrace()[0] );
				}
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
			ets_lifterlms_discord_log_api_response( $user_id, $discord_token_api_url, $args, $response );
			if ( ets_lifterlms_discord_check_api_errors( $response ) ) {
				$response_arr = json_decode( wp_remote_retrieve_body( $response ), true );
				Lifterlms_Discord_Addon_Logs::write_api_response_logs( $response_arr, $user_id, debug_backtrace()[0] );
			}
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
		// Check if the $user_id is available and valid
		if ( empty( $user_id ) || ! is_numeric( $user_id ) ) {

			wp_send_json_error( 'Invalid user ID', 400 );
			return;
		}
		$enrolled_coures = map_deep( ets_lifterlms_discord_get_student_courses_id( $user_id ), 'sanitize_text_field' );
		if ( $enrolled_coures !== null ) {
			// It is possible that we may exhaust API rate limit while adding members to guild, so handling off the job to queue.
			as_schedule_single_action( ets_lifterlms_discord_get_random_timestamp( ets_lifterlms_discord_get_highest_last_attempt_timestamp() ), 'ets_lifterlms_discord_as_handle_add_member_to_guild', array( $_ets_lifterlms_discord_user_id, $user_id, $access_token ), LIFTERLMS_DISCORD_AS_GROUP_NAME );
		}
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
		$courses                            = map_deep( ets_lifterlms_discord_get_student_courses_id( $user_id ), 'sanitize_text_field' );

		$ets_lifterlms_discord_send_welcome_dm = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_send_welcome_dm' ) ) );
		if ( is_array( $courses ) ) {
			foreach ( $courses as $course_id ) {

				if ( is_array( $ets_lifterlms_discord_role_mapping ) && array_key_exists( 'course_id_' . $course_id, $ets_lifterlms_discord_role_mapping ) ) {
					$discord_role = sanitize_text_field( trim( $ets_lifterlms_discord_role_mapping[ 'course_id_' . $course_id ] ) );
					array_push( $discord_roles, $discord_role );
					update_user_meta( $user_id, '_ets_lifterlms_discord_role_id_for_' . $course_id, $discord_role );
				}
			}
		}

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

		ets_lifterlms_discord_log_api_response( $user_id, $guilds_memeber_api_url, $guild_args, $guild_response );
		if ( ets_lifterlms_discord_check_api_errors( $guild_response ) ) {

			$response_arr = json_decode( wp_remote_retrieve_body( $guild_response ), true );
			Lifterlms_Discord_Addon_Logs::write_api_response_logs( $response_arr, $user_id, debug_backtrace()[0] );
			// this should be catch by Action schedule failed action.
			throw new Exception( 'Failed in function ets_lifterlms_discord_as_handler_add_member_to_guild' );
		}

		foreach ( $discord_roles as $discord_role ) {

			if ( $discord_role && $discord_role != 'none' && isset( $user_id ) ) {
				$this->put_discord_role_api( $user_id, $discord_role );

			}
		}

		if ( $default_role && $default_role != 'none' && isset( $user_id ) ) {
			update_user_meta( $user_id, '_ets_lifterlms_discord_last_default_role', $default_role );
			$this->put_discord_role_api( $user_id, $default_role );
		}
		if ( empty( get_user_meta( $user_id, '_ets_lifterlms_discord_join_date', true ) ) ) {
			update_user_meta( $user_id, '_ets_lifterlms_discord_join_date', current_time( 'Y-m-d H:i:s' ) );
		}

		// Send welcome message.
		if ( $ets_lifterlms_discord_send_welcome_dm == true ) {
			as_schedule_single_action( ets_lifterlms_discord_get_random_timestamp( ets_lifterlms_discord_get_highest_last_attempt_timestamp() ), 'ets_lifterlms_discord_as_send_dm', array( $user_id, $courses, 'welcome' ), LIFTERLMS_DISCORD_AS_GROUP_NAME );
		}
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
			return;
		}

		$user_id = get_current_user_id();
		if ( empty( $user_id ) || ! is_numeric( $user_id ) ) {
			wp_send_json_error( 'Invalid user ID', 400 );
			return;
		}

		$discord_cuser_api_url = LIFTERLMS_DISCORD_API_URL . 'users/@me';
		$param                 = array(
			'headers' => array(
				'Content-Type'  => 'application/x-www-form-urlencoded',
				'Authorization' => 'Bearer ' . $access_token,
			),
		);
		$user_response         = wp_remote_get( $discord_cuser_api_url, $param );
		ets_lifterlms_discord_log_api_response( $user_id, $discord_cuser_api_url, $param, $user_response );

		$response_arr = json_decode( wp_remote_retrieve_body( $user_response ), true );
		Lifterlms_Discord_Addon_Logs::write_api_response_logs( $response_arr, $user_id, debug_backtrace()[0] );
		$user_body = json_decode( wp_remote_retrieve_body( $user_response ), true );
		return $user_body;

	}

	/**
	 * API call to change discord user role
	 *
	 * @param INT  $user_id
	 * @param INT  $role_id
	 * @param BOOL $is_schedule
	 * @return object API response
	 */
	public function put_discord_role_api( $user_id, $role_id, $is_schedule = true ) {
		if ( $is_schedule ) {
			as_schedule_single_action( ets_lifterlms_discord_get_random_timestamp( ets_lifterlms_discord_get_highest_last_attempt_timestamp() ), 'ets_lifterlms_discord_as_schedule_member_put_role', array( $user_id, $role_id, $is_schedule ), LIFTERLMS_DISCORD_AS_GROUP_NAME );
		} else {
			$this->ets_lifterlms_discord_as_handler_put_member_role( $user_id, $role_id, $is_schedule );
		}
	}

	/**
	 * Action Schedule handler for mmeber change role discord.
	 *
	 * @param INT  $user_id
	 * @param INT  $role_id
	 * @param BOOL $is_schedule
	 * @return object API response
	 */
	public function ets_lifterlms_discord_as_handler_put_member_role( $user_id, $role_id, $is_schedule ) {
		$access_token                   = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_access_token', true ) ) );
		$guild_id                       = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_server_id' ) ) );
		$_ets_lifterlms_discord_user_id = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_user_id', true ) ) );
		$discord_bot_token              = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_bot_token' ) ) );
		$discord_change_role_api_url    = LIFTERLMS_DISCORD_API_URL . 'guilds/' . $guild_id . '/members/' . $_ets_lifterlms_discord_user_id . '/roles/' . $role_id;

		if ( $access_token && $_ets_lifterlms_discord_user_id ) {
			$param = array(
				'method'  => 'PUT',
				'headers' => array(
					'Content-Type'   => 'application/json',
					'Authorization'  => 'Bot ' . $discord_bot_token,
					'Content-Length' => 0,
				),
			);

			$response = wp_remote_get( $discord_change_role_api_url, $param );

			ets_lifterlms_discord_log_api_response( $user_id, $discord_change_role_api_url, $param, $response );
			if ( ets_lifterlms_discord_check_api_errors( $response ) ) {
				$response_arr = json_decode( wp_remote_retrieve_body( $response ), true );
				Lifterlms_Discord_Addon_Logs::write_api_response_logs( $response_arr, $user_id, debug_backtrace()[0] );
				if ( $is_schedule ) {
					// this exception should be catch by action scheduler.
					throw new Exception( 'Failed in function ets_lifterlms_discord_as_handler_put_member_role' );
				}
			}
		}
	}


	/**
	 * Discord DM a member using bot.
	 *
	 * @param INT    $user_id Student's id.
	 * @param MIXED  $course
	 * @param STRING $type (warning|expired).
	 * @param INT    $related (quiz_attempt|Realted achievment post)
	 */
	public function ets_lifterlms_discord_handler_send_dm( $user_id, $courses, $type = 'warning', $related = '' ) {
		$discord_user_id   = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_user_id', true ) ) );
		$discord_bot_token = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_bot_token' ) ) );

		$ets_lifterlms_discord_welcome_message            = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_welcome_message' ) ) );
		$ets_lifterlms_discord_lesson_complete_message    = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_lesson_complete_message' ) ) );
		$ets_lifterlms_discord_quiz_complete_message      = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_quiz_complete_message' ) ) );
		$ets_lifterlms_discord_achievement_earned_message = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_achievement_earned_message' ) ) );
		$ets_lifterlms_discord_certificate_earned_message = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_certificate_earned_message' ) ) );
		$embed_messaging_feature                          = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_embed_messaging_feature' ) ) );

		// Check if DM channel is already created for the user.
		$user_dm = get_user_meta( $user_id, '_ets_lifterlms_discord_dm_channel', true );

		if ( ! isset( $user_dm['id'] ) || $user_dm === false || empty( $user_dm ) ) {
			$this->ets_lifterlms_discord_create_member_dm_channel( $user_id );
			$user_dm       = get_user_meta( $user_id, '_ets_lifterlms_discord_dm_channel', true );
			$dm_channel_id = $user_dm['id'];
		} else {
			$dm_channel_id = $user_dm['id'];
		}

		if ( $type == 'welcome' ) {
			$message = ets_lifterlms_discord_get_formatted_dm( $user_id, $courses, $ets_lifterlms_discord_welcome_message );
		}
		if ( $type == 'lesson_complete' ) {

			$message = ets_lifterlms_discord_get_formatted_lesson_complete_dm( $user_id, $courses, $ets_lifterlms_discord_lesson_complete_message );
		}
		if ( $type == 'quiz_complete' ) {

			$message = ets_lifterlms_discord_get_formatted_quiz_complete_dm( $user_id, $courses, $related, $ets_lifterlms_discord_quiz_complete_message );
		}
		if ( $type == 'achievement_earned' ) {
			$message = ets_lifterlms_discord_get_formatted_achievement_earned_dm( $user_id, $courses, $related, $ets_lifterlms_discord_achievement_earned_message );
		}
		if ( $type == 'certificate_earned' ) {
			$message = ets_lifterlms_discord_get_formatted_certificate_earned_dm( $user_id, $courses, $related, $ets_lifterlms_discord_certificate_earned_message );
		}

		if ( $type == 'quiz_attempt' ) {
			$message = ets_lifterlms_discord_get_formatted_quiz_attempt_dm( $user_id, $courses );
		}
		$creat_dm_url = LIFTERLMS_DISCORD_API_URL . '/channels/' . $dm_channel_id . '/messages';

		/**
		 *
		 * Send rich embed message for $type == 'achievement_earned' ( support Badge  achievement)
		 */

		if ( $embed_messaging_feature ) {
			$dm_args = array(
				'method'  => 'POST',
				'headers' => array(
					'Content-Type'  => 'application/json',
					'Authorization' => 'Bot ' . $discord_bot_token,
				),
				'body'    => ets_lifterlms_discord_get_rich_embed_message( trim( $message ) ),
			);
		} else {
			$dm_args = array(
				'method'  => 'POST',
				'headers' => array(
					'Content-Type'  => 'application/json',
					'Authorization' => 'Bot ' . $discord_bot_token,
				),
				'body'    => wp_json_encode(
					array(
						'content' => sanitize_text_field( trim( wp_unslash( $message ) ) ),
					)
				),
			);
		}

		$dm_response = wp_remote_post( $creat_dm_url, $dm_args );
		ets_lifterlms_discord_log_api_response( $user_id, $creat_dm_url, $dm_args, $dm_response );
		$dm_response_body = json_decode( wp_remote_retrieve_body( $dm_response ), true );
		if ( ets_lifterlms_discord_check_api_errors( $dm_response ) ) {
			Lifterlms_Discord_Addon_Logs::write_api_response_logs( $dm_response_body, $user_id, debug_backtrace()[0] );
			// this should be catch by Action schedule failed action.
			throw new Exception( 'Failed in function ets_lifterlms_discord_handler_send_dm' );
		}
	}

	/**
	 * Create DM channel for a give user_id
	 *
	 * @param INT $user_id
	 * @return MIXED
	 */
	public function ets_lifterlms_discord_create_member_dm_channel( $user_id ) {
		$discord_user_id       = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_user_id', true ) ) );
		$discord_bot_token     = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_bot_token' ) ) );
		$create_channel_dm_url = LIFTERLMS_DISCORD_API_URL . '/users/@me/channels';
		$dm_channel_args       = array(
			'method'  => 'POST',
			'headers' => array(
				'Content-Type'  => 'application/json',
				'Authorization' => 'Bot ' . $discord_bot_token,
			),
			'body'    => json_encode(
				array(
					'recipient_id' => $discord_user_id,
				)
			),
		);

		$created_dm_response = wp_remote_post( $create_channel_dm_url, $dm_channel_args );
		ets_lifterlms_discord_log_api_response( $user_id, $create_channel_dm_url, $dm_channel_args, $created_dm_response );
		$response_arr = json_decode( wp_remote_retrieve_body( $created_dm_response ), true );

		if ( is_array( $response_arr ) && ! empty( $response_arr ) ) {
			// check if there is error in create dm response
			if ( array_key_exists( 'code', $response_arr ) || array_key_exists( 'error', $response_arr ) ) {
				Lifterlms_Discord_Addon_Logs::write_api_response_logs( $response_arr, $user_id, debug_backtrace()[0] );
				if ( ets_lifterlms_discord_check_api_errors( $created_dm_response ) ) {
					// this should be catch by Action schedule failed action.
					throw new Exception( 'Failed in function ets_lifterlms_discord_create_member_dm_channel' );
				}
			} else {
				update_user_meta( $user_id, '_ets_lifterlms_discord_dm_channel', $response_arr );
			}
		}
		return $response_arr;
	}

	/**
	 * Disconnect user from discord, and , if the case, kick students on disconnect
	 *
	 * @param NONE
	 * @return OBJECT JSON response
	 */
	public function ets_lifterlms_disconnect_from_discord() {

		if ( ! is_user_logged_in() ) {
			wp_send_json_error( 'Unauthorized user', 401 );
			return;
		}

		// Check for nonce security
		if ( ! wp_verify_nonce( $_POST['ets_lifterlms_discord_nonce'], 'ets-lifterlms-ajax-nonce' ) ) {
				wp_send_json_error( 'You do not have sufficient rights', 403 );
				exit();
		}
		$user_id              = sanitize_text_field( trim( $_POST['user_id'] ) );
		$kick_upon_disconnect = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_kick_upon_disconnect' ) ) );
		if ( $user_id ) {
			delete_user_meta( $user_id, '_ets_lifterlms_discord_access_token' );
			delete_user_meta( $user_id, '_ets_lifterlms_discord_refresh_token' );
			$user_roles = ets_lifterlms_discord_get_user_roles( $user_id );
			if ( $kick_upon_disconnect ) {

				if ( is_array( $user_roles ) ) {
					foreach ( $user_roles as $user_role ) {
						$this->delete_discord_role( $user_id, $user_role );
					}
				}
			} else {
				$this->delete_member_from_guild( $user_id, false );
			}
		}
		$event_res = array(
			'status'  => 1,
			'message' => 'Successfully disconnected',
		);
		wp_send_json( $event_res );
		exit();

	}

	/**
	 * Schedule delete discord role for a student
	 *
	 * @param INT  $user_id
	 * @param INT  $ets_lifterlms_discord_role_id
	 * @param BOOL $is_schedule
	 * @return OBJECT API response
	 */
	public function delete_discord_role( $user_id, $ets_lifterlms_discord_role_id, $is_schedule = true ) {
		if ( $is_schedule ) {
			as_schedule_single_action( ets_lifterlms_discord_get_random_timestamp( ets_lifterlms_discord_get_highest_last_attempt_timestamp() ), 'ets_lifterlms_discord_as_schedule_delete_role', array( $user_id, $ets_lifterlms_discord_role_id, $is_schedule ), LIFTERLMS_DISCORD_AS_GROUP_NAME );
		} else {
			$this->ets_lifterlms_discord_as_handler_delete_memberrole( $user_id, $ets_lifterlms_discord_role_id, $is_schedule );
		}
	}

	/**
	 * Action Schedule handler to process delete role of a student.
	 *
	 * @param INT  $user_id
	 * @param INT  $ets_lifterlms_discord_role_id
	 * @param BOOL $is_schedule
	 * @return OBJECT API response
	 */
	public function ets_lifterlms_discord_as_handler_delete_memberrole( $user_id, $ets_lifterlms_discord_role_id, $is_schedule = true ) {

		$guild_id                       = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_server_id' ) ) );
		$_ets_lifterlms_discord_user_id = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_user_id', true ) ) );
		$discord_bot_token              = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_bot_token' ) ) );
		$discord_delete_role_api_url    = LIFTERLMS_DISCORD_API_URL . 'guilds/' . $guild_id . '/members/' . $_ets_lifterlms_discord_user_id . '/roles/' . $ets_lifterlms_discord_role_id;
		if ( $_ets_lifterlms_discord_user_id ) {
			$param = array(
				'method'  => 'DELETE',
				'headers' => array(
					'Content-Type'   => 'application/json',
					'Authorization'  => 'Bot ' . $discord_bot_token,
					'Content-Length' => 0,
				),
			);

			$response = wp_remote_request( $discord_delete_role_api_url, $param );
			ets_lifterlms_discord_log_api_response( $user_id, $discord_delete_role_api_url, $param, $response );
			if ( ets_lifterlms_discord_check_api_errors( $response ) ) {
				$response_arr = json_decode( wp_remote_retrieve_body( $response ), true );
				Lifterlms_Discord_Addon_Logs::write_api_response_logs( $response_arr, $user_id, debug_backtrace()[0] );
				if ( $is_schedule ) {
					// this exception should be catch by action scheduler.
					throw new Exception( 'Failed in function ets_lifterlms_discord_as_handler_delete_memberrole' );
				}
			}
			return $response;
		}
	}

	/**
	 * Schedule delete existing user from guild
	 *
	 * @param INT  $user_id
	 * @param BOOL $is_schedule
	 * @param NONE
	 */
	public function delete_member_from_guild( $user_id, $is_schedule = true ) {
		if ( $is_schedule && isset( $user_id ) ) {

			as_schedule_single_action( ets_lifterlms_discord_get_random_timestamp( ets_lifterlms_discord_get_highest_last_attempt_timestamp() ), 'ets_lifterlms_discord_as_schedule_delete_member', array( $user_id, $is_schedule ), LIFTERLMS_DISCORD_AS_GROUP_NAME );
		} else {
			if ( isset( $user_id ) ) {
				$this->ets_lifterlms_discord_as_handler_delete_member_from_guild( $user_id, $is_schedule );
			}
		}
	}

	/**
	 * AS Handling member delete from huild
	 *
	 * @param INT  $user_id
	 * @param BOOL $is_schedule
	 * @return OBJECT API response
	 */
	public function ets_lifterlms_discord_as_handler_delete_member_from_guild( $user_id, $is_schedule ) {
		$guild_id                       = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_server_id' ) ) );
		$discord_bot_token              = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_bot_token' ) ) );
		$_ets_lifterlms_discord_user_id = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_user_id', true ) ) );
		$guilds_delete_memeber_api_url  = LIFTERLMS_DISCORD_API_URL . 'guilds/' . $guild_id . '/members/' . $_ets_lifterlms_discord_user_id;
		$guild_args                     = array(
			'method'  => 'DELETE',
			'headers' => array(
				'Content-Type'  => 'application/json',
				'Authorization' => 'Bot ' . $discord_bot_token,
			),
		);
		$guild_response                 = wp_remote_post( $guilds_delete_memeber_api_url, $guild_args );

		ets_lifterlms_discord_log_api_response( $user_id, $guilds_delete_memeber_api_url, $guild_args, $guild_response );
		if ( ets_lifterlms_discord_check_api_errors( $guild_response ) ) {
			$response_arr = json_decode( wp_remote_retrieve_body( $guild_response ), true );
			Lifterlms_Discord_Addon_Logs::write_api_response_logs( $response_arr, $user_id, debug_backtrace()[0] );
			if ( $is_schedule ) {
				// this exception should be catch by action scheduler.
				throw new Exception( 'Failed in function ets_lifterlms_discord_as_handler_delete_member_from_guild' );
			}
		}

		/*Delete all usermeta related to discord connection*/
		ets_lifterlms_discord_remove_usermeta( $user_id );

	}

	/**
	 * Send DM message of the student has completed a lesson
	 *
	 * @param int $user_id Student'id.
	 * @param int $lesson_id Lesson's id.
	 * @return void
	 */
	public function ets_lifterlms_lesson_completed( $user_id, $lesson_id ) {

		if ( ! is_user_logged_in() ) {
			return;
		}
		$ets_lifterlms_discord_send_lesson_complete_dm = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_send_lesson_complete_dm' ) ) );
		// Send Lesson complete message
		if ( $ets_lifterlms_discord_send_lesson_complete_dm == true ) {
			as_schedule_single_action( ets_lifterlms_discord_get_random_timestamp( ets_lifterlms_discord_get_highest_last_attempt_timestamp() ), 'ets_lifterlms_discord_as_send_dm', array( $user_id, $lesson_id, 'lesson_complete' ), LIFTERLMS_DISCORD_AS_GROUP_NAME );
		}

	}

	/**
	 * Check if the student has completed a quiz.
	 *
	 * @param int $student_id WP User ID.
	 * @param int $quiz_id    WP Post ID of the quiz.
	 * @param obj $attempt    Instance of the LLMS_Quiz_Attempt.
	 * @return void
	 */
	public function ets_lifterlms_quiz_completed( $student_id, $quiz_id, $attempt ) {

		$ets_lifterlms_discord_send_quiz_complete_dm = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_send_quiz_complete_dm' ) ) );

		// Send Quiz Complete message.
		if ( $ets_lifterlms_discord_send_quiz_complete_dm == true ) {
			as_schedule_single_action( ets_lifterlms_discord_get_random_timestamp( ets_lifterlms_discord_get_highest_last_attempt_timestamp() ), 'ets_lifterlms_discord_as_send_dm', array( $student_id, $quiz_id, 'quiz_complete', $attempt ), LIFTERLMS_DISCORD_AS_GROUP_NAME );
		}

	}

	/**
	 *
	 */
	public function ets_lifterlms_user_earned_achievement( $user_id, $achievement_id, $related_post_id ) {
		$ets_lifterlms_discord_send_achievement_earned_dm = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_send_achievement_earned_dm' ) ) );
		// Send achievement Earned message.
		if ( $ets_lifterlms_discord_send_achievement_earned_dm == true ) {
			as_schedule_single_action( ets_lifterlms_discord_get_random_timestamp( ets_lifterlms_discord_get_highest_last_attempt_timestamp() ), 'ets_lifterlms_discord_as_send_dm', array( $user_id, $achievement_id, 'achievement_earned', $related_post_id ), LIFTERLMS_DISCORD_AS_GROUP_NAME );
		}
	}

	/**
	 *
	 */
	public function ets_lifterlms_user_earned_certificate( $user_id, $new_user_certificate_id, $related_post_id ) {
		$ets_lifterlms_discord_send_certificate_earned_dm = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_send_certificate_earned_dm' ) ) );
		// Send achievement Earned message.
		if ( $ets_lifterlms_discord_send_certificate_earned_dm == true ) {
			as_schedule_single_action( ets_lifterlms_discord_get_random_timestamp( ets_lifterlms_discord_get_highest_last_attempt_timestamp() ), 'ets_lifterlms_discord_as_send_dm', array( $user_id, $new_user_certificate_id, 'certificate_earned', $related_post_id ), LIFTERLMS_DISCORD_AS_GROUP_NAME );
		}
	}

	/**
	 * Update student's discord roles when admin assign / unassign course to students.
	 *
	 * @param int  $user_id WP User ID.
	 * @param int  $course_id WP Post ID of the course or membership.
	 * @param bool $remove enrollment deleted.
	 * @return NONE
	 */
	public function ets_lifterlms_discord_update_user_course_enrollment( $user_id, $course_id, $remove = false ) {

		$access_token                       = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_access_token', true ) ) );
		$refresh_token                      = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_refresh_token', true ) ) );
		$ets_lifterlms_discord_role_mapping = json_decode( get_option( 'ets_lifterlms_discord_role_mapping' ), true );
		$default_role                       = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_default_role_id' ) ) );

		if ( is_array( $ets_lifterlms_discord_role_mapping ) && array_key_exists( 'course_id_' . $course_id, $ets_lifterlms_discord_role_mapping ) ) {
			$discord_role = sanitize_text_field( trim( $ets_lifterlms_discord_role_mapping[ 'course_id_' . $course_id ] ) );
			if ( $discord_role && $discord_role != 'none' ) {
				if ( $access_token && $refresh_token ) {

					if ( $remove ) {
						delete_user_meta( $user_id, '_ets_lifterlms_discord_role_id_for_' . $course_id, $discord_role );
						$this->delete_discord_role( $user_id, $discord_role );
					} else {
						update_user_meta( $user_id, '_ets_lifterlms_discord_role_id_for_' . $course_id, $discord_role );
						$this->put_discord_role_api( $user_id, $discord_role );
					}
				}
			}
		}
		if ( $access_token && $refresh_token ) {
			if ( $default_role && $default_role != 'none' && isset( $user_id ) ) {
				update_user_meta( $user_id, '_ets_lifterlms_discord_last_default_role', $default_role );
				$this->put_discord_role_api( $user_id, $default_role );
			} else {
				$default_role = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_last_default_role', true ) ) );
				$this->delete_discord_role( $user_id, $default_role );
			}
		}
	}

	/**
	 * Set discord role after a user is enrolled in membership.
	 *
	 * @param int $user_id    WP User ID.
	 * @param int $product_id WP Post ID of the course or membership.
	 */
	public function ets_lifterlms_user_added_to_membership_level( $user_id, $product_id ) {
		$ets_lifterlms_discord_role_mapping = json_decode( get_option( 'ets_lifterlms_discord_role_mapping' ), true );
		$default_role                       = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_default_role_id' ) ) );
		$access_token                       = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_access_token', true ) ) );
		$refresh_token                      = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_refresh_token', true ) ) );
		if ( $access_token && $refresh_token ) {
			if ( is_array( $ets_lifterlms_discord_role_mapping ) && array_key_exists( 'course_id_' . $product_id, $ets_lifterlms_discord_role_mapping ) ) {
				$discord_role = sanitize_text_field( trim( $ets_lifterlms_discord_role_mapping[ 'course_id_' . $product_id ] ) );
				if ( $discord_role && $discord_role != 'none' ) {
					update_user_meta( $user_id, '_ets_lifterlms_discord_role_id_for_' . $product_id, $discord_role );
					$this->put_discord_role_api( $user_id, $discord_role );
				}
			}

			if ( $default_role && $default_role != 'none' && isset( $user_id ) ) {
				update_user_meta( $user_id, '_ets_lifterlms_discord_last_default_role', $default_role );
				$this->put_discord_role_api( $user_id, $default_role );
			} else {
				$default_role = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_last_default_role', true ) ) );
				$this->delete_discord_role( $user_id, $default_role );
			}
		}
	}

	/**
	 *
	 */
	public function ets_lifterlms_discord_update_course_access( $user_id, $course_id ) {
		$ets_lifterlms_discord_role_mapping = json_decode( get_option( 'ets_lifterlms_discord_role_mapping' ), true );
		$default_role                       = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_default_role_id' ) ) );
		$access_token                       = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_access_token', true ) ) );
		$refresh_token                      = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_refresh_token', true ) ) );
		if ( $access_token && $refresh_token ) {
			if ( is_array( $ets_lifterlms_discord_role_mapping ) && array_key_exists( 'course_id_' . $course_id, $ets_lifterlms_discord_role_mapping ) ) {
				$discord_role = sanitize_text_field( trim( $ets_lifterlms_discord_role_mapping[ 'course_id_' . $course_id ] ) );
				if ( $discord_role && $discord_role != 'none' ) {
					update_user_meta( $user_id, '_ets_lifterlms_discord_role_id_for_' . $course_id, $discord_role );
					$this->put_discord_role_api( $user_id, $discord_role );
				}
			}

			if ( $default_role && $default_role != 'none' && isset( $user_id ) ) {
				update_user_meta( $user_id, '_ets_lifterlms_discord_last_default_role', $default_role );
				$this->put_discord_role_api( $user_id, $default_role );
			} else {
				$default_role = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_last_default_role', true ) ) );
				$this->delete_discord_role( $user_id, $default_role );
			}
		}
	}


	public function ets_lifterlms_quiz_attempt_results( $attempt ) {

		// Ensure $attempt is set and a valid LLMS_Quiz_Attempt object
		if ( ! $attempt || ! $attempt instanceof LLMS_Quiz_Attempt ) {
			return;
		}

		$student = $attempt->get_student();

		// Ensure $student is set and a valid LLMS_Student object
		if ( ! $student || ! $student instanceof LLMS_Student ) {
			return;
		}

		$user_id       = $student->get( 'id' );
		$access_token  = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_access_token', true ) ) );
		$refresh_token = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_refresh_token', true ) ) );
		if ( $access_token && $refresh_token && is_object( $attempt ) && $attempt->get_count( 'gradeable_questions' ) ) {
			$user_attempt_dm_send = sanitize_text_field( trim( get_user_meta( $user_id, '_ets_lifterlms_discord_atttempt_' . $attempt->get_key(), true ) ) );
			if ( $user_attempt_dm_send ) {
				/**
				 * Attempt DM already sent.
				 * Stop here to avoid re-send mesage when user refresh the attempt page.
				 */
				return;

			} else {
				if ( $attempt->get_count( 'gradeable_questions' ) ) {
					update_user_meta( $user_id, '_ets_lifterlms_discord_atttempt_' . $attempt->get_key(), true );
					as_schedule_single_action( ets_lifterlms_discord_get_random_timestamp( ets_lifterlms_discord_get_highest_last_attempt_timestamp() ), 'ets_lifterlms_discord_as_send_dm', array( $user_id, $attempt, 'quiz_attempt' ), LIFTERLMS_DISCORD_AS_GROUP_NAME );
				} else {
					return;
				}
			}
		}
	}

}
