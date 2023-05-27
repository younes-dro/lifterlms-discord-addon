<div class="error-log">
<?php
	$uuid     = sanitize_text_field( trim( get_option( 'ets_lifterlms_discord_uuid_file_name' ) ) );
	$filename = $uuid . Lifterlms_Discord_Addon_Logs::$log_file_name;
	$handle   = fopen( WP_CONTENT_DIR . '/' . $filename, 'a+' );
if ( $handle ) {
	while ( ! feof( $handle ) ) {
		echo fgets( $handle ) . '<br />';
	}
	fclose( $handle );
}
?>
</div>
<div class="clrbtndiv">
	<div class="form-group">
		<input type="button" class="ets-clrbtn ets-submit ets-bg-red" id="ets-lifterlms-clrbtn" name="lifterlms_clrbtn" value="Clear Logs !">
		<span class="clr-log spinner" ></span>
	</div>
	<div class="form-group">
		<input type="button" class="ets-submit ets-bg-green" value="Refresh" onClick="window.location.reload()">
	</div>
	<div class="form-group">
		<a href="<?php echo esc_url( content_url( '/' ) . $filename ); ?>" class="ets-submit ets-bg-download" download><?php esc_html_e( 'Download', 'connect-lifterlms-discord' ); ?></a>
	</div>
	<div class="form-group">
			<a href="<?php echo esc_url( get_admin_url( '', 'tools.php' ) ) . '?page=action-scheduler&status=pending&s=lifterlms'; ?>" class="ets-submit ets-lifterlms-bg-scheduled-actions"><?php esc_html_e( 'Scheduled Actions', 'connect-lifterlms-discord' ); ?></a>
	</div>    
</div>
