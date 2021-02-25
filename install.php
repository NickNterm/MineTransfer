<?php
session_start();
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "MineTransfer";

$conn = new mysqli($servername, $username, $password, $dbname);
$download = $_SESSION['file'];
$sql = "SELECT * FROM Data WHERE code = '" . $download . "';";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $row['filename'] . '"');
        header('Content-Length: ' . filesize('transfers/' . $download));
        header('Pragma: public');
        flush(); // Flush system output buffer
        readfile('transfers/' . $download);
        die();
    }
}
