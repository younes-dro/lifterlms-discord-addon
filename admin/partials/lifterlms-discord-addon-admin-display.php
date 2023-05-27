<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.expresstechsoftwares.com
 * @since      1.0.0
 *
 * @package    Lifterlms_Discord_Addon
 * @subpackage Lifterlms_Discord_Addon/admin/partials
 */

?>
<!-- Save Setting Massage -->
<?php

if ( isset( $_GET['save_settings_msg'] ) ) {
	?>
	<div class="notice notice-success is-dismissible support-success-msg">
		<p><?php echo esc_html( $_GET['save_settings_msg'] ); ?></p>
	</div>
	<?php
}
?>
<!-- This is Main Page LifterLms-Discord-Addon --->

<h1><?php esc_html_e( 'LifterLMS Discord Add On Settings', 'connect-lifterlms-discord' ); ?></h1>
		<div id="outer" class="skltbs-theme-light" data-skeletabs='{ "startIndex": 0 }'>
		<ul class="skltbs-tab-group">

				<li class="skltbs-tab-item">
					<button class="skltbs-tab" data-identity="lifterlms_application" ><?php esc_html_e( 'Application Details', 'connect-lifterlms-discord' ); ?><span class="initialtab spinner"></span></button>
				</li>	
				<li class="skltbs-tab-item">
					<?php if ( ets_lifterlms_discord_check_saved_settings_status() ) : ?>
						<button class="skltbs-tab" data-identity="level-mapping" ><?php esc_html_e( 'Role Mapping', 'connect-lifterlms-discord' ); ?></button>
						<?php endif; ?>
				</li>
				<li class="skltbs-tab-item">
				<button class="skltbs-tab" data-identity="advanced" ><?php esc_html_e( 'Advanced', 'connect-lifterlms-discord' ); ?>	
				</button>
				</li>
				<li class="skltbs-tab-item">
				<button class="skltbs-tab" data-identity="appearance" ><?php esc_html_e( 'Appearance', 'connect-lifterlms-discord' ); ?>	
				</button>
				</li>
				<li class="skltbs-tab-item">
				<button class="skltbs-tab" data-identity="logs" ><?php esc_html_e( 'Logs', 'connect-lifterlms-discord' ); ?>	
				</button>
				</li>
				<li class="skltbs-tab-item">
				<button class="skltbs-tab" data-identity="documentation" ><?php esc_html_e( 'Documentation', 'connect-lifterlms-discord' ); ?>	
				</button>				
				<li class="skltbs-tab-item">
				<button class="skltbs-tab" data-identity="support" ><?php esc_html_e( 'Support', 'connect-lifterlms-discord' ); ?>	
				</button>								                                 
		</ul>
<!--Creating Tabs-->
			<div class="skltbs-panel-group">
				<div id='lifterlms_general_settings' class="skltbs-panel">
					<?php require_once LIFTERLMS_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/lifterlms-application-details.php'; ?>
				</div>
				<?php if ( ets_lifterlms_discord_check_saved_settings_status() ) : ?>  
				<div id='lifterlms_role_level' class="skltbs-panel">
					<?php require_once LIFTERLMS_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/lifterlms-discord-role-level-map.php'; ?>
				</div>
				<?php endif; ?>
				<div id='lifterlms_discord_advanced' class="skltbs-panel">
				<?php require_once LIFTERLMS_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/lifterlms-discord-advanced.php'; ?>
				</div>
				<div id='lifterlms_discord_appearance' class="skltbs-panel">
				<?php require_once LIFTERLMS_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/lifterlms-discord-appearance.php'; ?>
				</div> 
				<div id='lifterlms_discord_logs' class="skltbs-panel">
				<?php require_once LIFTERLMS_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/lifterlms-discord-error-log.php'; ?>
				</div>
				<div id='lifterlms_discord_documentation' class="skltbs-panel">
				<?php require_once LIFTERLMS_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/lifterlms-discord-documentation.php'; ?>
				</div>				
				<div id='lifterlms_discord_support' class="skltbs-panel">
				<?php require_once LIFTERLMS_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/lifterlms-discord-get-support.php'; ?>
				</div>								                
			</div>
	</div>
