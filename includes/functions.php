<?php

/**
 * List of pages to define as url redirect.
 *
 * @param INT $ets_lifterlms_discord_redirect_page_id Page ID.
 * @return STRING html options.
 */
function ets_lifterlms_discord_pages_list( $ets_lifterlms_discord_redirect_page_id ) {
	$args  = array(
		'sort_order'   => 'asc',
		'sort_column'  => 'post_title',
		'hierarchical' => 1,
		'exclude'      => '',
		'include'      => '',
		'meta_key'     => '',
		'meta_value'   => '',
		'exclude_tree' => '',
		'number'       => '',
		'offset'       => 0,
		'post_type'    => 'page',
		'post_status'  => 'publish',
	);
	$pages = get_pages( $args );

	$options = '<option value="-">-</option>';
	foreach ( $pages as $page ) {
		$selected = ( esc_attr( $page->ID ) === $ets_lifterlms_discord_redirect_page_id ) ? ' selected="selected"' : '';
		$options .= '<option data-page-url="' . ets_get_lifterlms_discord_formated_discord_redirect_url( $page->ID ) . '" value="' . esc_attr( $page->ID ) . '" ' . $selected . '> ' . $page->post_title . ' </option>';
	}
	return $options;
}

/**
 *  Get-URL.
 *
 *  @param INT $page_id The ID of the page.
 *
 * @return STRING URL.
 */
function ets_get_lifterlms_discord_formated_discord_redirect_url( $page_id ) {

	$url    = esc_url( get_permalink( $page_id ) );
	$parsed = parse_url( $url, PHP_URL_QUERY );
	if ( $parsed === null ) {
		return $url .= '?via=connect-lifterlms-discord';
	} else {
		if ( stristr( $url, 'via=connect-lifterlms-discord' ) !== false ) {
			return $url;
		} else {
			return $url .= '&via=connect-lifterlms-discord';
		}
	}
}

/**
 * Get the current screen url.
 *
 * @return STRING The url.
 */
function ets_lifterlms_discord_get_current_screen_url() {
	$parts       = parse_url( home_url() );
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
	$log_api_response = get_option( 'ets_lifterlms_discord_log_api_response' );
	if ( $log_api_response == true ) {
		$log_string  = '==>' . $api_url;
		$log_string .= '-::-' . serialize( $api_args );
		$log_string .= '-::-' . serialize( $api_response );
		$log         = new Lifterlms_Discord_Addon_Logs();
		$log->write_api_response_logs( $log_string, $user_id );

	}
}

/**
 * Add API error logs into log file
 *
 * @param ARRAY  $response_arr
 * @param INT    $user_id
 * @param ARRAY  $backtrace_arr
 * @param string $error_type
 *
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
	$ets_lifterlms_discord_server_id     = get_option( 'ets_lifterlms_discord_server_id' );

	if ( $ets_lifterlms_discord_client_id && $ets_lifterlms_discord_client_secret && $ets_lifterlms_discord_bot_token && $ets_lifterlms_discord_redirect_url && $ets_lifterlms_discord_server_id ) {
			$status = true;
	} else {
			 $status = false;
	}

		 return $status;
}

/**
 * Get the highest available last attempt schedule time.
 *
 * @return BOOL
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
 * Get pending jobs.
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

/**
 * Get failed actions.
 */
function ets_lifterlms_discord_get_all_failed_actions() {
	global $wpdb;
	$result = $wpdb->get_results( $wpdb->prepare( 'SELECT aa.action_id, aa.hook, ag.slug AS as_group FROM ' . $wpdb->prefix . 'actionscheduler_actions as aa INNER JOIN ' . $wpdb->prefix . 'actionscheduler_groups as ag ON aa.group_id=ag.group_id WHERE  ag.slug=%s AND aa.status = "failed" ', LIFTERLMS_DISCORD_AS_GROUP_NAME ), ARRAY_A );

	if ( ! empty( $result ) ) {
		return $result;
	} else {
		return false;
	}
}

/**
 * Check API call response and detect conditions which can cause of action failure and retry should be attemped.
 *
 * @param ARRAY|OBJECT $api_response
 * @param BOOLEAN
 */
