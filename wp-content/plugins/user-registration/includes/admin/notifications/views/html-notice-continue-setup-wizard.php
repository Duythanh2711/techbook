<?php
/**
 * Admin View: Notice - Continue Setup Wizard.
 *
 * @package UserRegistration
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<div id="message" class="updated user-registration-message ur-connect">
	<p><?php echo wp_kses_post( 'It seems that you have skipped setup wizard. In order to properly setup User Registration Plugin please continue the setup wizard.', 'user-registration' ); ?></p>
	<p class="submit"><a href="<?php echo esc_url( add_query_arg( 'install_user_registration_pages', 'true', admin_url( 'admin.php?page=user-registration-settings' ) ) ); ?>" class="button-primary"><?php esc_html_e( 'Install User Registration Pages', 'user-registration' ); ?></a> <a class="button-secondary skip" href="<?php echo esc_url( wp_nonce_url( add_query_arg( 'ur-hide-notice', 'install' ), 'user_registration_hide_notices_nonce', '_ur_notice_nonce' ) ); ?>"><?php esc_html_e( 'Skip setup', 'user-registration' ); ?></a></p>
</div>
