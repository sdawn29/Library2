<?php
    
    $server = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'db_srm_lib';
    $msg = "Registration Succesful Login to continue";
    
    extract($_POST);
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $conn = mysqli_connect($server, $username, $password, $dbname);

        if(!$conn) {
            die("Connection failed: ".mysqli_connect_error());
        }

        
        
        $sql = "INSERT INTO librarian (name, username, password) VALUES('$reg','$user', '$pass')";

        if(mysqli_query($conn,$sql)) {
            header("Location: http://localhost/library2/librarian.html", true, 301);
            $login=true;
            exit();
        }
        else {
            echo "Error".$sql."<br>".mysqli_error($conn);
        }
        mysqli_close($conn);
    }
    
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Register</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="../styles/liblogin.css">
    </head>
    
    <body>
        <div class="login">
            <h1>Librarian Portal Registration</h1>
            <form action="libregister.php" method="post">
                
                <label for="Name">Full Name.</label><br>
                <input class="inputstyle" type="text" name="reg" placeholder="Enter Register No."><br>
                
                <label for="user">Username</label><br>
                <input class="inputstyle" type="text" name="user" placeholder="Enter Username"><br>
                
                <label for="pass">Password</label><br>
                <input class="inputstyle" type="password" name="pass" placeholder="Enter Password"><br>
                
                <input type="submit" value="Register" class="inputstyle">
            </form>
        </div>
    </body>
</html>