<?php
echo "This is application-deatails pages";
?>
/*
    This is Application Details 
*/

<form method="post" action="">
    
<input type="hidden" name="action" value="lifterlms_discord_general_settings">
	<div>
		<label><?php echo __( 'Client ID', 'lifterlms-discord-addon' ); ?> :</label>
		<input type="text" name="" value=" " placeholder="<?php echo __( 'Discord Client ID', 'lifterlms-discord-add-on' ); ?>"required >
	</div>
	
	<div>
		<label><?php echo __( 'Client Secret', 'lifterlms-discord-addon' ); ?> :</label>
		<input type="text" name="" value=" " placeholder="<?php echo __( 'Discord Client Secret', 'lifterlms-discord-add-on' ); ?>" required >
	</div>

	<div>
	    <label><?php echo __( 'Redirect URL', 'lifterlms-discord-addon' ); ?> :</label>
				<select id="select1" name="">
					<option>PHP</option>
                    <option>PHP</option>
				</select>
    </div>
	<div>
		<label><?php echo __( 'Bot Token', 'lifterlms-discord-addon' ); ?> :</label>
		<input type="text" name="" value=" "  placeholder="<?php echo __( 'Discord Bot Token', 'lifterlms-discord-add-on' ); ?>" required >
	</div>
	<div>
		<label><?php echo __( 'Server Id', 'lifterlms-discord-addon' ); ?> :</label>
		<input type="text" name="" placeholder="<?php echo __( 'Discord Server Id', 'lifterlms-discord-add-on' ); ?>" value=" " required >
	</div>
	
</form>