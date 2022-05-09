<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.expresstechsoftwares.com
 * @since      1.0.0
 *
 * @package    Lifterlms_Discord_Addon
 * @subpackage Lifterlms_Discord_Addon/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Lifterlms_Discord_Addon
 * @subpackage Lifterlms_Discord_Addon/includes
 * @author     ExpressTech Softwares Solutions Pvt Ltd <contact@expresstechsoftwares.com>
 */
class Lifterlms_Discord_Addon_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		update_option( 'ets_lifterlms_discord_uuid_file_name', wp_generate_uuid4() );
		update_option( 'ets_lifterlms_discord_send_welcome_dm', true );
		update_option( 'ets_lifterlms_discord_welcome_message', 'Hi [LLMS_STUDENT_NAME] ([LLMS_STUDENT_EMAIL]), Welcome, Your courses [LLMS_COURSES] at [SITE_URL] Thanks, Kind Regards, [BLOG_NAME]' );                		
		update_option( 'ets_lifterlms_discord_retry_failed_api', true );
		update_option( 'ets_lifterlms_discord_kick_upon_disconnect', false ); 
		update_option( 'ets_lifterlms_discord_retry_api_count', 5 );
		update_option( 'ets_lifterlms_discord_job_queue_concurrency', 1 );
		update_option( 'ets_lifterlms_discord_job_queue_batch_size', 6 );
		update_option( 'ets_lifterlms_discord_log_api_response', false );    
	}

}
