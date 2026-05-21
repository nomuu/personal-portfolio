<?php
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['email'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $emailHash = md5($email); // To create safe filename
    $cooldownMinutes = 60;

    $storagePath = __DIR__ . "/.resume_requests";
    if (!is_dir($storagePath)) {
        mkdir($storagePath, 0755, true);
    }

    $requestFile = "$storagePath/$emailHash.txt";

    if (file_exists($requestFile)) {
        $lastRequest = file_get_contents($requestFile);
        $elapsed = time() - (int)$lastRequest;

        if ($elapsed < ($cooldownMinutes * 60)) {
            echo "You have already requested recently. Please wait before requesting again.";
            exit;
        }
    }

    // Save timestamp
    file_put_contents($requestFile, time());

    $to = "inquiry@imronaldmendoza.com";
    $subject = "Resume Request from Website";
    $message = "A visitor requested your resume.\n\nEmail: $email";
    $headers = "From: no-reply@imronaldmendoza.com\r\n";
    $headers .= "Reply-To: $email\r\n";

    if (mail($to, $subject, $message, $headers)) {
        echo "Thank you! Your request has been successfully sent. Please check your inbox or spam folder for our response.";
    } else {
        echo "Failed to send your request. Please try again later.";
    }
} else {
    echo "Invalid request.";
}
?>