function ets_lifterlms_discord_check_api_errors( $api_response ) {
	// check if response code is a WordPress error.
	if ( is_wp_error( $api_response ) ) {
		return true;
	}

	// First Check if response contain codes which should not get re-try.
	$body = json_decode( wp_remote_retrieve_body( $api_response ), true );
	if ( isset( $body['code'] ) && in_array( $body['code'], LIFTERLMS_DISCORD_DONOT_RETRY_THESE_API_CODES ) ) {
		return false;
	}

	$response_code = strval( $api_response['response']['code'] );
	if ( isset( $api_response['response']['code'] ) && in_array( $response_code, LIFTERLMS_DISCORD_DONOT_RETRY_HTTP_CODES ) ) {
		return false;
	}

	// check if response code is in the range of HTTP error.
	if ( ( 400 <= absint( $response_code ) ) && ( absint( $response_code ) <= 599 ) ) {
		return true;
	}
}

/**
 * Get how many times a hook is failed in a particular day.
 *
 * @param STRING $hook
 */
function ets_lifterlms_discord_count_of_hooks_failures( $hook ) {
	global $wpdb;
	$result = $wpdb->get_results( $wpdb->prepare( 'SELECT count(last_attempt_gmt) as hook_failed_count FROM ' . $wpdb->prefix . 'actionscheduler_actions WHERE `hook`=%s AND status="failed" AND DATE(last_attempt_gmt) = %s', $hook, date( 'Y-m-d' ) ), ARRAY_A );

	if ( ! empty( $result ) ) {
		return $result['0']['hook_failed_count'];
	} else {
		return false;
	}
}

/**
 * Get formatted message to send in DM
 *
 * @param INT   $user_id
 * @param ARRAY $courses the student's list of sources
 * Merge fields: [LLMS_COURSES], [LLMS_STUDENT_NAME], [LLMS_STUDENT_EMAIL]
 */
function ets_lifterlms_discord_get_formatted_dm( $user_id, $courses, $message ) {

	$user_obj         = get_user_by( 'id', $user_id );
	$STUDENT_USERNAME = sanitize_text_field( $user_obj->user_login );
	$STUDENT_EMAIL    = sanitize_email( $user_obj->user_email );
	$SITE_URL         = esc_url( get_bloginfo( 'url' ) );
	$BLOG_NAME        = sanitize_text_field( get_bloginfo( 'name' ) );

	$COURSES = '';
	if ( is_array( $courses ) ) {
		$args_courses     = array(
			'orderby'     => 'title',
			'order'       => 'ASC',
			'numberposts' => count( $courses ),
			'post_type'   => 'course',
			'post__in'    => $courses,
		);
		$enrolled_courses = get_posts( $args_courses );
		$lastKeyCourse    = array_key_last( $enrolled_courses );
		$commas           = ', ';
		foreach ( $enrolled_courses as $key => $course ) {
			if ( $lastKeyCourse === $key ) {
				$commas = ' ';
			}
			$COURSES .= esc_html( $course->post_title ) . $commas;
		}
	} else {
		$enrolled_course = get_post( $courses );
		$COURSES        .= ( ! empty( ( $enrolled_course->post_title ) ) ) ? esc_html( $enrolled_course->post_title ) : '';
	}

		$find    = array(
			'[LLMS_COURSES]',
			'[LLMS_STUDENT_NAME]',
			'[LLMS_STUDENT_EMAIL]',
			'[SITE_URL]',
			'[BLOG_NAME]',
		);
		$replace = array(
			$COURSES,
			$STUDENT_USERNAME,
			$STUDENT_EMAIL,
			$SITE_URL,
			$BLOG_NAME,
		);

		return str_replace( $find, $replace, $message );

}

/**
 * Get formatted LESSON complete message to send in DM
 *
 * @param int    $user_id WP User ID.
 * @param int    $lesson_id    WP Post ID of the Lesson.
 * @param string $message The Lesson message to send.
 *
 * Merge fields: [LLMS_STUDENT_NAME], [LLMS_STUDENT_EMAIL], [LLMS_QUIZ_NAME], [LLMS_QUIZ_DATE]
 */
