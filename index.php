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
            <form action="" method="post">
                <input type="file" name="file" id="file" class="inputfile" />
                <label for="file">Upload a file</label>
                <textarea rows='1' name="message" placeholder="Message"></textarea>
                <select name="cars" id="cars">
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
