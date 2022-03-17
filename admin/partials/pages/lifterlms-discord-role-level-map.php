<?php

/* 
Get All Courses form database
*/
$get_courses_lifterlms        =     get_posts( 
                                array(
                                'post_type' => 'Course', 
                                'post_status' => 'publish')
                                );

?>
 <!-- Drag and Drop the Discord Roles  -->

<div class="notice notice-warning ets-notice">
	<p>
        <i class='fas fa-info'></i>
        <?php echo __( 'Drag and Drop the Discord Roles over to the lifterlms Levels', 'lifterlms-discord-addon' ); ?>
    </p>
</div>

<!-- Create two equal columns that floats next to each other -->

<div class="row-container">

	<div class="ets-column discord-roles-col">
		<h2><?php echo __( 'Discord Roles', 'lifterlms-discord-addon' ); ?></h2>
		<hr>
            <div class="discord-roles">
                <span class="spinner"></span>
            </div>
	</div>
    <div class="ets-column">
		<h2><?php echo __( 'Lifterlms_Courses ', 'lifterlms-discord-add-on' ); ?></h2>
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

<form method="post" action="<?php echo esc_attr( get_site_url() ) . '/wp-admin/admin-post.php' ?>">
	<input type="hidden" name="action" value="lifterlms_discord_role_mapping">
    <input type="hidden" name="current_url_role" value="<?php echo ets_lifterlms_discord_get_current_screen_url()?>">

	<table class="form-table" role="presentation">
        <tbody>
            

            
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
            <?php echo __( 'Save Settings', 'lifterlms-discord-add-on' ); ?>
        </button>

        <button id="lifterlmsRevertMapping" name="flush" class="ets-submit ets-bg-red">
            <?php echo __( 'Flush Mappings', 'lifterlms-discord-add-on' ); ?>
        </button>
  </div>
</form>







