<?php

$user_id = sanitize_text_field( trim( get_current_user_id() ) );
/**
 * Get All Courses form database
*/
$get_courses_lifterlms = get_posts(
	array(
		'post_type'   => 'course',
		'order'       => 'DESC',
		'orderby'     => 'title',
		'numberposts' => -1,
		'post_status' => 'publish',
	)
);

$default_role      = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_default_role_id' ) ) );
$allow_none_member = sanitize_text_field( trim( get_option( 'ets_lifterlms_allow_none_member' ) ) );

?>
 <!-- Drag and Drop the Discord Roles  -->

<div class="notice notice-warning ets-notice">
	<p>
		<i class='fas fa-info'></i>
		<?php esc_html_e( 'Drag and Drop the Discord Roles over to the LifterLMS Courses', 'lifterlms-discord-addon' ); ?>
	</p>
</div>

<!-- Create two equal columns that floats next to each other -->

<div class="row-container">

	<div class="ets-column discord-roles-col">
		<h2><?php esc_html_e( 'Discord Roles', 'lifterlms-discord-addon' ); ?></h2>
		<hr>
			<div class="discord-roles">
				<span class="spinner"></span>
			</div>
	</div>
	<div class="ets-column">
		<h2><?php esc_html_e( 'LifterLMS Courses ', 'lifterlms-discord-addon' ); ?></h2>
		<hr>

		<?php
		foreach ( array_reverse( $get_courses_lifterlms ) as $key => $value ) {
			?>
				<div class="makeMeDroppable" data-course_id="<?php echo esc_attr( $value->ID ); ?>" ><span><?php echo esc_html( $value->post_title ); ?></span></div>
				<?php
		}
		?>

	</div>

</div>

<form method="post" action="<?php echo esc_url( get_site_url() . '/wp-admin/admin-post.php' ); ?>">
	<input type="hidden" name="action" value="lifterlms_discord_role_mapping">
	<input type="hidden" name="current_url_role" value="<?php echo esc_url( ets_lifterlms_discord_get_current_screen_url() ); ?>">

	<table class="form-table" role="presentation">
		<tbody>
		<tr>
				<th scope="row"><label for="defaultRole"><?php esc_html_e( 'Default Role', 'lifterlms-discord-addon' ); ?></label></th>
					<td>
									<?php wp_nonce_field( 'discord_role_mappings_nonce', 'ets_lifterlms_discord_role_mappings_nonce' ); ?>
									
									<input type="hidden" id="selected_default_role" value="<?php echo esc_attr( $default_role ); ?>">
									<select id="defaultRole" name="defaultRole">
										<option value="none"><?php esc_html_e( '-None-', 'lifterlms-discord-addon' ); ?></option>
									</select>
								<p class="description"><?php esc_html_e( 'This Role will be assigned to all level members', 'lifterlms-discord-addon' ); ?></p>
				</td>
		</tr>
		<tr>
				<th scope="row"><label><?php esc_html_e( 'Allow non-members', 'lifterlms-discord-addon' ); ?></label></th>
				<td>
					<fieldset>
									<label><input type="radio" name="allow_none_member" value="yes"  
									<?php
									if ( 'yes' === $allow_none_member ) {
										echo esc_attr( 'checked="checked"' ); }
									?>
									> <span><?php esc_html_e( 'Yes', 'lifterlms-discord-addon' ); ?></span></label><br>
									<label><input type="radio" name="allow_none_member" value="no" 
									<?php
									if ( empty( $allow_none_member ) || 'no' === $allow_none_member ) {
										echo esc_attr( 'checked="checked"' ); }
									?>
									> <span><?php esc_html_e( 'No', 'lifterlms-discord-addon' ); ?></span></label>
									<p></p>
					</fieldset>
				</td>
			</tr> 
		</tbody>
	</table>
	<br>

	<div class="mapping-json">
		<textarea id="maaping_json_val" name="ets_lifterlms_discord_role_mapping">
		<?php
		if ( isset( $ets_discord_roles ) ) {
			echo esc_html( $ets_discord_roles );
		}
		?>
		</textarea>
	</div>


  <div class="bottom-btn">
		<button type="submit" name="submit" value="ets_submit" class="ets-submit ets-bg-green">
			<?php esc_html_e( 'Save Settings', 'lifterlms-discord-add-on' ); ?>
		</button>

		<button id="lifterlmsRevertMapping" name="flush" class="ets-submit ets-bg-red">
			<?php esc_html_e( 'Flush Mappings', 'lifterlms-discord-add-on' ); ?>
		</button>
  </div>
</form>







