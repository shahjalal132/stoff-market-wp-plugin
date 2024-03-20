<?php

// Check if form data is empty
if ( !empty ( $_POST ) ) {
    $data = $_POST;

    $website         = $data['website'] ?? '';
    $lanced          = $data['lanced'] ?? '';
    $email           = $data['email'] ?? '';
    $fabric          = $data['fabric'] ?? '';
    $gsm             = $data['gsm'] ?? '';
    $approx          = $data['approx'] ?? '';
    $target_from     = $data['target-from'] ?? '';
    $target_to       = $data['target-to'] ?? '';
    $delivery_day    = $data['delivery-day'] ?? '';
    $delivery_month  = $data['delivery-month'] ?? '';
    $delivery_year   = $data['delivery-year'] ?? '';
    $orders_per_year = $data['orders-per-year'] ?? '';
    $product         = $data['product'] ?? '';
    $fabric_finish   = $data['fabric-finish'] ?? '';
    $desired_content = $data['desired_content'] ?? '';

    $to      = 'rjshahjalal132@gmail.com'; // Change this to your email address
    $subject = 'Test Email from stoff-market';

    // Merge all data into $message
    $message = "Website: $website\n";
    $message .= "Lanced: $lanced\n";
    $message .= "Email: $email\n";
    $message .= "Fabric: $fabric\n";
    $message .= "GSM: $gsm\n";
    $message .= "Approximate Quantity: $approx\n";
    $message .= "Target From: $target_from\n";
    $message .= "Target To: $target_to\n";
    $message .= "Delivery Date: $delivery_day/$delivery_month/$delivery_year\n";
    $message .= "Orders Per Year: $orders_per_year\n";
    $message .= "Product: $product\n";
    $message .= "Fabric Finish: $fabric_finish\n";
    $message .= "Desired Content: $desired_content\n";

    $mailSend = mail( $to, $subject, $message );

    if ( $mailSend ) {
        echo 'Mail sent successfully';
    } else {
        echo 'Mail not sent';
    }

}