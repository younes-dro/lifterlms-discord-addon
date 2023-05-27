<?php
	/**
	 *  Get value of the field
	 */
	$ets_lifterlms_discord_client_id        = sanitize_text_field( get_option( 'ets_lifterlms_discord_client_id' ) );
	$ets_lifterlms_discord_client_secret    = sanitize_text_field( get_option( 'ets_lifterlms_discord_client_secret' ) );
	$ets_lifterlms_discord_redirect_page_id = sanitize_text_field( get_option( 'ets_lifterlms_discord_redirect_page_id' ) );
	$ets_lifterlms_discord_admin_redirect_url       = sanitize_text_field( get_option( 'ets_lifterlms_discord_admin_redirect_url' ) );
	$ets_lifterlms_discord_bot_token        = sanitize_text_field( get_option( 'ets_lifterlms_discord_bot_token' ) );
	$ets_lifterlms_discord_server_id        = sanitize_text_field( get_option( 'ets_lifterlms_discord_server_id' ) );
	$ets_discord_roles                      = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_role_mapping' ) ) );

	/**
	 *  Passed Redirect-URL in function ets_get_lifterlms_discord_formated_discord_redirect_url
	 */
	$redirect_url = ets_get_lifterlms_discord_formated_discord_redirect_url( $ets_lifterlms_discord_redirect_page_id );
	$bot_username = $this->ets_lifterlms_discord_get_bot_name( $ets_lifterlms_discord_bot_token );

?>

