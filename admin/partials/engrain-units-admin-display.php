<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://github.com/buynyakov/engrain-units
 * @since      1.0.0
 *
 * @package    Engrain_Units
 * @subpackage Engrain_Units/admin/partials
 */

?>

<div class="wrap">

<h1 class="wp-heading-inline"><?php echo esc_html( get_admin_page_title() ); ?></h1>
<a href="<?php echo admin_url("admin.php")?>?action=make_a_call" class="page-title-action">Make an API call</a>

<hr class="wp-header-end">

<?php if(isset($_GET["success"])) : ?>
      <div id="message" class="updated notice is-dismissible">
      <p><?php _e('Success!');?> <a href="<?php echo admin_url("edit.php")?>?post_type=unit">View Units</a></p>
      </div>
<?php elseif(isset($_GET["error"])) : ?>
      <div id="message" class="notice notice-error is-dismissible">
      <p><?php _e('Oops, something went wrong. Please try again.');?></p>
      </div>
<?php endif; ?>



</div>

