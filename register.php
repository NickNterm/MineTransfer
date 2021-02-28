<?php
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "MineTransfer";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$user = $_POST['Username'];
settype($user, "string");
$user = str_replace("'", "\"", $user);
$pass = $_POST['Password'];
settype($pass, "string");
$pass = str_replace("'", "\"", $pass);
$pass2 = $_POST['Password2'];
settype($pass2, "string");
$pass2 = str_replace("'", "\"", $pass2);
if ($pass == $pass2 && $pass != null) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $salt = '';
    for ($i = 0; $i < 8; $i++) {
        $salt .= $characters[rand(0, $charactersLength - 1)];
    }
    $hashedpass = hash('sha256', $salt . $pass, false);
    $sql = "INSERT INTO Login (username, password, salt)  VALUES ('$user', '$hashedpass', '$salt')";
    if ($conn->query($sql) === TRUE) {
        mkdir('/var/www/html/minetransfer/premium/'.$user.'/');
        header('Location: log_in');
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
            <?php
            $pass = $_POST['Password'];
            settype($pass, "string");
            $pass = str_replace("'", "\"", $pass);
            $pass2 = $_POST['Password2'];
            settype($pass2, "string");
            $pass2 = str_replace("'", "\"", $pass2);
            if($pass != $pass2){
                echo '<div class="alert">
                <p class="error">Passwords Don\'t Match</p>
            </div>';
            }
            ?>
            <div class="inputs">
                <input type="text" name="Username" placeholder="Enter Username" required>
                <input type="password" name="Password" minlength="8" placeholder="Enter Password" required>
                <input type="password" name="Password2" minlength="8" placeholder="Re-enter Password" required>
            </div>
            <button class="btn" type="submit">Login</button>
        </div>
    </form>

</body>

</html>