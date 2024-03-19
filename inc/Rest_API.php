<?php
// Rest_API.php

// Check if form data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Print out the entire $_POST array
    print_r($_POST);
} else {
    // If form data is not received, display an error message
    echo "No data received.";
}
