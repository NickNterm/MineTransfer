<?php
session_start();
$pass = $_SESSION['password'];
$user = $_SESSION['username'];
$salt = $_SESSION['salt'];
if($pass != null && $user != null && $salt != null){
    
}else{
    header("Location: transfer");
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
            <img style="width: 200px;" src="upload.png" />
            <form action="" method="post">
                <input type="file" name="file" id="file" class="inputfile" />
                <label for="file">Upload a file</label>
                <textarea rows='1' name="message" placeholder="Message"></textarea>
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