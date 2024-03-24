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