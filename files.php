<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<style>
    body {
        font-family: "Lato", sans-serif;
    }

    .grid-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        grid-column-gap: 20px;
        grid-row-gap: 20px;
    }

    .grid-item {
        width: auto;
        min-width: 200px;
        height: 40px;
        overflow: hidden;
        text-overflow: ellipsis;
        padding-left: 12px;
        padding-right: 12px;
        line-height: 40px;
        border-radius: 3px;
        background-color: none;
        border: 1px solid rgba(94, 94, 94, 0.8);
        transition: 0.2s;
    }

    .grid-item:hover {
        box-shadow: 0px 0px 0px black, 0 0 5px rgb(102, 102, 102);
    }

    .sidenav {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 1;
        top: 0;
        left: 0;
        background-color: #111;
        overflow-x: hidden;
        transition: 0.5s;
        padding-top: 60px;
    }

    .sidenav a {
        padding: 8px 8px 8px 32px;
        text-decoration: none;
        font-size: 25px;
        color: #818181;
        display: block;
        transition: 0.3s;
    }

    .sidenav a:hover {
        color: #f1f1f1;
    }

    .sidenav .closebtn {
        position: absolute;
        top: 0;
        right: 25px;
        font-size: 36px;
        margin-left: 50px;
    }

    @media screen and (max-height: 450px) {
        .sidenav {
            padding-top: 15px;
            position: absolute;
            top: 0;
            left: 0;
        }

        .sidenav a {
            font-size: 18px;
        }
    }

    .inputfile+label {
        border-radius: 4px;
        width: 100%;
        height: 100%;
        display: inline-block;
        background: none;
        color: rgb(0, 0, 0);
        transition: 0.3s;
    }

    .inputfile {
        background: none;
        width: 0.1px;
        height: 0.1px;
        opacity: 0;
        overflow: hidden;
        position: absolute;
        z-index: -1;
    }

    .progressdiv {
        background: rgb(77, 77, 77);
        position: relative;
        top: -1000;
        left: 0;
        width: 0%;
        height: 1000px;
        z-index: -1;
    }
</style>

<body>
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="transfer">Logout</a>
        <a href="welcome/files">Files</a>
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
        $file = $_FILES['file']['tmp_name'];
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

                                echo '<div class="grid-item">' . $file . '</div>';
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
        if ($file != null) {
            if (move_uploaded_file($_FILES["file"]["tmp_name"], 'premium/' . basename($_FILES["file"]["name"]))) {
                header("Location: myfiles");
            }
        }
        ?>
        <div class="grid-item" style="padding:0;">
            <form id="mainform" method="post" action="">
                <input type="file" name="file" id="file" class="inputfile" onchange="uploadFile()" />
                <label for="file" style="margin-left: 10px;">Upload a file</label>
            </form>
            <div class="progressdiv" id="progressdivadf"></div>

        </div>

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
            if(percent == 100){
                document.getElementById("mainform").submit();
            }
        }
    </script>
</body>

</html>