<?php
/**
 * Plugin Name CAGIS Email Subscription Form.
 * Description: Form to subscribe to the email list for CAGIS
 * Version: 0.01
 * Author: Seamus Lee - JMA Consulting
 * Author URI: mailto:seamus.lee@jmaconsulting.biz
 */

function cagisemailsubsribe_display_form( $atts ) {
  $html = '<form action="./" method="post">';
  $html .= '<p><label 	for="id_emailsubscribe_email">Email Address*</label>
     <input 	type="email" id="id_emailsubscribe_email" name="id_emailsubscribe_email" required="required" size="40"/></p>';
  $html .= '<span style="display: none !important; visibility: none !important;"><input 	type="text" id="id_emailsubscribe_ai_buster" name="emailsubscribe_ai_buster" size="40" /></span>';
  // Submit Button
  $html .= '<p><input 	type="submit" name="emailsubscribe_submitted" value="Submit" /></p>';
  $html .= '</form>'
	// Filter the HTML for custom output
	$html = apply_filters( 'cagisemailsubsribe_display_form', $html, $atts ); // Pass in the HTML as well as the raw data objects

	// Return
	return $html;
}
add_shortcode( 'cagis_email_signup', 'cagisemailsubsribe_display_form' );

function cagisemailsubsribe_post() {
  if (isset($_POST['emailsubscribe_submitted'] ) ) {
		$honeypot = isset( $_POST['id_emailsubscribe_ai_buster'] ) ? $_POST['id_emailsubscribe_ai_buster'] : '';
		if ( $honeypot != '' ) {
			wp_redirect( '/');
			exit;
    } else {
      $email_address = sanitize_email( $_POST['id_emailsubscribe_email'] );
      civicrm_api3('Contact', 'Create', [
        'group' => [2 => 1],
        'contact_type' => 'Individual',
        'email' => $email,
      ]);
    }
  }
}
