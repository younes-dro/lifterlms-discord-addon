<?php
$ets_lifterlms_discord_send_welcome_dm         = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_send_welcome_dm' ) ) );
$ets_lifterlms_discord_welcome_message         = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_welcome_message' ) ) );

$ets_lifterlms_discord_send_quiz_complete_dm   = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_send_quiz_complete_dm' ) ) );
$ets_lifterlms_discord_quiz_complete_message   = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_quiz_complete_message' ) ) );

$retry_failed_api                              = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_retry_failed_api' ) ) );
$kick_upon_disconnect                          = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_kick_upon_disconnect' ) ) );
$retry_api_count                               = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_retry_api_count' ) ) );
$set_job_cnrc                                  = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_job_queue_concurrency' ) ) );
$set_job_q_batch_size                          = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_job_queue_batch_size' ) ) );
$log_api_res                                   = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_log_api_response' ) ) );

?>
<form method="post" action="<?php echo get_site_url().'/wp-admin/admin-post.php' ?>">
 <input type="hidden" name="action" value="lifterlms_discord_save_advance_settings">
 <input type="hidden" name="current_url" value="<?php echo ets_lifterlms_discord_get_current_screen_url()?>">   
<?php wp_nonce_field( 'lifterlms_discord_advance_settings_nonce', 'ets_lifterlms_discord_advance_settings_nonce' ); ?>
  <table class="form-table" role="presentation">
	<tbody>
	<tr>
		<th scope="row"><?php echo __( 'Shortcode:', 'lifterlms-discord-addon' ); ?></th>
		<td> <fieldset>
		[lifterlms_discord]
		<br/>
		<small><?php echo __( 'Use this shortcode [lifterlms_discord] to display connect to discord button on any page.', 'lifterlms-discord-addon' ); ?></small>
		</fieldset></td>
	</tr>            
	<tr>
		<th scope="row"><?php echo __( 'Send welcome message', 'lifterlms-discord-addon' ); ?></th>
		<td> <fieldset>
		<input name="ets_lifterlms_discord_send_welcome_dm" type="checkbox" id="ets_lifterlms_discord_send_welcome_dm" 
		<?php
		if ( $ets_lifterlms_discord_send_welcome_dm == true ) {
			echo 'checked="checked"'; }
		?>
		 value="1">
		</fieldset></td>
	</tr>
	<tr>
		<th scope="row"><?php echo __( 'Welcome message', 'lifterlms-discord-addon' ); ?></th>
		<td> <fieldset>
		<textarea class="ets_lifterlms_discord_dm_textarea" name="ets_lifterlms_discord_welcome_message" id="ets_lifterlms_discord_welcome_message" row="25" cols="50"><?php if ( $ets_lifterlms_discord_welcome_message ) { echo wp_unslash( $ets_lifterlms_discord_welcome_message ); } ?></textarea> 
	<br/>
	<small>Merge fields: [LLMS_STUDENT_NAME], [LLMS_STUDENT_EMAIL], [LLMS_COURSES], [SITE_URL], [BLOG_NAME]</small>
		</fieldset></td>
	</tr>         
  <tr>
		<th scope="row"><?php echo __( 'Send Quiz Complete message', 'lifterlms-discord-addon' ); ?></th>
		<td> <fieldset>
		<input name="ets_lifterlms_discord_send_quiz_complete_dm" type="checkbox" id="ets_lifterlms_discord_send_quiz_complete_dm" 
		<?php
		if ( $ets_lifterlms_discord_send_quiz_complete_dm == true ) {
			echo 'checked="checked"'; }
		?>
		 value="1">
		</fieldset></td>
	  </tr>
	<tr>
		<th scope="row"><?php echo __( 'Quiz Complete message', 'lifterlms-discord-addon' ); ?></th>
		<td> <fieldset>
		<textarea class="ets_lifterlms_discord_quiz_complete_message" name="ets_lifterlms_discord_quiz_complete_message" id="ets_lifterlms_discord_quiz_complete_message" row="25" cols="50"><?php if ( $ets_lifterlms_discord_quiz_complete_message ) { echo wp_unslash( $ets_lifterlms_discord_quiz_complete_message ); } ?></textarea> 
	<br/>
	<small>Merge fields: [LLMS_STUDENT_NAME], [LLMS_STUDENT_EMAIL], [LLMS_QUIZ_NAME], [LLMS_QUIZ_DATE], [SITE_URL], [BLOG_NAME]</small>
		</fieldset></td>
	  </tr>
          
  <tr>
	  <tr>
		<th scope="row"><?php echo __( 'Retry Failed API calls', 'lifterlms-discord-addon' ); ?></th>
		<td> <fieldset>
		<input name="retry_failed_api" type="checkbox" id="retry_failed_api" 
		<?php
		if ( $retry_failed_api == true ) {
			echo 'checked="checked"'; }
		?>
		 value="1">
		</fieldset></td>
	  </tr>
	  <tr>
		<th scope="row"><?php echo __( 'Don\'t kick students upon disconnect', 'lifterlms-discord-addon' ); ?></th>
		<td> <fieldset>
		<input name="kick_upon_disconnect" type="checkbox" id="kick_upon_disconnect" 
		<?php
		if ( $kick_upon_disconnect == true ) {
			echo 'checked="checked"'; }
		?>
		 value="1">
		</fieldset></td>
	  </tr>
	<tr>
		<th scope="row"><?php echo __( 'How many times a failed API call should get re-try', 'lifterlms-discord-addon' ); ?></th>
		<td> <fieldset>
		<input name="ets_lifterlms_retry_api_count" type="number" min="1" id="ets_lifterlms_retry_api_count" value="<?php if ( isset( $retry_api_count ) ) { echo intval( $retry_api_count ); } else { echo 1; } ?>">
		</fieldset></td>
	  </tr> 
	  <tr>
		<th scope="row"><?php echo __( 'Set job queue concurrency', 'lifterlms-discord-addon' ); ?></th>
		<td> <fieldset>
		<input name="set_job_cnrc" type="number" min="1" id="set_job_cnrc" value="<?php if ( isset( $set_job_cnrc ) ) { echo intval( $set_job_cnrc ); } else { echo 1; } ?>">
		</fieldset></td>
	  </tr>
	  <tr>
		<th scope="row"><?php echo __( 'Set job queue batch size', 'lifterlms-discord-addon' ); ?></th>
		<td> <fieldset>
		<input name="set_job_q_batch_size" type="number" min="1" id="set_job_q_batch_size" value="<?php if ( isset( $set_job_q_batch_size ) ) { echo intval( $set_job_q_batch_size ); } else { echo 10; } ?>">
		</fieldset></td>
	  </tr>
	<tr>
		<th scope="row"><?php echo __( 'Log API calls response (For debugging purpose)', 'lifterlms-discord-addon' ); ?></th>
		<td> <fieldset>
		<input name="log_api_res" type="checkbox" id="log_api_res" 
		<?php
		if ( $log_api_res == true ) {
			echo 'checked="checked"'; }
		?>
		 value="1">
		</fieldset></td>
	  </tr>
	
	</tbody>
  </table>
  <div class="bottom-btn">
	<button type="submit" name="adv_submit" value="ets_submit" class="ets-submit ets-bg-green">
	  <?php echo __( 'Save Settings', 'lifterlms-discord-addon' ); ?>
	</button>
  </div>
</form>
