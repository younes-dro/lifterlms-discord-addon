<?php 
	$ets_lifterlms_discord_client_id  = sanitize_text_field( get_option( 'ets_lifterlms_discord_client_id' ));
	$ets_lifterlms_discord_client_secret  = sanitize_text_field( get_option( 'ets_lifterlms_discord_client_secret' ));
	$ets_lifterlms_discord_redirect_url  = sanitize_text_field( get_option( 'ets_lifterlms_discord_redirect_url' ));
	$ets_lifterlms_discord_bot_token  = sanitize_text_field( get_option( 'ets_lifterlms_discord_bot_token' ));
	$ets_lifterlms_discord_server_id  = sanitize_text_field( get_option( 'ets_lifterlms_discord_server_id' ));

?>

<form method="post" action="<?php echo esc_attr( get_site_url() ) . '/wp-admin/admin-post.php'; ?>">

<input type="hidden" name="action" value="lifterlms_discord_save_application_details">

<?php wp_nonce_field( 'save_lifterlms_discord_settings', 'ets_lifterlms_discord_save_settings' ); ?>
	
		<div class="ets-input-group">
			<label><?php echo __( 'ID', 'lifterlms-discord-addon' ); ?> :</label>
			<input type="text" class="ets-input" name="ets_lifterlms_discord_client_id" value="<?php if ( isset( $ets_lifterlms_discord_client_id ) ) { echo $ets_lifterlms_discord_client_id;} ?>" required placeholder="<?php echo __( 'Discord Client ID', 'lifterlms-discord-add-on' ); ?>">
		</div>
	
		<div class="ets-input-group">
			<label><?php echo __( 'Secret', 'lifterlms-discord-addon' ); ?> :</label>
			<input type="text" class="ets-input" name="ets_lifterlms_discord_client_secret" value="<?php if ( isset( $ets_lifterlms_discord_client_secret ) ) { echo esc_attr( $ets_lifterlms_discord_client_secret ); } ?>" required placeholder="<?php echo __( 'Discord Client Secret', 'lifterlms-discord-add-on' ); ?>">
		</div>

		<div class="ets-input-group">
			<label><?php echo __( 'Redirect URL', 'lifterlms-discord-addon' ); ?> :</label>
			
			<?php echo $ets_lifterlms_discord_redirect_url;?></br>
			<select class="form-control js-example-tags ets-input" name="ets_lifterlms_discord_redirect_url" id="select1">
				<option value="volvo">Volvo</option>
				<option value="saab">Saab</option>
				<option value="opel">Opel</option>
				<option value="audi">Audi</option>
  			</select>
	    </div>

		<div class="ets-input-group">
			<label><?php echo __( 'Bot Token', 'lifterlms-discord-addon' ); ?> :</label>
			<input type="text" class="ets-input" name="ets_lifterlms_discord_bot_token" value="<?php if ( isset( $ets_lifterlms_discord_bot_token ) ) { echo esc_attr( $ets_lifterlms_discord_bot_token ); } ?>" required placeholder="<?php echo __( 'Discord Bot Token', 'lifterlms-discord-add-on' ); ?>">
		</div>
	
		<div class="ets-input-group">
			<label><?php echo __( 'Server Id', 'lifterlms-discord-addon' ); ?> :</label>
			<input type="text" class="ets-input" name="ets_lifterlms_discord_server_id" placeholder="<?php echo __( 'Discord Server Id', 'lifterlms-discord-add-on' ); ?>" value="<?php if ( isset( $ets_lifterlms_discord_server_id  ) ) { echo esc_attr( $ets_lifterlms_discord_server_id  ); } ?>" required>
		</div>
	
<!--check field Empty or Not-->

	<?php if ( empty( $ets_lifterlms_discord_client_id ) || empty( $ets_lifterlms_discord_client_secret ) || empty( $ets_lifterlms_discord_bot_token) || empty( $ets_lifterlms_discord_redirect_url ) || empty( $ets_lifterlms_discord_server_id ) ) { ?>
		<p class="ets-danger-text description">
		    <?php echo __( 'Please save your form Now', 'lifterlms-discord-addon' ); ?>
		</p>
	<?php } ?>

<!--check Save Button-->
	<p>
		<button type="submit" name="submit" value="ets_submit" class="ets-submit ets-bg-green">
	    	<?php echo __( 'Save Settings', 'lifterlms-discord-addon' ); ?>
		</button>
	</p>

</form>
