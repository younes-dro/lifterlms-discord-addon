<?php
$ets_lifterlms_discord_send_welcome_dm = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_send_welcome_dm' ) ) );
$ets_lifterlms_discord_welcome_message = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_welcome_message' ) ) );

$ets_lifterlms_discord_send_lesson_complete_dm = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_send_lesson_complete_dm' ) ) );
$ets_lifterlms_discord_lesson_complete_message = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_lesson_complete_message' ) ) );

$ets_lifterlms_discord_send_quiz_complete_dm = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_send_quiz_complete_dm' ) ) );
$ets_lifterlms_discord_quiz_complete_message = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_quiz_complete_message' ) ) );

$ets_lifterlms_discord_send_achievement_earned_dm = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_send_achievement_earned_dm' ) ) );
$ets_lifterlms_discord_achievement_earned_message = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_achievement_earned_message' ) ) );

$ets_lifterlms_discord_send_certificate_earned_dm = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_send_certificate_earned_dm' ) ) );
$ets_lifterlms_discord_certificate_earned_message = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_certificate_earned_message' ) ) );

$embed_messaging_feature = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_embed_messaging_feature' ) ) );

$retry_failed_api     = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_retry_failed_api' ) ) );
$kick_upon_disconnect = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_kick_upon_disconnect' ) ) );
$retry_api_count      = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_retry_api_count' ) ) );
$set_job_cnrc         = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_job_queue_concurrency' ) ) );
$set_job_q_batch_size = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_job_queue_batch_size' ) ) );
$log_api_res          = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_log_api_response' ) ) );

$ets_lifterlms_discord_number_of_courses = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_number_of_courses' ) ) );

?>
<form method="post" action="<?php echo esc_url( get_site_url() . '/wp-admin/admin-post.php' ); ?>">
 <input type="hidden" name="action" value="lifterlms_discord_save_advance_settings">
 <input type="hidden" name="current_url" value="<?php echo esc_url( ets_lifterlms_discord_get_current_screen_url() ); ?>">   
