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
		wp_localize_script( $this->plugin_name . 'public_js', 'etsLifterlmspublicParams', $script_params );
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
		if(isset($_GET['action']) && $_GET['action']=='lifterlms-discord-login'){
			$discord_authorise_api_url = LIFTERLMS_DISCORD_API_URL . 'oauth2/authorize';
			$params                    = array(
				'client_id'            => sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_client_id' ) ) ),
				'permissions'          => LIFTERLMS_DISCORD_BOT_PERMISSIONS,
				'scope'                => LIFTERLMS_DISCORD_OAUTH_SCOPES,
				'guild_id'             => sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_server_id' ) ) ),
				'disable_guild_select' => 'true',
				'redirect_uri'         => sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_redirect_url' ) ) ),
				'response_type'        => 'code',
			);

			$discord_authorise_api_url = LIFTERLMS_DISCORD_API_URL . 'oauth2/authorize?' . http_build_query( $params );
			wp_redirect( $discord_authorise_api_url, 302, get_site_url() );
			exit;
		}

		if ( isset( $_GET['code'] ) && isset( $_GET['via'] ) && $_GET['via'] =='lifterlms-discord' ) {

			$user_id = get_current_user_id();
			$code    = sanitize_text_field( trim( $_GET['code'] ) );
			$response = $this->ets_lifterlms_discord_auth_token( $code, $user_id );

			/* Get_responce* */

			if ( ! empty( $response ) ) {	
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
        /*  function call   */
						$user_body = $this->get_discord_current_user_id( $access_token );
						
						if ( is_array( $user_body ) && array_key_exists( 'discriminator', $user_body ) ) {
							$discord_user_number           = $user_body['discriminator'];
							$discord_user_name             = $user_body['username'];
							$discord_user_name_with_number = $discord_user_name . '#' . $discord_user_number;
							update_user_meta( $user_id, '_ets_lifterlms_discord_username', $discord_user_name_with_number );
						}
						if ( is_array( $user_body ) && array_key_exists( 'id', $user_body ) ) {
							$_ets_lifterlms_discord_user_id = sanitize_text_field( trim( $user_body['id'] ) );
							update_user_meta( $user_id, '_ets_lifterlms_discord_user_id', $_ets_lifterlms_discord_user_id );
							
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
		return $response;
	}


	/**
	 * Get Discord user details from API
	 *
	 */
	public function get_discord_current_user_id( $access_token ) {
		
		$user_id = get_current_user_id();

		$discord_cuser_api_url = LIFTERLMS_DISCORD_API_URL . 'users/@me';
		$param                 = array(
			'headers' => array(
				'Content-Type'  => 'application/x-www-form-urlencoded',
				'Authorization' => 'Bearer ' . $access_token,
			),
		);
		$user_response         = wp_remote_get( $discord_cuser_api_url, $param );

		$response_arr = json_decode( wp_remote_retrieve_body( $user_response ), true );
		$user_body = json_decode( wp_remote_retrieve_body( $user_response ), true );
		return $user_body;

	}
	

}