function ets_lifterlms_discord_get_formatted_lesson_complete_dm( $user_id, $lesson_id, $message ) {

	$user_obj         = get_user_by( 'id', $user_id );
	$STUDENT_USERNAME = sanitize_text_field( $user_obj->user_login );
	$STUDENT_EMAIL    = sanitize_email( $user_obj->user_email );
	$SITE_URL         = esc_url( get_bloginfo( 'url' ) );
	$BLOG_NAME        = sanitize_text_field( get_bloginfo( 'name' ) );

	$lesson      = get_post( $lesson_id );
	$LESSON_NAME = sanitize_text_field( $lesson->post_title );

	$LESSON_COMPLETE_DATE = date_i18n( get_option( 'date_format' ), time() );

		$find    = array(
			'[LLMS_LESSON_NAME]',
			'[LLMS_LESSON_DATE]',
			'[LLMS_STUDENT_NAME]',
			'[LLMS_STUDENT_EMAIL]',
			'[SITE_URL]',
			'[BLOG_NAME]',
		);
		$replace = array(
			$LESSON_NAME,
			$LESSON_COMPLETE_DATE,
			$STUDENT_USERNAME,
			$STUDENT_EMAIL,
			$SITE_URL,
			$BLOG_NAME,
		);

		return str_replace( $find, $replace, $message );

}
/**
 * Get formatted QUIZ complete message to send in DM
 *
 * @param int $user_id WP User ID.
 * @param int $quiz_id    WP Post ID of the quiz.
 * @param obj $attempt    Instance of the LLMS_Quiz_Attempt.
 * Merge fields: [LLMS_STUDENT_NAME], [LLMS_STUDENT_EMAIL], [LLMS_QUIZ_NAME], [LLMS_QUIZ_DATE]
 */
function ets_lifterlms_discord_get_formatted_quiz_complete_dm( $user_id, $quiz_id, $attempt, $message ) {

	$user_obj         = get_user_by( 'id', $user_id );
	$STUDENT_USERNAME = sanitize_text_field( $user_obj->user_login );
	$STUDENT_EMAIL    = sanitize_email( $user_obj->user_email );
	$SITE_URL         = esc_url( get_bloginfo( 'url' ) );
	$BLOG_NAME        = sanitize_text_field( get_bloginfo( 'name' ) );

	// $quiz      = get_post( $quiz_id );

	$quiz = llms_get_post( $quiz_id );

	$passing_percent = $quiz->get( 'passing_percent' );
	$QUIZ_NAME       = sanitize_text_field( $quiz->post_title );

	$QUIZ_COMPLETE_DATE = date_i18n( get_option( 'date_format' ), time() );

		$find    = array(
			'[LLMS_QUIZ_NAME]',
			'[LLMS_QUIZ_DATE]',
			'[LLMS_STUDENT_NAME]',
			'[LLMS_STUDENT_EMAIL]',
			'[SITE_URL]',
			'[BLOG_NAME]',
		);
		$replace = array(
			$QUIZ_NAME,
			$QUIZ_COMPLETE_DATE,
			$STUDENT_USERNAME,
			$STUDENT_EMAIL,
			$SITE_URL,
			$BLOG_NAME,
		);

		return str_replace( $find, $replace, $message );

}

/**
 * Send formatted achievement message.
 *
 * @param int    $user_id Student's id.
 * @param int    $achievement_id Achievement's id.
 * @param int    $related_post_id Related post id.
 * @param string $message The message.
 */
