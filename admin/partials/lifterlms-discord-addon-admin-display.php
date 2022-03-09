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
echo "for testhing purpose";
?>
<!-- This is Main Page LifterLms-Discord-Addon --->

<h1><?php echo __( 'LifterLMS Discord Add On Settings', 'lifterlms-discord-add-on' ); ?></h1>
		<div id="outer" class="skltbs-theme-light" data-skeletabs='{ "startIndex": 0 }'>
			
		<ul class="skltbs-tab-group">

				<li class="skltbs-tab-item">
				   <button class="skltbs-tab" data-identity="lifterlms_application" ><?php echo __( 'Application Details', 'lifterlms-discord-add-on' ); ?><span class="initialtab spinner"></span></button>
				</li>
                <li class="skltbs-tab-item">
				   <button class="skltbs-tab" data-identity="lifterlms_role_level" ><?php echo __( 'Role Mapping', 'lifterlms-discord-add-on' ); ?></button>
				</li>
                <li class="skltbs-tab-item">
				   <button class="skltbs-tab" data-identity="lifterlms_advance" ><?php echo __( 'Advance', 'lifterlms-discord-add-on' ); ?></button>
				</li>
                <li class="skltbs-tab-item">
				   <button class="skltbs-tab" data-identity="lifterlms_log" ><?php echo __( 'Log', 'lifterlms-discord-add-on' ); ?></button>
				</li>
                <li class="skltbs-tab-item">
				   <button class="skltbs-tab" data-identity="lifterlms_documentation" ><?php echo __( 'Documentation', 'lifterlms-discord-add-on' ); ?></button>
				</li>
                <li class="skltbs-tab-item">
				   <button class="skltbs-tab" data-identity="lifterlms_support" ><?php echo __( 'Support', 'lifterlms-discord-add-on' ); ?></button>
				</li>
				
		</ul>

<!--Creating Tabs-->

            <div class="skltbs-panel-group">

				<div id='lifterlms_general_settings' class="skltbs-panel">
				   <?php require_once LIFTERLMS_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/lifterlms-application-details.php'; ?>
				</div>

                <div id='lifterlms_role_level_settings' class="skltbs-panel">
				   <?php require_once LIFTERLMS_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/lifterlms-discord-role-level-map.php'; ?>
				</div>

                <div id='lifterlms_advance_settings' class="skltbs-panel">
				   <?php require_once LIFTERLMS_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/lifterlms-discord-advance.php'; ?>
				</div>

                <div id='lifterlms_documentation_settings' class="skltbs-panel">
				   <?php require_once LIFTERLMS_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/lifterlms-discord-documentation.php'; ?>
				</div>

                <div id='lifterlms_error_log_settings' class="skltbs-panel">
				   <?php require_once LIFTERLMS_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/lifterlms-discord-error-log.php'; ?>
				</div>

                <div id='lifterlms_get_Support_settings' class="skltbs-panel">
				   <?php require_once LIFTERLMS_DISCORD_PLUGIN_DIR_PATH . 'admin/partials/pages/lifterlms-discord-get-support.php'; ?>
				</div>

			</div>
    </div>
