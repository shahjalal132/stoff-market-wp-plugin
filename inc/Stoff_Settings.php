<?php

/**
 * Register an Stoff-Settings menu page.
 */
function stoff_settings_callback() {
    add_menu_page(
        __( 'Stoff-Settings', 'text-domain' ),
        'Stoff Settings',
        'manage_options',
        'stoff-settings.php',
        'stoff_settings_admin_callback',
        'dashicons-admin-generic',
        85
    );
}
add_action( 'admin_menu', 'stoff_settings_callback' );

function stoff_settings_admin_callback() {
    ?>

    <div class="wrap">

        <h1>
            <?php _e( 'Stoff Settings', 'text-domain' ); ?>
        </h1>

        <label for="set_email"> Set Email </label>
        <input style="margin-top: 10px; margin-bottom: 10px; width: 25%; display: block;" placeholder="Set Email" type="email" name="set_email" id="set_email" class="widefat">

        <button id="set_email_save" class="button button-primary">
            <?php _e( 'Save', 'text-domain' ); ?>
        </button>

    </div>

    <?php
}