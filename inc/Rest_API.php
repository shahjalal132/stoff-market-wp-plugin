<?php

function send_mail_callback() {

    $to      = 'rjshahjalal132@gmail.com';
    $subject = 'Test Email';
    $message = 'Hello World';

    $mailSend = mail( $to, $subject, $message );

    if ( $mailSend ) {
        return 'Mail sent successfully';
    } else {
        return 'Mail not sent';
    }


}

add_shortcode( 'send_mail_shortcode', 'send_mail_callback' );

// create a custom route for send email
add_action( 'rest_api_init', function () {

    register_rest_route( 'stoff-market/v1', 'send-mail', [
        'methods'  => 'GET',
        'callback' => 'send_mail_callback',
    ] );
} );



/**
 * Endpoint
 * http://elementor-widget-dev.test/wp-json/stoff-market/v1/send-mail
 */