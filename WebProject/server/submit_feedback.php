<?php
// submit_feedback.php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize inputs
    $name       = htmlspecialchars(trim($_POST['name']));
    $email      = htmlspecialchars(trim($_POST['email']));
    $rating     = htmlspecialchars(trim($_POST['rating']));
    $services   = isset($_POST['services']) ? $_POST['services'] : array();
    $preference = htmlspecialchars(trim($_POST['preference']));
    $comments   = htmlspecialchars(trim($_POST['comments']));

    // Process the data
    // Log feedback to a file (feedback.txt)
    $logEntry = "-------------------\n";
    $logEntry .= "Date: " . date("Y-m-d H:i:s") . "\n";
    $logEntry .= "Name: " . $name . "\n";
    $logEntry .= "Email: " . $email . "\n";
    $logEntry .= "User Rating: " . $rating . "\n";
    $logEntry .= "Services Used: " . implode(", ", $services) . "\n";
    $logEntry .= "Preferred Improvements: " . $preference . "\n";
    $logEntry .= "Additional Comments: " . $comments . "\n";
    $logEntry .= "-------------------\n\n";
    file_put_contents("../txt/feedback.txt", $logEntry, FILE_APPEND);

    // Display confirmation as an alert and then redirect back to the feedback page.
    echo "<script>
            alert('Feedback Submitted Successfully!');
            window.location.href='../feedback.html';
          </script>";
} else {
    echo "<script>
            alert('Invalid request method.');
            window.location.href='../feedback.html';
          </script>";
}
?>