<?php wp_nonce_field( 'lifterlms_discord_advance_settings_nonce', 'ets_lifterlms_discord_advance_settings_nonce' ); ?>
  <table class="form-table" role="presentation">
	<tbody>
	<tr>
		<th scope="row"><?php esc_html_e( 'Shortcode:', 'connect-lifterlms-discord' ); ?></th>
		<td> <fieldset>
		[lifterlms_discord]
		<br/>
		<small><?php esc_html_e( 'Use this shortcode [lifterlms_discord] to display connect to discord button on any page.', 'connect-lifterlms-discord' ); ?></small>
		</fieldset></td>
	</tr>
	<tr>
		<th scope="row"><?php esc_html_e( 'Number of courses to return', 'connect-lifterlms-discord' ); ?></th>
		<td> 
			<fieldset>
				<?php $ets_lifterlms_discord_number_of_courses_value = isset( $ets_lifterlms_discord_number_of_courses ) ? intval( $ets_lifterlms_discord_number_of_courses ) : 20; ?>
		<input name="ets_lifterlms_discord_number_of_courses" type="number" min="1" id="ets_lifterlms_discord_number_of_courses" value="<?php echo esc_attr( $ets_lifterlms_discord_number_of_courses_value ); ?>">
		<br /><small><?php esc_html_e( 'The number of enrollments to retrieve(min : 20).', 'connect-lifterlms-discord' ); ?></small>	
		</fieldset>
	</td>
	  </tr>	 
	<tr>
		<th scope="row"><?php esc_html_e( 'Use rich embed messaging feature?', 'connect-lifterlms-discord' ); ?></th>
		<td> <fieldset>
		<input name="embed_messaging_feature" type="checkbox" id="embed_messaging_feature" 
		<?php
		if ( $embed_messaging_feature == true ) {
			echo esc_attr( 'checked="checked"' ); }
		?>
		 value="1">
				<br/>
				<small>Use [LINEBREAK] to split lines.</small>                
		</fieldset></td>
	  </tr> 	           
	<tr>
		<th scope="row"><?php esc_html_e( 'Send welcome message', 'connect-lifterlms-discord' ); ?></th>
		<td> <fieldset>
		<input name="ets_lifterlms_discord_send_welcome_dm" type="checkbox" id="ets_lifterlms_discord_send_welcome_dm" 
		<?php
		if ( $ets_lifterlms_discord_send_welcome_dm == true ) {
			echo esc_attr( 'checked="checked"' ); }
		?>
		 value="1">
		</fieldset></td>
	</tr>
	<tr>
		<th scope="row"><?php esc_html_e( 'Welcome message', 'connect-lifterlms-discord' ); ?></th>
		<td> 
			<fieldset>
				<?php $ets_lifterlms_discord_welcome_message_value = isset( $ets_lifterlms_discord_welcome_message ) ? wp_unslash( $ets_lifterlms_discord_welcome_message ) : ''; ?>
		<textarea class="ets_lifterlms_discord_dm_textarea" name="ets_lifterlms_discord_welcome_message" id="ets_lifterlms_discord_welcome_message" row="25" cols="50"><?php echo esc_textarea( $ets_lifterlms_discord_welcome_message_value ); ?></textarea> 
	<br/>
	<small>Merge fields: [LLMS_STUDENT_NAME], [LLMS_STUDENT_EMAIL], [LLMS_COURSES], [SITE_URL], [BLOG_NAME]</small>
		</fieldset></td>
	</tr>  
	<tr>
		<th scope="row"><?php esc_html_e( 'Send Lesson Complete message', 'connect-lifterlms-discord' ); ?></th>
		<td> <fieldset>
		<input name="ets_lifterlms_discord_send_lesson_complete_dm" type="checkbox" id="ets_lifterlms_discord_send_lesson_complete_dm" 
		<?php
		if ( $ets_lifterlms_discord_send_lesson_complete_dm == true ) {
			echo esc_attr( 'checked="checked"' ); }
		?>
		 value="1">
		</fieldset></td>
	  </tr>
	<tr>
		<th scope="row"><?php esc_html_e( 'Lesson Complete message', 'connect-lifterlms-discord' ); ?></th>
		<td> <fieldset>
			<?php $ets_lifterlms_discord_lesson_complete_message_value = isset( $ets_lifterlms_discord_lesson_complete_message ) ? wp_unslash( $ets_lifterlms_discord_lesson_complete_message ) : ''; ?>
		<textarea class="ets_lifterlms_discord_lesson_complete_message" name="ets_lifterlms_discord_lesson_complete_message" id="ets_lifterlms_discord_lesson_complete_message" row="25" cols="50"><?php echo esc_textarea( $ets_lifterlms_discord_lesson_complete_message_value ); ?></textarea> 
	<br/>
	<small>Merge fields: [LLMS_STUDENT_NAME], [LLMS_STUDENT_EMAIL], [LLMS_LESSON_NAME], [LLMS_LESSON_DATE], [SITE_URL], [BLOG_NAME]</small>
		</fieldset></td>
	  </tr>	       
  <tr>
		<th scope="row"><?php esc_html_e( 'Send Quiz Complete message', 'connect-lifterlms-discord' ); ?></th>
		<td> <fieldset>
		<input name="ets_lifterlms_discord_send_quiz_complete_dm" type="checkbox" id="ets_lifterlms_discord_send_quiz_complete_dm" 
		<?php
		if ( $ets_lifterlms_discord_send_quiz_complete_dm == true ) {
			echo esc_attr( 'checked="checked"' ); }
		?>
		 value="1">
		</fieldset></td>
	  </tr>
	<tr>
		<th scope="row"><?php esc_html_e( 'Quiz Complete message', 'connect-lifterlms-discord' ); ?></th>
		<td> <fieldset>
			<?php $ets_lifterlms_discord_quiz_complete_message_value = isset( $ets_lifterlms_discord_quiz_complete_message ) ? wp_unslash( $ets_lifterlms_discord_quiz_complete_message ) : ''; ?>
		<textarea class="ets_lifterlms_discord_quiz_complete_message" name="ets_lifterlms_discord_quiz_complete_message" id="ets_lifterlms_discord_quiz_complete_message" row="25" cols="50"><?php echo esc_textarea( $ets_lifterlms_discord_quiz_complete_message_value ); ?></textarea> 
	<br/>
	<small>Merge fields: [LLMS_STUDENT_NAME], [LLMS_STUDENT_EMAIL], [LLMS_QUIZ_NAME], [LLMS_QUIZ_DATE], [SITE_URL], [BLOG_NAME]</small>
		</fieldset></td>
 </tr>
 <tr>
		<th scope="row"><?php esc_html_e( 'Send Achievement Earned message', 'connect-lifterlms-discord' ); ?></th>
		<td> <fieldset>
		<input name="ets_lifterlms_discord_send_achievement_earned_dm" type="checkbox" id="ets_lifterlms_discord_send_achievement_earned_dm" 
		<?php
		if ( $ets_lifterlms_discord_send_achievement_earned_dm == true ) {
			echo esc_attr( 'checked="checked"' ); }
		?>
		 value="1">
		</fieldset></td>
	  </tr>
	<tr>
		<th scope="row"><?php esc_html_e( 'Achievement Earned message', 'connect-lifterlms-discord' ); ?></th>
		<td> <fieldset>
			<?php $ets_lifterlms_discord_achievement_earned_message_value = isset( $ets_lifterlms_discord_achievement_earned_message ) ? wp_unslash( $ets_lifterlms_discord_achievement_earned_message ) : ''; ?>
		<textarea class="ets_lifterlms_discord_achievement_earned_message" name="ets_lifterlms_discord_achievement_earned_message" id="ets_lifterlms_discord_achievement_earned_message" row="25" cols="50"><?php echo esc_textarea( $ets_lifterlms_discord_achievement_earned_message_value ); ?></textarea> 
	<br/>
	<small>Merge fields: [LLMS_STUDENT_NAME], [LLMS_STUDENT_EMAIL], [LLMS_ACHIEVEMENT_NAME], [LLMS_ACHIEVEMENT_DATE], [SITE_URL], [BLOG_NAME]</small>
		</fieldset></td>
	  </tr>
  <tr>
  <tr>
		<th scope="row"><?php esc_html_e( 'Send certificate Earned message', 'connect-lifterlms-discord' ); ?></th>
		<td> <fieldset>
		<input name="ets_lifterlms_discord_send_certificate_earned_dm" type="checkbox" id="ets_lifterlms_discord_send_certificate_earned_dm" 
		<?php
		if ( $ets_lifterlms_discord_send_certificate_earned_dm == true ) {
			echo esc_attr( 'checked="checked"' ); }
		?>
		 value="1">
		</fieldset></td>
	  </tr>
	<tr>
		<th scope="row"><?php esc_html_e( 'certificate Earned message', 'connect-lifterlms-discord' ); ?></th>
		<td> <fieldset>
			<?php $ets_lifterlms_discord_certificate_earned_message_value = isset( $ets_lifterlms_discord_achievement_earned_message ) ? wp_unslash( $ets_lifterlms_discord_certificate_earned_message ) : ''; ?>
		<textarea class="ets_lifterlms_discord_certificate_earned_message" name="ets_lifterlms_discord_certificate_earned_message" id="ets_lifterlms_discord_certificate_earned_message" row="25" cols="50"><?php echo esc_textarea( $ets_lifterlms_discord_certificate_earned_message_value ); ?></textarea> 
	<br/>
	<small>Merge fields: [LLMS_STUDENT_NAME], [LLMS_STUDENT_EMAIL], [LLMS_CERTIFICATE_TITLTE], [LLMS_CERTIFICATE_DATE], [SITE_URL], [BLOG_NAME]</small>
		</fieldset></td>
	  </tr>
  <tr>	
	  <tr>
		<th scope="row"><?php esc_html_e( 'Retry Failed API calls', 'connect-lifterlms-discord' ); ?></th>
		<td> <fieldset>
		<input name="retry_failed_api" type="checkbox" id="retry_failed_api" 
		<?php
		if ( $retry_failed_api == true ) {
			echo esc_attr( 'checked="checked"' ); }
		?>
		 value="1">
		</fieldset></td>
	  </tr>
	  <tr>
		<th scope="row"><?php esc_html_e( 'Don\'t kick students upon disconnect', 'connect-lifterlms-discord' ); ?></th>
		<td> <fieldset>
		<input name="kick_upon_disconnect" type="checkbox" id="kick_upon_disconnect" 
		<?php
		if ( $kick_upon_disconnect == true ) {
			echo esc_attr( 'checked="checked"' ); }
		?>
		 value="1">
		</fieldset></td>
	  </tr>
	<tr>
		<th scope="row"><?php esc_html_e( 'How many times a failed API call should get re-try', 'connect-lifterlms-discord' ); ?></th>
		<td> 
			<fieldset>
				<?php $retry_api_count_value = isset( $retry_api_count ) ? intval( $retry_api_count ) : 1; ?>
		<input name="ets_lifterlms_retry_api_count" type="number" min="1" id="ets_lifterlms_retry_api_count" value="<?php echo esc_attr( $retry_api_count_value ); ?>">
		</fieldset>
	</td>
	  </tr> 
	  <tr>
		<th scope="row"><?php esc_html_e( 'Set job queue concurrency', 'connect-lifterlms-discord' ); ?></th>
		<td> 
			<fieldset>
				<?php $set_job_cnrc_value = isset( $set_job_cnrc ) ? intval( $set_job_cnrc ) : 1; ?>
		<input name="set_job_cnrc" type="number" min="1" id="set_job_cnrc" value="<?php echo esc_attr( $set_job_cnrc_value ); ?>">
		</fieldset>
	</td>
	  </tr>
	  <tr>
		<th scope="row"><?php esc_html_e( 'Set job queue batch size', 'connect-lifterlms-discord' ); ?></th>
		<td> 
			<fieldset>
				<?php $set_job_q_batch_size_value = isset( $set_job_q_batch_size ) ? intval( $set_job_q_batch_size ) : 10; ?>
		<input name="set_job_q_batch_size" type="number" min="1" id="set_job_q_batch_size" value="<?php echo esc_attr( $set_job_q_batch_size_value ); ?>">
		</fieldset>
	</td>
	  </tr>
	<tr>
		<th scope="row"><?php esc_html_e( 'Log API calls response (For debugging purpose)', 'connect-lifterlms-discord' ); ?></th>
		<td> <fieldset>
		<input name="log_api_res" type="checkbox" id="log_api_res" 
		<?php
		if ( $log_api_res == true ) {
			echo esc_attr( 'checked="checked"' ); }
		?>
		 value="1">
		</fieldset></td>
	  </tr>
	  <tr>
	  <th scope="row"><?php esc_html_e( 'Update Discord Roles for All students', 'connect-lifterlms-discord' ); ?></th>
	  <td> <fieldset>
		<button id="update-discord-roles-for-all-students"><?php esc_html_e( 'RUN', 'connect-lifterlms-discord' ); ?></button>
		<span></span>
	  </fieldset></td>
	  </tr>
	  <tr>
	  <th scope="row"><?php esc_html_e( 'Update Discord Roles for All students', 'connect-lifterlms-discord' ); ?></th>
	  <td> <fieldset>
		<button id="disconnect-all-students"><?php esc_html_e( 'Disconnect all students', 'connect-lifterlms-discord' ); ?></button>
		<span></span>
	  </fieldset></td>
	  </tr>
	
	</tbody>
  </table>
  <div class="bottom-btn">
	<button type="submit" name="adv_submit" value="ets_submit" class="ets-submit ets-bg-green">
	  <?php esc_html_e( 'Save Settings', 'connect-lifterlms-discord' ); ?>
	</button>
  </div>
</form>
