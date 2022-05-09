<?php
function ets_lifterlms_discord_pages_list( $ets_lifterlms_discord_redirect_page_id ){
    $args = array(
    'sort_order' => 'asc',
    'sort_column' => 'post_title',
    'hierarchical' => 1,
    'exclude' => '',
    'include' => '',
    'meta_key' => '',
    'meta_value' => '',
    'exclude_tree' => '',
    'number' => '',
    'offset' => 0,
    'post_type' => 'page',
    'post_status' => 'publish'
    );
    $pages = get_pages($args);

    $options = '<option value="" disabled>-</option>';
    foreach($pages as $page){ 
    $selected = ( esc_attr( $page->ID ) === $ets_lifterlms_discord_redirect_page_id  ) ? ' selected="selected"' : '';
    $options .= '<option data-page-url="' . ets_get_lifterlms_discord_formated_discord_redirect_url ( $page->ID ) .'" value="' . esc_attr( $page->ID ) . '" '. $selected .'> ' . $page->post_title . ' </option>';
}
    return $options;
}

/**
 *  Get-URL 
 */
function ets_get_lifterlms_discord_formated_discord_redirect_url( $page_id ) {
    
    $url = esc_url( get_permalink( $page_id) );
	$parsed = parse_url( $url, PHP_URL_QUERY );
	if ( $parsed === null ) {
		return $url .= '?via=lifterlms-discord';
	} else {
		if ( stristr( $url, 'via=lifterlms-discord' ) !== false ) {
			return $url;
		} else {
			return $url .= '&via=lifterlms-discord';
		}
	}
}

function ets_lifterlms_discord_get_current_screen_url()
{
    $parts = parse_url( home_url() );
    $current_uri = "{$parts['scheme']}://{$parts['host']}" . ( isset( $parts['port'] ) ? ':' . $parts['port'] : '' ) . add_query_arg( null, null );
        return $current_uri;
}

/**
 * Log API call response
 *
 * @param INT          $user_id
 * @param STRING       $api_url
 * @param ARRAY        $api_args
 * @param ARRAY|OBJECT $api_response
 */
function ets_lifterlms_discord_log_api_response( $user_id, $api_url = '', $api_args = array(), $api_response = '' ) {
	$log_api_response = get_option( 'ets_memberpress_discord_log_api_response' );
	if ( $log_api_response == true ) {
		$log_string  = '==>' . $api_url;
		$log_string .= '-::-' . serialize( $api_args );
		$log_string .= '-::-' . serialize( $api_response );
		ets_lifterlms_write_api_response_logs( $log_string, $user_id );
	}
}

/**
 * Add API error logs into log file
 *
 * @param array  $response_arr
 * @param array  $backtrace_arr
 * @param string $error_type
 * @return None
 */
function ets_lifterlms_write_api_response_logs( $response_arr, $user_id, $backtrace_arr = array() ) {
	$error        = current_time( 'mysql' );
	$user_details = '';
	if ( $user_id ) {
		$user_details = '::User Id:' . $user_id;
	}
	$log_api_response = get_option( 'ets_lifterlms_discord_log_api_response' );
	$uuid             = get_option( 'ets_lifterlms_discord_uuid_file_name' );
	$log_file_name    = $uuid . Lifterlms_Discord_Addon_Admin::$log_file_name;

	if ( is_array( $response_arr ) && array_key_exists( 'code', $response_arr ) ) {
		$error .= '==>File:' . $backtrace_arr['file'] . $user_details . '::Line:' . $backtrace_arr['line'] . '::Function:' . $backtrace_arr['function'] . '::' . $response_arr['code'] . ':' . $response_arr['message'];
		file_put_contents( WP_CONTENT_DIR . '/' . $log_file_name, $error . PHP_EOL, FILE_APPEND | LOCK_EX );
	} elseif ( is_array( $response_arr ) && array_key_exists( 'error', $response_arr ) ) {
		$error .= '==>File:' . $backtrace_arr['file'] . $user_details . '::Line:' . $backtrace_arr['line'] . '::Function:' . $backtrace_arr['function'] . '::' . $response_arr['error'];
		file_put_contents( WP_CONTENT_DIR . '/' . $log_file_name, $error . PHP_EOL, FILE_APPEND | LOCK_EX );
	} elseif ( $log_api_response == true ) {
		$error .= json_encode( $response_arr ) . '::' . $user_id;
		file_put_contents( WP_CONTENT_DIR . '/' . $log_file_name, $error . PHP_EOL, FILE_APPEND | LOCK_EX );
	}

}

