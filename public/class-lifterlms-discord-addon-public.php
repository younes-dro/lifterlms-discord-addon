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
		if ( ! current_user_can( 'administrator' ) ) {
			wp_send_json_error( 'You do not have sufficient rights', 403 );
			exit();
		}
		$user_id                              = sanitize_text_field( get_current_user_id() );
		$access_token                         = sanitize_text_field( get_user_meta( $user_id, '_ets_lifterlms_discord_access_token', true ) );
		$allow_none_member                    = sanitize_text_field( get_option( 'ets_lifterlms_allow_none_member' ) );
		$default_role                         = sanitize_text_field( get_option( 'ets_lifterlms_discord_default_role_id' ) );
		$ets_lifterlms_discord_role_mapping = json_decode( get_option( 'ets_lifterlms_discord_role_mapping' ), true );
		$all_roles                            = json_decode( get_option( 'ets_lifterlms_discord_all_roles' ), true );
		$mapped_role_names                    = array();
        
				?>
				<label class="ets-connection-lbl">
					<?php echo __( 'Discord connection', 'lifterlms-discord-addon' ); ?>
				</label><br>
				<a href="lifterlms-discord-connectToBot" class="ets-btn btn-disconnect" id="disconnect-discord" data-user-id="<?php echo esc_attr( $user_id ); ?>"><?php echo __( 'Disconnect From Discord ', 'memberpress-discord-add-on' ); ?><i class='fab fa-discord'></i></a>
				<br>
				<?php
			
				?>
				<label class="ets-connection-lbl">
					<?php echo __( 'Discord connection', 'lifterlms-discord-addon' ); ?>
				</label><br>
				<a href="?action=lifterlms-discord-login" class="btn-connect ets-btn" ><?php echo __( 'Connect To Discord', 'lifterlms-discord-addon' ); ?> <i class='fab fa-discord'></i></a>
				
				<?php
			

	}

	

		
	



	

}
