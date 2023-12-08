<?php
if (isset($_GET['file'])) {
    $file = $_GET['file'];

    // Check if the file exists and is readable
    if (file_exists($file) && is_readable($file)) {
        // Set headers for force download
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));

        // Read the file and output it to the browser
        readfile($file);

        // Perform redirection after download
        echo '<script>window.onload = function() { window.location = "../orders.php"; }</script>';
        exit;
    } else {
        header("HTTP/1.0 404 Not Found");
    }
}
?>
