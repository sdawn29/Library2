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

        
        
        $sql = "INSERT INTO user_master (User_ID, User_name, User_Desc, User_PWD, User_Type, Gender, Dept, Mail_ID, Phone, Library_name) VALUES('$reg','$user', '$desg', '$pass', '$type', '$gender', '$dept', '$email', '$phone', '$libname')";


        if(mysqli_query($conn,$sql)) {
            header("Location: http://localhost/library2/index.html", true, 301);
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
        <link rel="stylesheet" href="../styles/index2Style.css" />
    </head>
    
    <body>
        <div class="header">
            <div class="containerHeader">
                <div class="navbar">
                    <ul>
                        <li style="float:left; font-weight:600;" class="brand" ><a href="http://localhost/library2/index.html">Online Library Management System</a></li>
                        <li style="float:right;" class="brand"><a href="librarian.html">Librarian Login Portal</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="login">
            <h1>Sign Up</h1>
            <form action="userregister.php" method="post">
            <input class="inputstyle" type="text" name="reg" placeholder="Enter Register No." required><br>
                    <input class="inputstyle" type="text" name="user" placeholder="Enter Username" required><br>
                    <input class="inputstyle" type="password" name="pass" placeholder="Enter Password" required><br>
                    <input class="inputstyle" type="text" name="desg" placeholder="Enter Designation" required><br>
                    <input class="inputstyle" type="text" name="type" placeholder="Enter User type" required><br>
                    
                    <label for="Gender" style="margin:0 8px;">Gender</label><br>
                    <input class="radiostyle" type="radio" name="gender" value="Male">
                    <label>Male</label>
                    <input class="radiostyle" type="radio" name="gender" value="female">
                    <label>Female</label><br>
                    <input class="inputstyle" type="text" name="dept" placeholder="Enter Department" required><br>
                    <input class="inputstyle" type="email" name="email" placeholder="Enter email" required><br>
                    <input class="inputstyle" type="text" name="phone" placeholder="Enter Phone no." required><br>
                    <input class="inputstyle" type="text" name="libname" placeholder="Enter Library name" required><br>
                    <input type="submit" value="Register" name="adduser"><br>
            </form>
        </div>
    </body>