<?php
session_start();
$user = $_SESSION['username'];
if ($_FILES["file"] != null && $user != null) {
    if (move_uploaded_file($_FILES["file"]["tmp_name"], 'premium/' . $user . '/' . basename($_FILES["file"]["name"]))) {
        header("Location: myfiles");
    }
}
$download = $_POST['download'];
if ($download != null && $user != null) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $download . '"');
    header('Pragma: public');
    flush(); // Flush system output buffer
    readfile('premium/' . $user . '/' . $download);
    die();
}
?>
<html>
<link rel="stylesheet" href="files.css">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="welcome">Transfer</a>
        <a href="transfer">Logout</a>
        <a href="https://github.com/NickNterm">GitHub</a>
    </div>

    <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
    <div class="grid-container">
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
                        $dir = 'premium/' . $user;
                        if ($dh = opendir($dir)) {
                            while (($file = readdir($dh)) !== false) {
                                if ($file != "." && $file != "..") {
                                    echo '<div class="grid-item" id="' . $file . '" onclick="downloadfile(this.id)">' . $file . '</div>';
                                }
                            }
                            closedir($dh);
                        }
                    } else {
                        header("Location: transfer");
                    }
                }
            }
        } else {
            header("Location: log_in");
        }

        ?>
        <form id="mainform" action="" method="post" enctype="multipart/form-data">
            <div class="grid-item" style="padding:0;">
                <input type="file" name="file" id="file" class="file" onchange="uploadFile()" />
                <label for="file" style="margin-left: 10px;">Upload a file</label>

                <div class="progressdiv" id="progressdivadf"></div>
            </div>
        </form>
        <form id="downloadform" action="" method="post" enctype="multipart/form-data">
            <input type="hidden" id="download" name="download" value='' /></input>
        </form>
    </div>
    <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "250px";
            document.getElementById("body").style.marginLeft = "250px";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
            document.getElementById("body").style.marginLeft = "0";
        }

        function _(el) {
            return document.getElementById(el);
        }

        function uploadFile() {
            var file = _("file").files[0];
            var formdata = new FormData();
            formdata.append("file", file);
            var ajax = new XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandler, false);
            ajax.open("POST", "");
            ajax.send(formdata);
        }

        function progressHandler(event) {
            var percent = (event.loaded / event.total) * 100;
            _("progressdivadf").style.width = Math.round(percent) + "%";
            if (percent == 100) {
                _("mainform").submit();
            }
        }

        function downloadfile(id) {
            _("download").value = String(id);
            _("downloadform").submit();
        }
    </script>

</body>

</html>