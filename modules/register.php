<?php
    
    $server = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'db_srm_lib';
    $msg = "Registration Succesful Login to continue";
    
    extract($_POST);
    $key_id = $reg;
    
    $conn = mysqli_connect($server, $username, $password, $dbname);

    if(!$conn) {
        die("Connection failed: ".mysqli_connect_error());
    }

    
    
    $sql = "INSERT INTO user_master (User_ID, User_name, User_Desc, User_PWD, User_Type, Gender, Dept, Mail_ID, Phone, Library_name) VALUES('$reg','$user', '$desg', '$pass', '$type', '$gender', '$dept', '$email', '$phone', '$libname')";

    if(mysqli_query($conn,$sql)) {
        header("Location: http://localhost/library2/success.html", true, 301);
        $login=true;
        exit();
    }
    else {
        echo "Error".$sql."<br>".mysqli_error($conn);
    }
    mysqli_close($conn);
    
?>