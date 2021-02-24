<?php
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "MineTransfer";

$conn = new mysqli($servername, $username, $password, $dbname);
$file = $_FILES['file']['tmp_name'];
$message = $_POST['message'];
$expire = $_POST['expire'];
if ($file != null && $message != null && $expire != null) {
    echo "not null ";
    $target_dir = "/media/data/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if (isset($_POST["submit"])) {
        echo "submit ";
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            echo "move ";
            $name = $_FILES["file"]["name"];
            createcode:
            echo "move ";
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $code = '';
            for ($i = 0; $i < 8; $i++) {
                $code .= $characters[rand(0, $charactersLength - 1)];
            }
            echo "move ";
            $checksql = "SELECT code FROM Data";
            $result = $conn->query($checksql);
            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
                    if ($row["code"] == $checksql){
                        echo "move ";
                        goto createcode;
                    }
                }
            }
            echo "code ";
            rename($target_dir.basename($_FILES["file"]["name"]),$target_dir.$code);
            $sql = "INSERT INTO Data (message, code, filename, date, expire)  VALUES ('$message', '$code', '$name', '" . date('d.m.Y.H.i') . "', '$expire')";
            if ($conn->query($sql) === TRUE) {
                echo "done";
            } else {
                echo $conn->error;
            }
        }
    }
}
?>
<html>
<link rel="stylesheet" href="mainstyle.css">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="signup">Register</a>
        <a href="log_in">Login</a>
        <a href="https://github.com/NickNterm">GitHub</a>
    </div>

    <div id="main">
        <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
        <div class="uploadform">
            <img style="width: 250px;" src="upload.png" />
            <form action="" method="post" enctype="multipart/form-data">
                <input type="file" name="file" id="file" class="inputfile" />
                <label for="file">Upload a file</label>
                <textarea rows='1' name="message" placeholder="Message"></textarea>
                <select name="expire">
                    <option value="1">Expire in 1 hour</option>
                    <option value="2">Expire in 12 hours</option>
                    <option value="3">Expire in 1 day</option>
                    <option value="4">Expire in 2 days</option>
                    <option value="5">Expire in 3 days</option>
                    <option value="6">Expire in 1 week</option>
                </select>
                <button type="submit" name="submit">Transfer</button>
            </form>
        </div>
    </div>

    <script>
        var textarea = document.querySelector('textarea');

        textarea.addEventListener('keydown', autosize);

        function autosize() {
            var el = this;
            setTimeout(function() {
                el.style.cssText = 'height:auto; padding: 15px 15px 15px 15px;';
                el.style.cssText = 'height:' + (el.scrollHeight + 2) + 'px';
            }, 0);
        }

        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
            document.getElementById("main").style.marginLeft = "250px";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("main").style.marginLeft = "0";
        }
    </script>

</body>

</html>