/**
 * To check settings values saved or not
 *
 * @param NONE
 * @return BOOL $status
 */
function ets_lifterlms_discord_check_saved_settings_status() {
	$ets_lifterlms_discord_client_id     = get_option( 'ets_lifterlms_discord_client_id' );
	$ets_lifterlms_discord_client_secret = get_option( 'ets_lifterlms_discord_client_secret' );
	$ets_lifterlms_discord_bot_token     = get_option( 'ets_lifterlms_discord_bot_token' );
	$ets_lifterlms_discord_redirect_url  = get_option( 'ets_lifterlms_discord_redirect_url' );
	$ets_lifterlms_discord_server_id      = get_option( 'ets_lifterlms_discord_server_id' );

	if ( $ets_lifterlms_discord_client_id && $ets_lifterlms_discord_client_secret && $ets_lifterlms_discord_bot_token && $ets_lifterlms_discord_redirect_url && $ets_lifterlms_discord_server_id ) {
			$status = true;
	} else {
			 $status = false;
	}

		 return $status;
}

/**
 * Get the highest available last attempt schedule time
 */

function ets_lifterlms_discord_get_highest_last_attempt_timestamp() {
	global $wpdb;
	$result = $wpdb->get_results( $wpdb->prepare( 'SELECT aa.last_attempt_gmt FROM ' . $wpdb->prefix . 'actionscheduler_actions as aa INNER JOIN ' . $wpdb->prefix . 'actionscheduler_groups as ag ON aa.group_id = ag.group_id WHERE ag.slug = %s ORDER BY aa.last_attempt_gmt DESC limit 1', LIFTERLMS_DISCORD_AS_GROUP_NAME ), ARRAY_A );

	if ( ! empty( $result ) ) {
		return strtotime( $result['0']['last_attempt_gmt'] );
	} else {
		return false;
	}
}

/**
 * Get randon integer between a predefined range.
 *
 * @param INT $add_upon
 */
function ets_lifterlms_discord_get_random_timestamp( $add_upon = '' ) {
	if ( $add_upon != '' && $add_upon !== false ) {
		return $add_upon + random_int( 5, 15 );
	} else {
		return strtotime( 'now' ) + random_int( 5, 15 );
	}
}

/**
 * Get Action data from table `actionscheduler_actions`
 *
 * @param INT $action_id
 */
function ets_lifterlms_discord_as_get_action_data( $action_id ) {
	global $wpdb;
	$result = $wpdb->get_results( $wpdb->prepare( 'SELECT aa.hook, aa.status, aa.args, ag.slug AS as_group FROM ' . $wpdb->prefix . 'actionscheduler_actions as aa INNER JOIN ' . $wpdb->prefix . 'actionscheduler_groups as ag ON aa.group_id=ag.group_id WHERE `action_id`=%d AND ag.slug=%s', $action_id, LIFTERLMS_DISCORD_AS_GROUP_NAME ), ARRAY_A );
        
	if ( ! empty( $result ) ) {
		return $result[0];
	} else {
		return false;
	}
}

/**
 * Get pending jobs 
 */
function ets_lifterlms_discord_get_all_pending_actions() {
	global $wpdb;
	$result = $wpdb->get_results( $wpdb->prepare( 'SELECT aa.* FROM ' . $wpdb->prefix . 'actionscheduler_actions as aa INNER JOIN ' . $wpdb->prefix . 'actionscheduler_groups as ag ON aa.group_id = ag.group_id WHERE ag.slug = %s AND aa.status="pending" ', LIFTERLMS_DISCORD_AS_GROUP_NAME ), ARRAY_A );

	if ( ! empty( $result ) ) {
		return $result['0'];
	} else {
		return false;
	}
}

function ets_lifterlms_discord_get_all_failed_actions(){
	global $wpdb;
	$result = $wpdb->get_results( $wpdb->prepare( 'SELECT aa.action_id, aa.hook, ag.slug AS as_group FROM ' . $wpdb->prefix . 'actionscheduler_actions as aa INNER JOIN ' . $wpdb->prefix . 'actionscheduler_groups as ag ON aa.group_id=ag.group_id WHERE  ag.slug=%s AND aa.status = "failed" ' , LIFTERLMS_DISCORD_AS_GROUP_NAME ), ARRAY_A );

	if ( ! empty( $result ) ) {
		return $result ;
	} else {
		return false;
	}        
}

?>