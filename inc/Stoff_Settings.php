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

    echo '<h2 class="mt-2">Stoff Market Enquires</h2>';

    if ( !current_user_can( 'manage_options' ) ) {
        return;
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'enquires';

    // Get current page number
    $current_page = max( 1, isset ( $_GET['paged'] ) ? intval( $_GET['paged'] ) : 1 );
    $per_page     = 10;
    $offset       = ( $current_page - 1 ) * $per_page;

    // Fetch results with pagination and search
    $search_term = isset ( $_GET['search-enquiry'] ) ? sanitize_text_field( $_GET['search-enquiry'] ) : '';
    $query       = "SELECT * FROM $table_name";

    // Add WHERE clause if search term is provided
    if ( !empty ( $search_term ) ) {
        $query .= $wpdb->prepare( " WHERE website LIKE %s OR email LIKE %s", "%" . $search_term . "%", "%" . $search_term . "%" );
    }

    $query .= " LIMIT $per_page OFFSET $offset";
    $results = $wpdb->get_results( $query );

    ?>

    <!-- Search box -->
    <nav class="navbar navbar-light bg-light mt-4">
        <form class="form-inline d-flex ms-auto gap-2 me-2" action="<?php echo esc_url( admin_url( 'admin.php' ) ); ?>">

            <input class="form-control mr-sm-2" id="search-input" name="page" value="enquires" type="hidden">

            <input class="form-control mr-sm-2" id="search-input" name="search-enquiry"
                value="<?php echo isset ( $_GET['search-enquiry'] ) ? esc_attr( $_GET['search-enquiry'] ) : ''; ?>"
                type="search" placeholder="Search" aria-label="Search">

            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </nav>

    <!-- Display users information?s table -->
    <div id="stoff-enquires-table">
        <table class="wp-list-table widefat fixed striped table-view-list">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Website</th>
                    <th scope="col">Launched</th>
                    <th scope="col">Email</th>
                    <th scope="col">Fabric Structure</th>
                    <th scope="col">Desired Contents</th>
                    <th scope="col">Weigh GSM</th>
                    <th scope="col">How many Yards</th>
                    <th scope="col">USD cost</th>
                    <th scope="col">List of color(s)</th>
                    <th scope="col">Delivery Date</th>
                    <th scope="col">Order Per Year</th>
                    <th scope="col">What's the end product</th>
                    <th scope="col">Fabric Finish</th>
                    <th scope="col">Anything else we should know?</th>
                    <th scope="col">Created At</th>
                    <th scope="col">Fabric Design</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ( !empty ( $results ) && is_array( $results ) ) {
                    foreach ( $results as $result ) {

                        $desired_contents = $result->desired_contents;
                        // replace , to ' ' in $desired_contents
                        $desired_contents = str_replace( ',', ' ', $desired_contents );
                        // capitalize first letter of each word
                        $desired_contents = ucwords( $desired_contents );

                        $list_of_colors = $result->list_of_color;
                        // capitalize first letter of each word
                        $list_of_colors = ucwords( $list_of_colors );

                        $fabric_structure = $result->fabric;
                        // capitalize first letter of each word
                        $fabric_structure = ucwords( $fabric_structure );

                        echo '<tr>';
                        echo '<td>' . $result->id . '</td>';
                        echo '<td>' . $result->website . '</td>';
                        echo '<td>' . $result->launched . '</td>';
                        echo '<td>' . $result->email . '</td>';
                        echo '<td>' . $fabric_structure . '</td>';
                        echo '<td>' . $desired_contents . '</td>';
                        echo '<td>' . $result->gsm . '</td>';
                        echo '<td>' . $result->approx_need . '</td>';
                        echo '<td>' . $result->target_from . ' - ' . $result->target_to . '</td>';
                        echo '<td>' . $list_of_colors . '</td>';
                        echo '<td>' . $result->delivery_day . ' - ' . $result->delivery_month . ' - ' . $result->delivery_year . '</td>';
                        echo '<td>' . $result->orders_per_year . '</td>';
                        echo '<td>' . $result->product . '</td>';
                        echo '<td>' . $result->fabric_finishes . '</td>';
                        echo '<td>' . $result->anything_else . '</td>';
                        echo '<td>' . $result->enquiry_date . '</td>';
                        echo '<td>' . '<a href="' . $result->fabric_design . '" target="_blank">' . 'Click here to view' . '</a>' . '</td>';
                        echo '</tr>';
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

        if ( $total_items > 10 ) {
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
        }
        ?>
    </div>

    <?php

}