function ets_lifterlms_discord_get_formatted_achievement_earned_dm( $user_id, $achievement_id, $related_post_id, $message ) {
	// return $user_id .'-'. $achievement_id .'-'. $related_post_id .'-'. $message;
	$user_obj         = get_user_by( 'id', $user_id );
	$STUDENT_USERNAME = sanitize_text_field( $user_obj->user_login );
	$STUDENT_EMAIL    = sanitize_email( $user_obj->user_email );
	$SITE_URL         = esc_url( get_bloginfo( 'url' ) );
	$BLOG_NAME        = sanitize_text_field( get_bloginfo( 'name' ) );

	$achievement      = get_post( $achievement_id );
	$ACHIEVEMENT_NAME = sanitize_text_field( $achievement->post_title );

	$ACHIEVEMENT_COMPLETE_DATE = date_i18n( get_option( 'date_format' ), time() );

		$find    = array(
			'[LLMS_ACHIEVEMENT_NAME]',
			'[LLMS_ACHIEVEMENT_DATE]',
			'[LLMS_STUDENT_NAME]',
			'[LLMS_STUDENT_EMAIL]',
			'[SITE_URL]',
			'[BLOG_NAME]',
		);
		$replace = array(
			$ACHIEVEMENT_NAME,
			$ACHIEVEMENT_COMPLETE_DATE,
			$STUDENT_USERNAME,
			$STUDENT_EMAIL,
			$SITE_URL,
			$BLOG_NAME,
		);

		return str_replace( $find, $replace, $message );
}

/**
 * Send formatted certificate message.
 *
 * @param int    $user_id Student's id.
 * @param int    $certificate_id Achievement's id.
 * @param int    $related_post_id Related post id.
 * @param string $message The message.
 */
function ets_lifterlms_discord_get_formatted_certificate_earned_dm( $user_id, $certificate_id, $related_post_id, $message ) {

	$user_obj         = get_user_by( 'id', $user_id );
	$STUDENT_USERNAME = sanitize_text_field( $user_obj->user_login );
	$STUDENT_EMAIL    = sanitize_email( $user_obj->user_email );
	$SITE_URL         = esc_url( get_bloginfo( 'url' ) );
	$BLOG_NAME        = sanitize_text_field( get_bloginfo( 'name' ) );

	$certificate       = get_post( $certificate_id );
	$CERTIFICATE_TITLE = sanitize_text_field( $certificate->post_title );

	$CERTIFICATE_COMPLETE_DATE = date_i18n( get_option( 'date_format' ), time() );

		$find    = array(
			'[LLMS_CERTIFICATE_TITLE]',
			'[LLMS_CERTIFICATE_DATE]',
			'[LLMS_STUDENT_NAME]',
			'[LLMS_STUDENT_EMAIL]',
			'[SITE_URL]',
			'[BLOG_NAME]',
		);
		$replace = array(
			$CERTIFICATE_TITLE,
			$CERTIFICATE_COMPLETE_DATE,
			$STUDENT_USERNAME,
			$STUDENT_EMAIL,
			$SITE_URL,
			$BLOG_NAME,
		);

		return str_replace( $find, $replace, $message );
}

/**
 * Send Quiz Attempt details.
 *
 * @param int    $user_id
 * @param object $attempt
 */
function ets_lifterlms_discord_get_formatted_quiz_attempt_dm( $user_id, $attempt ) {

	$user_obj         = get_user_by( 'id', $user_id );
	$STUDENT_USERNAME = sanitize_text_field( $user_obj->user_login );
	$STUDENT_EMAIL    = sanitize_email( $user_obj->user_email );
	$SITE_URL         = esc_url( get_bloginfo( 'url' ) );
	$BLOG_NAME        = sanitize_text_field( get_bloginfo( 'name' ) );

	$message = sprintf( esc_html__( 'Hi %1$s , Your Attempt : ', 'connect-lifterlms-discord' ), $STUDENT_USERNAME );

	 $message .= sprintf( esc_html__( 'Correct Answers: %1$d / %2$d', 'connect-lifterlms-discord' ), $attempt->get_count( 'correct_answers' ), $attempt->get_count( 'gradeable_questions' ) );
	 $message .= sprintf( esc_html__( 'Completed: %s', 'connect-lifterlms-discord' ), $attempt->get_date( 'start' ) );
	 $message .= sprintf( esc_html__( 'Total time: %s', 'connect-lifterlms-discord' ), $attempt->get_time() );

	 return 'Attempt';

}
/**
 * Send DM message Rich Embed .
 *
 * @param string $message The message to send.
 */
