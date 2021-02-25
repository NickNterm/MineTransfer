<html>
<link rel="stylesheet" href="/mainstyle.css">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<style>
    body {
        font-family: "Lato", sans-serif;
        transition: background-color .5s;
    }

    button {
        margin-top: 7px;
        font-size: 1.25em;
        font-weight: 700;
        border-radius: 4px;
        width: 85%;
        max-width: 300px;
        height: 35px;
        background-color: rgb(77, 77, 77);
        display: inline-block;
        color: rgb(255, 255, 255);
        border: 1px solid rgb(77, 77, 77);
        margin-bottom: 10px;
        transition: 0.3s;
    }

    button:hover {
        border: 1px solid #000;
        color: #000;
        background-color: rgb(187, 187, 187);
    }

    .uploadform {
        background: rgb(255, 255, 255);
        position: absolute;
        top: 50%;
        -ms-transform: translate(0, -50%);
        transform: translate(0, -50%);
        margin-left: 20px;
        width: 300px;
        line-height: 35px;
        border-radius: 3px;
        text-align: center;
        border: 1px solid #000;
        box-shadow: 0 0 20px rgb(102, 102, 102);
    }

    .shareit {
        text-align: center;
        position: absolute;
        max-width: 60%;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        padding: 30px;
        border: 1px solid #000;
        box-shadow: 0px 0px 0px black, 0 0 5px rgb(102, 102, 102);
    }

    .sendmessage {
        word-wrap: break-word;
    }
</style>

<body>

    <?php
    session_start();
    $servername = "localhost";
    $username = "admin";
    $password = "admin";
    $dbname = "MineTransfer";

    $conn = new mysqli($servername, $username, $password, $dbname);
    $download = $_GET["file"];
    $_SESSION['file'] = $download;
    $sql = "SELECT * FROM Data WHERE code = '" . $download . "';";
    $result = $conn->query($sql);
    if (isset($_POST["submit"])) {
        header('Location:installing');
        exit;
    }
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {

            echo "<form method='post'><div class=\"shareit\">
                  <p class='sendmessage'>A user wants to send to you a file (" . $row['filename'] . ").His message is '" . $row['message'] . "'</p>
                  <button class=\"download\" type='submit' name='submit'>Download it</button>
                  </div></form>";
        }
    } else {
        echo 'Invalid file -_-';
    }
    ?>

</body>

</html>