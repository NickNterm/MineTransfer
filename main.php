<?php   
session_start();
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "MineTransfer";

$conn = new mysqli($servername, $username, $password, $dbname);
$pass = $_SESSION['password'];
$user = $_SESSION['username'];
$salt = $_SESSION['salt'];
if ($pass != null && $user != null && $salt != null) {
    $sql = "SELECT * FROM Login WHERE username = '$user';";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $salt = $row["salt"];
            if (hash('sha256', $salt . $pass, false) === $row["password"]) {
            } else {
                header("Location: transfer");
            }
        }
    }
} else {
    header("Location: transfer");
}
?>
<?php
$file = $_FILES['file']['tmp_name'];
$message = $_POST['message'];
$expire = $_POST['expire'];
if ($file != null && $message != null && $expire != null) {
    $sql = "INSERT INTO Data (message, code, file, date, expire)  VALUES ('$message', 'test code', '$file', '" . date('d.m.Y.H.i') . "', '$expire')";
    if ($conn->query($sql) === TRUE) {
        header("Location: shareitnow");
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
        <a href="transfer">Logout</a>
        <a href="welcome/files">Files</a>
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
                <button type="submit">Transfer</button>
            </form>
        </div>
    </div>

    <script>
        var textarea = document.querySelector('textarea');

        textarea.addEventListener('keydown', autosize);

        function autosize() {
            var el = this;
            setTimeout(function() {
                el.style.cssText = 'height:auto; padding:0';
                // for box-sizing other than "content-box" use:
                // el.style.cssText = '-moz-box-sizing:content-box';
                el.style.cssText = 'height:' + el.scrollHeight + 'px';
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