function ets_lifterlms_discord_get_rich_embed_message( $message ) {

	$blog_logo_full      = is_array( wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' ) ) ? esc_url( wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'full' )[0] ) : '';
	$blog_logo_thumbnail = is_array( wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'thumbnail' ) ) ? esc_url( wp_get_attachment_image_src( get_theme_mod( 'custom_logo' ), 'thumbnail' )[0] ) : '';

	$SITE_URL         = get_bloginfo( 'url' );
	$BLOG_NAME        = get_bloginfo( 'name' );
	$BLOG_DESCRIPTION = get_bloginfo( 'description' );

	$timestamp     = date( 'c', strtotime( 'now' ) );
	$convert_lines = preg_split( '/\[LINEBREAK\]/', $message );
	$fields        = array();
	if ( is_array( $convert_lines ) ) {
		for ( $i = 0; $i < count( $convert_lines ); $i++ ) {
			array_push(
				$fields,
				array(
					'name'   => '.',
					'value'  => $convert_lines[ $i ],
					'inline' => false,
				)
			);
		}
	}

	$rich_embed_message = json_encode(
		array(
			'content'    => '',
			'username'   => $BLOG_NAME,
			'avatar_url' => $blog_logo_thumbnail,
			'tts'        => false,
			'embeds'     => array(
				array(
					'title'       => '',
					'type'        => 'rich',
					'description' => $BLOG_DESCRIPTION,
					'url'         => '',
					'timestamp'   => $timestamp,
					'color'       => hexdec( '3366ff' ),
					'footer'      => array(
						'text'     => $BLOG_NAME,
						'icon_url' => $blog_logo_thumbnail,
					),
					'image'       => array(
						'url' => $blog_logo_full,
					),
					'thumbnail'   => array(
						'url' => $blog_logo_thumbnail,
					),
					'author'      => array(
						'name' => $BLOG_NAME,
						'url'  => $SITE_URL,
					),
					'fields'      => $fields,

				),
			),

		),
		JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
	);

	return $rich_embed_message;
}

/**
 * Get student's enrolled course.
 *
 * @param INT $user_id
 *
 * @return ARRAY|NULL
 */
function ets_lifterlms_discord_get_student_courses_id( $user_id = '' ) {
	if ( ! $user_id ) {
		return null;
	}
	$number_of_courses = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_number_of_courses' ) ) );
	$student           = llms_get_student( $user_id );
	$user_courses      = $student->get_courses(
		array(
			'limit'  => $number_of_courses,
			'status' => 'enrolled',
		)
	)['results'];
	if ( $user_courses ) {
		return $user_courses;
	} else {
		return null;
	}
}

/**
 * Get student's expired course.
 *
 * @param INT $user_id
 *
 * @return ARRAY|NULL
 */
function ets_lifterlms_discord_get_student_expired_courses_id( $user_id = '' ) {
	if ( ! $user_id ) {
		return null;
	}
	$number_of_courses = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_number_of_courses' ) ) );
	$student           = llms_get_student( $user_id );
	$user_courses      = $student->get_courses(
		array(
			'limit'  => $number_of_courses,
			'status' => 'expired',
		)
	)['results'];
	if ( $user_courses ) {
		return $user_courses;
	} else {
		return null;
	}
}
/**
 * Get student's cancelled course.
 *
 * @param INT $user_id
 *
 * @return ARRAY|NULL
 */
function ets_lifterlms_discord_get_student_cancelled_courses_id( $user_id = '' ) {
	if ( ! $user_id ) {
		return null;
	}
	$number_of_courses = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_number_of_courses' ) ) );
	$student           = llms_get_student( $user_id );
	$user_courses      = $student->get_courses(
		array(
			'limit'  => $number_of_courses,
			'status' => 'cancelled',
		)
	)['results'];
	if ( $user_courses ) {
		return $user_courses;
	} else {
		return null;
	}
}

/**
 * The roles assigned message displayed under Connect / Disconnect to discord button.
 *
 * @param STRING $mapped_role_name
 * @param STRING $default_role_name
 * @param STRING $restrictcontent_discord
 *
 * @return STRING Escaped message.
 */
