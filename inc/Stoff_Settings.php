<?php

/**
 * Register an Stoff-Settings menu page.
 */
function stoff_settings_callback() {
    add_menu_page(
        __( 'Stoff-Settings', 'text-domain' ),
        'Stoff Settings',
        'manage_options',
        'stoff-settings',
        'stoff_settings_admin_callback',
        'dashicons-admin-generic',
        85
    );
}
add_action( 'admin_menu', 'stoff_settings_callback' );

function stoff_settings_admin_callback() {

    $stoff_email = get_option( 'stoff-set-email' );

    ?>

    <div class="wrap">

        <h1>
            <?php _e( 'Stoff Settings', 'text-domain' ); ?>
        </h1>

        <label for="set_email"> Set Email </label>
        <input style="margin-top: 10px; margin-bottom: 10px; width: 25%; display: block;" placeholder="Set Email" type="email" name="set_email" id="set_email" value="<?php echo $stoff_email; ?>"  class="widefat">

        <button id="set_email_save" class="button button-primary">
            <?php _e( 'Save', 'text-domain' ); ?>
        </button>

    </div>

    <script>
        jQuery(document).ready(function($) {
            $('#set_email_save').click(function(e) {
                e.preventDefault();
                var email = $('#set_email').val();
                var data = {
                    'action': 'save_email',
                    'email': email
                };
                $.post(ajaxurl, data, function(response) {
                    alert('Email saved successfully!');
                });
            });
        });
    </script>

    <?php
}

// AJAX handler function to save email
add_action('wp_ajax_save_email', 'save_email_callback');

function save_email_callback() {
    if (isset($_POST['email'])) {
        $email = sanitize_email($_POST['email']);
        update_option('stoff-set-email', $email);
        echo 'success';
    }
}
