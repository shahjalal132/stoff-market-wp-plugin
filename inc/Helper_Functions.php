<?php

// Create enquires Table When Plugin Activated
function stoff_enquires_db_table_create() {

    global $wpdb;

    $table_name      = $wpdb->prefix . 'enquires';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id INT AUTO_INCREMENT,
        website VARCHAR(1000) NOT NULL,
        launched VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        fabric VARCHAR(255) NOT NULL,
        desired_contents VARCHAR(1000) NOT NULL,
        gsm VARCHAR(255) NOT NULL,
        approx_need VARCHAR(255) NOT NULL,
        target_from VARCHAR(255) NOT NULL,
        target_to VARCHAR(255) NOT NULL,
        list_of_color VARCHAR(1000) NOT NULL,
        delivery_day VARCHAR(255) NOT NULL,
        delivery_month VARCHAR(255) NOT NULL,
        delivery_year VARCHAR(255) NOT NULL,
        orders_per_year VARCHAR(255) NOT NULL,
        product VARCHAR(255),
        fabric_finishes VARCHAR(1000),
        anything_else TEXT,
        fabric_design VARCHAR(255),
        enquiry_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta( $sql );
}

function insert_data_to_database( $data, $image_url ) {
    global $wpdb;

    $table_name = $wpdb->prefix . 'enquires';

    $insert_result = $wpdb->insert(
        $table_name,
        array(
            'website'          => $data['website'],
            'launched'         => $data['lanced'],
            'email'            => $data['email'],
            'fabric'           => $data['fabric'],
            'desired_contents' => $data['desired_contents'],
            'gsm'              => $data['gsm'],
            'approx_need'      => $data['approx'],
            'target_from'      => $data['target-from'],
            'target_to'        => $data['target-to'],
            'list_of_color'    => $data['list-of-color'],
            'delivery_day'     => $data['delivery-day'],
            'delivery_month'   => $data['delivery-month'],
            'delivery_year'    => $data['delivery-year'],
            'orders_per_year'  => $data['orders-per-year'],
            'product'          => $data['product'],
            'fabric_finishes'  => $data['fabric-finishes'],
            'anything_else'    => $data['anything-else'],
            'fabric_design'    => $image_url,
        )
    );

    if ( false === $insert_result ) {
        // There was an error inserting data
        echo "Error inserting data: " . $wpdb->last_error;
    } else {
        // Data inserted successfully
        echo "Data inserted successfully";
    }
}