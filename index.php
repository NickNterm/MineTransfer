<?php
session_start();
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "MineTranfer";
$_SESSION['password'] = null;
$_SESSION['username'] = null;
$_SESSION['salt'] = null;
$_SESSION['userid'] = null;
$conn = new mysqli($servername, $username, $password, $dbname);
$user = $_POST['Username'];
settype($user, "string");
$user = str_replace("'", "\"", $user);
$pass = $_POST['Password'];
settype($pass, "string");
$pass = str_replace("'", "\"", $pass);
if ($user != null) {
    $sql = "SELECT * FROM Login WHERE username = '$user';";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $salt = $row["salt"];
            if (hash('sha256', $salt . $pass, false) === $row["password"]) {
                $_SESSION['password'] = $pass;
                $_SESSION['username'] = $user;
                $_SESSION['salt'] = $salt;
                header("Location: /logedin");
            }
        }
    }
}
?>

<link rel="stylesheet" href="loginstyle.css">
<html>

<body>
    <form action="" method="post">
        <div class="container">
            <div>
                <img src="logo.png">
                <p class="powertext">Powered by <a class="nikolas" href="https://github.com/NickNterm">Nikolas Ntermaris</a></p>
            </div>
            <hr>
            <div class="inputs">
                <input type="text" name="Username" placeholder="Enter Username" required>
                <input type="password" name="Password" placeholder="Enter Password" required>
            </div>
            <button class="btn" type="submit">Login</button>
            <div class="signup">
                <a unselectable="on" href="signup">Sign up</a>
            </div>
        </div>
    </form>

</body>

</html>