<form method="post" action="<?php echo esc_attr( get_site_url() ) . '/wp-admin/admin-post.php'; ?>">
<input type="hidden" name="action" value="lifterlms_discord_save_application_details">
<input type="hidden" name="current_url" value="<?php echo esc_url( ets_lifterlms_discord_get_current_screen_url() ); ?>">
<?php wp_nonce_field( 'save_lifterlms_discord_settings', 'ets_lifterlms_discord_save_settings' ); ?>
		<div class="ets-input-group">
			<?php $ets_lifterlms_discord_client_id_value = isset( $ets_lifterlms_discord_client_id ) ? $ets_lifterlms_discord_client_id : ''; ?>
			<label><?php esc_html_e( 'Client ID', 'connect-lifterlms-discord' ); ?> :</label>
			<input type="text" class="ets-input" name="ets_lifterlms_discord_client_id" value="<?php echo esc_attr( $ets_lifterlms_discord_client_id_value ); ?>" required placeholder="<?php esc_html_e( 'Discord Client ID', 'connect-lifterlms-discord' ); ?>">
		</div>
		<div class="ets-input-group">
		<?php $ets_lifterlms_discord_client_secret_value = isset( $ets_lifterlms_discord_client_secret ) ? $ets_lifterlms_discord_client_secret : ''; ?>
			<label><?php esc_html_e( 'Client Secret', 'connect-lifterlms-discord' ); ?> :</label>
			<input type="password" class="ets-input" name="ets_lifterlms_discord_client_secret" value="<?php echo esc_attr( $ets_lifterlms_discord_client_secret_value ); ?>" required placeholder="<?php esc_html_e( 'Discord Client Secret', 'connect-lifterlms-discord' ); ?>">
		</div>

		<div class="ets-input-group">
			<label><?php esc_html_e( 'Redirect URL', 'connect-lifterlms-discord' ); ?> :</label>
			<p class="redirect-url"><b><?php esc_html_e( $redirect_url ); ?></b></p>
			<select class="form-control ets_wp_pages_list ets-input" name="ets_lifterlms_discord_redirect_page_id" style="max-width: 100%" required >
				<?php _e( ets_lifterlms_discord_pages_list( wp_kses( $ets_lifterlms_discord_redirect_page_id, array( 'option' => array( 'data-page-url' => array() ) ) ) ) ); ?>
			</select>
		<p class="description"><?php esc_html_e( 'Registered discord app redirect url', 'connect-lifterlms-discord' ); ?><span class="spinner"></span></p>
				<p class="description ets-discord-update-message"><?php echo sprintf( __( 'Redirect URL updated, kindly add/update the same in your discord.com application link <a href="https://discord.com/developers/applications/%s/oauth2/general">https://discord.com/developers</a>', 'connect-lifterlms-discord' ), $ets_lifterlms_discord_client_id ); ?></p>                          
		</div>

		<div class="ets-input-group">

			<label><?php esc_html_e( 'Bot Auth Redirect URL', 'connect-lifterlms-discord' ); ?> :</label>
			<input required type="text" readonly="true" class="ets-input" name="ets_lifterlms_discord_admin_redirect_url" value="<?php echo esc_url( get_admin_url( '', 'admin.php' ) . '?page=connect-lifterlms-discord&via=lifterlms-discord-connectToBot' ); ?>" />
			<p class="description msg-green"><b><?php esc_html_e( 'Copy this URL and paste inside your https://discord.com/developers/applications -> 0Auth2 -> Redirects', 'connect-lifterlms-discord' ); ?></b></p>
		</div>

		<div class="ets-input-group">
			<?php echo sprintf( " <b>(%s)</b> Bot name, should have the higher priority than the role it has to manage. <a href='https://discord.com/channels/%d'>Open discord server</a>.", $bot_username, $ets_lifterlms_discord_server_id ); ?><br>	
		<?php $ets_lifterlms_discord_bot_token_value = isset( $ets_lifterlms_discord_bot_token ) ? $ets_lifterlms_discord_bot_token : ''; ?>
			<label><?php esc_html_e( 'Bot Token', 'connect-lifterlms-discord' ); ?> :</label>
			<input type="password" class="ets-input" name="ets_lifterlms_discord_bot_token" value="<?php echo esc_attr( $ets_lifterlms_discord_bot_token_value ); ?>" required placeholder="<?php esc_html_e( 'Discord Bot Token', 'connect-lifterlms-discord' ); ?>">
		</div>
		<div class="ets-input-group">
			<?php $ets_lifterlms_discord_server_id_value = isset( $ets_lifterlms_discord_server_id ) ? $ets_lifterlms_discord_server_id : ''; ?>
			<label><?php esc_html_e( 'Server ID', 'connect-lifterlms-discord' ); ?> :</label>
			<input type="text" class="ets-input" name="ets_lifterlms_discord_server_id" placeholder="<?php esc_html_e( 'Discord Server Id', 'connect-lifterlms-discord' ); ?>" value="<?php echo esc_attr( $ets_lifterlms_discord_server_id_value ); ?>" required>
		</div>
<!--check field Empty or Not-->

	<?php if ( empty( $ets_lifterlms_discord_client_id ) || empty( $ets_lifterlms_discord_client_secret ) || empty( $ets_lifterlms_discord_bot_token ) || empty( $ets_lifterlms_discord_redirect_page_id ) || empty( $ets_lifterlms_discord_server_id ) ) { ?>
		<p class="ets-danger-text description">
			<?php esc_html_e( 'Please save your form Now', 'connect-lifterlms-discord' ); ?>
		</p>
	<?php } ?>

<!--check Save Button-->
	<p>
		<button type="submit" name="submit" value="ets_submit" class="ets-submit ets-bg-green">
			<?php esc_html_e( 'Save Settings', 'connect-lifterlms-discord' ); ?>
		</button>

		<?php if ( get_option( 'ets_lifterlms_discord_client_id' ) ) : ?>
			<a href="?page=connect-lifterlms-discord&action=lifterlms-discord-connectToBot" class="ets-btn btn-connect-to-bot" id="connect-discord-bot"><?php esc_html_e( 'Connect your Bot', 'connect-lifterlms-discord' ); ?> <i class='fab fa-discord'></i></a>
		<?php endif; ?>
	</p>

</form>
