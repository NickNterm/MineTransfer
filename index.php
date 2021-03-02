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
            <?php
            session_start();
            $_SESSION['password'] = null;
            $_SESSION['username'] = null;
            $_SESSION['salt'] = null;
            $servername = "localhost";
            $username = "admin";
            $password = "admin";
            $dbname = "MineTransfer";

            $conn = new mysqli($servername, $username, $password, $dbname);
            $file = $_FILES['file']['tmp_name'];
            $message = $_POST['message'];
            $expire = $_POST['expire'];
            if ($file == null || $message == null || $expire == null) {
                if (isset($_POST["submit"])) {
                    echo "<div class= 'alert'><p class='error' >please fill all fields</p></div>";
                }
            }
            ?>
            <form action="" method="post" enctype="multipart/form-data">
                <progress id="progressBar" value="0" max="100"></progress>
                <input type="file" name="file" id="file" class="inputfile" onchange="uploadFile()" />
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
    <?php
    session_start();
    $_SESSION['password'] = null;
    $_SESSION['username'] = null;
    $_SESSION['salt'] = null;
    $servername = "localhost";
    $username = "admin";
    $password = "admin";
    $dbname = "MineTransfer";
    $conn = new mysqli($servername, $username, $password, $dbname);
    $file = $_FILES['file']['tmp_name'];
    $message = $_POST['message'];
    $expire = $_POST['expire'];
    if ($file != null && $message != null && $expire != null) {
        $target_dir = "transfers/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (isset($_POST["submit"])) {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                $name = $_FILES["file"]["name"];
                createcode:
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $code = '';
                for ($i = 0; $i < 8; $i++) {
                    $code .= $characters[rand(0, $charactersLength - 1)];
                }
                $checksql = "SELECT code FROM Data";
                $result = $conn->query($checksql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        if ($row["code"] == $checksql) {
                            goto createcode;
                        }
                    }
                }
                $finalfile = pathinfo('transfers/' . basename($_FILES["file"]["name"]));
                rename($target_dir . basename($_FILES["file"]["name"]), $target_dir . $code);
                $sql = "INSERT INTO Data (message, code, filename, date, expire)  VALUES ('$message', '$code', '$name', '" . date('d.m.Y.H.i') . "', '$expire')";
                if ($conn->query($sql) === TRUE) {
                    echo "
                <div class=\"shareit\">
                Share the link : minetransfer.mine.bz/file/" . $code . " to install the file.
            </div>";
                } else {
                    echo $conn->error;
                }
            }
        }
    }
    ?>
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
            _("progressBar").value = Math.round(percent);
        }
    </script>

</body>

</html>