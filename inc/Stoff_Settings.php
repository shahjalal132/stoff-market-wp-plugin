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
        <input style="margin-top: 10px; margin-bottom: 10px; width: 25%; display: block;" placeholder="Set Email"
            type="email" name="set_email" id="set_email" value="<?php echo $stoff_email; ?>" class="widefat">

        <button id="set_email_save" class="button button-primary">
            <?php _e( 'Save', 'text-domain' ); ?>
        </button>

    </div>

    <script>
        jQuery(document).ready(function ($) {
            $('#set_email_save').click(function (e) {
                e.preventDefault();
                var email = $('#set_email').val();
                var data = {
                    'action': 'save_email',
                    'email': email
                };
                $.post(ajaxurl, data, function (response) {
                    alert('Email saved successfully!');
                });
            });
        });
    </script>

    <?php
}

// AJAX handler function to save email
add_action( 'wp_ajax_save_email', 'save_email_callback' );

function save_email_callback() {
    if ( isset ( $_POST['email'] ) ) {
        $email = sanitize_email( $_POST['email'] );
        update_option( 'stoff-set-email', $email );
        echo 'success';
    }
}


// Create sub menu page
function stoff_enquiries() {
    add_submenu_page(
        'stoff-settings',
        'Enquires',
        'Enquires',
        'manage_options',
        'enquires',
        'stoff_enquires_html'
    );
}
add_action( 'admin_menu', 'stoff_enquiries' );

function stoff_enquires_html() {

    global $wpdb;
    $table_name = $wpdb->prefix . 'enquires';

    // Get current page number
    $current_page = max( 1, isset ( $_GET['paged'] ) ? intval( $_GET['paged'] ) : 1 );
    $per_page     = 10;
    $offset       = ( $current_page - 1 ) * $per_page;

    // Fetch results with pagination and search
    $search_term = isset ( $_GET['stoff-enquires'] ) ? sanitize_text_field( $_GET['stoff-enquires'] ) : '';
    $query       = "SELECT * FROM $table_name";

    // Add WHERE clause if search term is provided
    if ( !empty ( $search_term ) ) {
        $query .= $wpdb->prepare( " WHERE first_name LIKE %s OR address LIKE %s OR email LIKE %s OR phone LIKE %s", '%' . $search_term . '%', '%' . $search_term . '%', '%' . $search_term . '%', '%' . $search_term . '%' );
    }

    $query .= " LIMIT $per_page OFFSET $offset";
    $results = $wpdb->get_results( $query );

    ?>

    <!-- Search box -->
    <nav class="navbar navbar-light bg-light mt-4">
        <form class="form-inline d-flex ms-auto gap-2 me-2" action="<?php echo esc_url( admin_url( 'admin.php' ) ); ?>">
            <input class="form-control mr-sm-2" id="search-input" name="page" value="stoff-enquires" type="hidden">
            <input class="form-control mr-sm-2" id="search-input" name="stoff-enquires"
                value="<?php echo isset ( $_GET['stoff-enquires'] ) ? esc_attr( $_GET['stoff-enquires'] ) : ''; ?>"
                type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </nav>

    <!-- <p class="search-box">
        <label class="screen-reader-text" for="post-search-input">Search Pages:</label>
        <input type="search" id="post-search-input" name="s" value="">
        <input type="submit" id="search-submit" class="button" value="Search Pages">
    </p> -->

    <!-- Display users information?s table -->
    <div id="stoff-enquires-table">
        <table class="wp-list-table widefat fixed striped table-view-list">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Address</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone</th>
                    <th scope="col">What's App</th>
                    <th scope="col">Mobile App</th>
                    <th scope="col">Website</th>
                    <th scope="col">Software</th>
                    <th scope="col">Requirements</th>
                    <th scope="col">Budget</th>
                    <th scope="col">Deadline</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ( !empty ( $results ) && is_array( $results ) ) {
                    foreach ( $results as $result ) {

                        /* echo '<tr>';
                        echo '<td>' . $result->user_id . '</td>';
                        echo '<td>' . $result->first_name . '</td>';
                        echo '<td>' . $result->address . '</td>';
                        echo '<td>' . $result->email . '</td>';
                        echo '<td>' . $result->phone . '</td>';
                        echo '<td>' . $result->whatsapp . '</td>';
                        echo '<td>' . $need_app . '</td>';
                        echo '<td>' . $need_website . '</td>';
                        echo '<td>' . $need_software . '</td>';
                        echo '<td>' . $result->requirement . '</td>';
                        echo '<td>' . $result->budget . '</td>';
                        echo '<td>' . $result->deadline . '</td>';
                        echo '</tr>'; */
                    }
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="pagination float-end me-2 mt-2">
        <?php
        $total_items = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name" );

        $total_pages = ceil( $total_items / $per_page );

        echo paginate_links(
            array(
                'base'      => add_query_arg( 'paged', '%#%' ),
                'format'    => '',
                'prev_text' => __( 'Previous' ),
                'next_text' => __( 'Next' ),
                'total'     => $total_pages,
                'current'   => $current_page,
            )
        );
        ?>
    </div>

    <?php
}