function ets_lifterlms_discord_roles_assigned_message( $mapped_role_name, $default_role_name, $restrictcontent_discord ) {

	if ( $mapped_role_name ) {
		$restrictcontent_discord .= '<p class="ets_assigned_role">';

		$restrictcontent_discord .= __( 'Following Roles will be assigned to you in Discord: ', 'connect-lifterlms-discord' );
		$restrictcontent_discord .= ets_lifterlms_discord_allowed_html( $mapped_role_name );
		if ( $default_role_name ) {
			$restrictcontent_discord .= ets_lifterlms_discord_allowed_html( $default_role_name );

		}

		$restrictcontent_discord .= '</p>';
	} elseif ( $default_role_name ) {
		$restrictcontent_discord .= '<p class="ets_assigned_role">';

		$restrictcontent_discord .= esc_html__( 'Following Role will be assigned to you in Discord: ', 'connect-lifterlms-discord' );
		$restrictcontent_discord .= ets_lifterlms_discord_allowed_html( $default_role_name );

		$restrictcontent_discord .= '</p>';

	}
	return $restrictcontent_discord;
}
/**
 * Get student's roles ids
 *
 * @param INT $user_id
 * @return ARRAY|NULL $roles
 */
function ets_lifterlms_discord_get_user_roles( $user_id ) {
	global $wpdb;

	$usermeta_table     = $wpdb->prefix . 'usermeta';
	$user_roles_sql     = 'SELECT * FROM ' . $usermeta_table . " WHERE `user_id` = %d AND ( `meta_key` like '_ets_lifterlms_discord_role_id_for_%' OR `meta_key` = 'ets_lifterlms_discord_default_role_id' OR `meta_key` = '_ets_lifterlms_discord_last_default_role' ); ";
	$user_roles_prepare = $wpdb->prepare( $user_roles_sql, $user_id );

	$user_roles = $wpdb->get_results( $user_roles_prepare, ARRAY_A );

	if ( is_array( $user_roles ) && count( $user_roles ) ) {
		$roles = array();
		foreach ( $user_roles as  $role ) {

			array_push( $roles, $role['meta_value'] );
		}

				return $roles;

	} else {

		return null;
	}

}

/**
 * Remove user meta.
 *
 * @param INT $user_id
 */
function ets_lifterlms_discord_remove_usermeta( $user_id ) {

	global $wpdb;

	$usermeta_table      = $wpdb->prefix . 'usermeta';
	$usermeta_sql        = 'DELETE FROM ' . $usermeta_table . " WHERE `user_id` = %d AND  `meta_key` LIKE '_ets_lifterlms_discord%'; ";
	$delete_usermeta_sql = $wpdb->prepare( $usermeta_sql, $user_id );
	$wpdb->query( $delete_usermeta_sql );

}

/**
 * Allowed html.
 *
 * @param STRING $html_message
 *
 * @return STRING $html_message
 */
function ets_lifterlms_discord_allowed_html( $html_message ) {
	$allowed_html = array(
		'div'    => array(
			'class' => array(),
		),
		'h3'     => array(),
		'p'      => array(),
		'button' => array(
			'id'           => array(),
			'data-user-id' => array(),
			'class'        => array(),
		),
		'span'   => array(),
		'i'      => array(
			'style' => array(),
		),
		'img'    => array(
			'src'   => array(),
			'class' => array(),
		),
	);

	return wp_kses( $html_message, $allowed_html );
}

/**
 * Get discord user avatar.
 *
 * @param INT    $discord_user_id
 * @param STRING $user_avatar
 * @param STRING $restrictcontent_discord
 *
 * @return STRING
 */
function ets_lifterlms_discord_get_user_avatar( $discord_user_id, $user_avatar, $restrictcontent_discord ) {
	if ( $user_avatar ) {
		$avatar_url               = '<img class="ets-lifterlms-discord-user-avatar" src="https://cdn.discordapp.com/avatars/' . $discord_user_id . '/' . $user_avatar . '.png" />';
		$restrictcontent_discord .= ets_lifterlms_discord_allowed_html( $avatar_url );
	}
	return $restrictcontent_discord;
}
