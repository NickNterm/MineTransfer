<html>

<body>

    <?php
    $servername = "localhost";
    $username = "admin";
    $password = "admin";
    $dbname = "MineTransfer";

    $conn = new mysqli($servername, $username, $password, $dbname);
    $download = $_GET["file"];
    $sql = "SELECT * FROM Data WHERE code = '" . $download . "';";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "The Message from the sender was: " . $row['message'];
            rename('transfers/' . $download, 'transfers/' . $row['filename']);
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $row['filename'] . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            flush(); // Flush system output buffer
            readfile('transfers/' . $row['filename']);
            rename('transfers/' . $row['filename'], 'transfers/' . $download);
            die();
        }
    } else {
        echo 'Invalid file -_-';
    }
    ?>

</body>

</html>