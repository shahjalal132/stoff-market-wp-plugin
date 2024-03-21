<?php

// WordPress bootstrap
require_once('wp-load.php');

// Function to upload base64 encoded file to WordPress media library
function upload_base64_file_to_wordpress($base64_data, $filename, $post_title = '') {
    // Decode base64 data
    $file_content = base64_decode($base64_data);

    // Prepare the upload directory
    $upload_dir = wp_upload_dir();

    // Set the file path
    $file_path = $upload_dir['path'] . '/' . $filename;

    // Upload the file
    if (file_put_contents($file_path, $file_content)) {
        // Create attachment
        $attachment = array(
            'post_title' => $post_title != '' ? $post_title : $filename,
            'post_content' => '',
            'post_status' => 'inherit',
            'post_mime_type' => mime_content_type($file_path)
        );

        // Insert the attachment
        $attach_id = wp_insert_attachment($attachment, $file_path);

        // Generate metadata for the attachment
        $attach_data = wp_generate_attachment_metadata($attach_id, $file_path);

        // Update attachment metadata
        wp_update_attachment_metadata($attach_id, $attach_data);

        return $attach_id;
    } else {
        return false; // Failed to upload the file
    }
}

// Example usage
/* $base64_data = 'Your base64 encoded data';
$filename = 'example.jpg'; // Name of the file
$post_title = 'Example Image'; // Title of the media item

$result = upload_base64_file_to_wordpress($base64_data, $filename, $post_title);
if ($result) {
    echo "File uploaded successfully. Attachment ID: " . $result;
} else {
    echo "Failed to upload the file.";
} */
