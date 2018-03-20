<?php
  session_start();
  $server = 'localhost';
  $username = 'root';
  $password = '';
  $dbname = 'db_srm_lib';
  $msg = "Registration Succesful Login to continue";
  $usernameErr = $passwordErr = $user = $pass = $loginError ="";
  $countuser = $countpass = 0;

  $conn = mysqli_connect($server, $username, $password, $dbname);

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty($_POST['user'])) {
      $countuser = $countuser+1;
      $usernameErr= "Please Enter Username";
    } else {
      $user = trim($_POST["user"]);
    }
    if(empty($_POST['pass'])) {
      $countpass = $countpass + 1;
      $passwordErr = "PLease Enter Password";
    } else {
      $pass = trim($_POST["pass"]);
    }
  }
  if(!$conn) {
      die("Connection failed: ".mysqli_connect_error());
  }

  if(!empty($user) && !empty($pass)) {
    $sql = "SELECT * FROM  user_master WHERE User_name = '$user' AND User_PWD = '$pass'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    if($count == 1) {
      $_SESSION['username'] = $user;
      header("Location: http://localhost/library2/modules/login_success.php", true, 301);
    } else {
      $loginError = "Username Or Password Doesn`t Match.";
    }
  }
  mysqli_close($conn);
?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>Login</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../styles/loginstyle.css">
    </head>

    <body>
        <div class="login">
            <h1>Login</h1>
            <form action="login.php" method="post">
                <label for="user">Username</label><br>
                <input class="inputstyle" type="text" name="user" placeholder="Enter Username"><br>
                <?php

                    echo "<p style='color:red; margin:0;'>$usernameErr</p>";
                ?>
                <label for="pass">Password</label><br>
                <input class="inputstyle" type="password" name="pass" placeholder="Enter Password"><br>
                <?php

                    echo "<p style='color:red;margin: 0;'>$passwordErr</p>";
                ?><br>
                <input type="submit" value="Login" class="loginstyle"><br>
                <?php
                  echo "<p style='color:red;'>$loginError</p>";
                ?>
            </form>
        </div>
    </body>
</html>
