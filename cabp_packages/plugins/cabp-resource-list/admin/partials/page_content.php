<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://carlos-bucheli.com
 * @since      1.0.0
 *
 * @package    CABP_Resource_List
 * @subpackage CABP_Resource_List/public/partials
 */
?>

<div class="wrap">
  <h2>CABP Resource List</h2>
  <p></p>
	<?php settings_errors(); ?>
  <form method="post" action="options.php">
	  <?php
	  settings_fields( 'cabp_option_group' );
	  do_settings_sections( CABP_RESOURCE_LIST_SLUG_ADMIN );
	  submit_button();
	  ?>
  </form>
</div>
