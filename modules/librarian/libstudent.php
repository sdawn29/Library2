<?php 
    session_start();
    if( !isset($_SESSION['username']) ){
        header("Location: https://localhost/library2/modules/liblogin.php", true, 301);
        exit();
    }   
    $server = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'db_srm_lib';
    
    $aduser_result = FALSE;
    extract($_POST);
    
    $conn = mysqli_connect($server, $username, $password, $dbname);

    if(!$conn) {
        die("Connection failed: ".mysqli_connect_error());
    }

    if (isset($_POST['adduser'])){
        $sql = "INSERT INTO user_master (User_ID, User_name, User_Desc, User_PWD, User_Type, Gender, Dept, Mail_ID, Phone, Library_name) VALUES('$reg','$user', '$desg', '$pass', '$type', '$gender', '$dept', '$email', '$phone', '$libname')";

        $aduser_result = mysqli_query($conn,$sql);
    }

    if (isset($_POST['removeuser'])){
        $q1 = "DELETE FROM user_master WHERE User_ID=?";
        $sql = $q1;
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $userid);
        $stmt->execute();
        mysqli_close($conn);
        
    }

    if (isset($_POST['viewuserdet'])){
        $sql = "SELECT * FROM book_issue_details WHERE user_id = '$userid'";
        $res = mysqli_query($conn,$sql);
        $result = $res->fetch_all(MYSQLI_ASSOC);
        mysqli_close($conn);
        // mysqli_query($conn,$sql);
    }

    if (isset($_POST['viewuser'])) {
        $sql = "SELECT * FROM user_master";
        $res = mysqli_query($conn,$sql);
        $result = $res->fetch_all(MYSQLI_ASSOC);
        mysqli_close($conn);
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Online Library Management Librarian Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="styles/librarianStyle.css" />
</head>
<body>
    <div class="header">
        <div class="containerHeader">
            <div class="navbar">
                <ul>
                    <li style="float:left; font-weight:600;" class="brand" ><a href="#">Online Library Management System Librarian Portal</a></li>
                    <li style="float:right;" class="brand"><a href="logout.php" class="session" style="color:#f44336">Sign Out</a></li>
                    <li style="float:right;" class="brand"><a href="#" class="session" style="color:#B2FF59"><?php echo $_SESSION['username'] ?></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="navmenu">
            <ul>
                <li><a href="librarianindex.php">Home</a></li>
                <li><a href="libbooks.php">Books</a></li>
                <li><a href="libstudent.php" class="active">Staff And Students</a></li>
                <li><a href="#">Reports</a></li>
                <li><a href="#">Change Password</a></li>
            </ul>
        </div>
        <div class="content">
            <h2 style="margin:0 8px">Staff And Students Portal</h2>
            <p style="margin:0 8px">You can Add, View or Delete Students data from the Database</p>
        </div>
        <div class="content2">
            <div class="addbook">
                <h2 style="margin:0 8px;">Add Students</h2>
                <form action="libstudent.php" method="post">
                    <input class="inputstyle" type="text" name="reg" placeholder="Enter Register No."><br>
                    <input class="inputstyle" type="text" name="user" placeholder="Enter Username"><br>
                    <input class="inputstyle" type="password" name="pass" placeholder="Enter Password"><br>
                    <input class="inputstyle" type="text" name="desg" placeholder="Enter Designation"><br>
                    <input class="inputstyle" type="text" name="type" placeholder="Enter User type"><br>
                    
                    <label for="Gender" style="margin:0 8px;">Gender</label><br>
                    <input class="radiostyle" type="radio" name="gender" value="Male">
                    <label>Male</label>
                    <input class="radiostyle" type="radio" name="gender" value="female">
                    <label>Female</label><br>
                    <input class="inputstyle" type="text" name="dept" placeholder="Enter Department"><br>
                    <input class="inputstyle" type="email" name="email" placeholder="Enter email"><br>
                    <input class="inputstyle" type="text" name="phone" placeholder="Enter Phone no."><br>
                    <input class="inputstyle" type="text" name="libname" placeholder="Enter Library name"><br>
                    <input type="submit" value="Add User" name="adduser"><br>
                    <?php
                        if (isset($_POST['adduser'])) {
                           if($aduser_result) {
                               echo '1 User Added';
                           } else {
                               echo 'Error Adding User';
                           }
                        }
                    ?>
                </form>
            </div>
            <div class="deletebook">
                <h2 style="margin:0 8px">Remove a Student</h2>
                <form action="libstudent.php" method="post">
                    <input type="text" name="userid" style="width:200px;" placeholder="Enter Registration No." autocomplete="off"><br>
                    <input type="submit" value="Remove user" class="delbutton" name="removeuser">
                    <?php
                        if (isset($_POST['removeuser'])){ 
                            if($stmt->affected_rows > 0){
                                echo '1 User Removed';
                            }
                            else {
                                echo 'Error Removing User';
                            }
                        }
                    ?>
                </form>
            </div>


            <div class="issuebook">
                <h2 style="margin:0 8px">View About a Student</h2>
                <form action="libstudent.php" method="post">
                    <input type="text" name="userid" style="width:200px;" placeholder="Enter Registration Number"><br>
                    <input type="submit" value="View" name="viewuserdet">
                </form>
                <?php
                    if (isset($_POST['viewuserdet'])) {
                ?>
                <table class="bookstable">
                    <tr>
                        <th>Register No.</th>
                        <th>Book Name</th>
                        <th>Issue Date</th>
                        <th>Due Date</th>
                    </tr>
                <?php
                    foreach ($result as $user) {
                ?>
                    <tr>
                        <td><?= $user['user_id'] ?></td>
                        <td><?= $user['book_id'] ?></td>
                        <td><?= $user['book_issue_date'] ?></td>
                        <td><?= $user['book_due_date'] ?></td>
                    </tr>
                <?php
                    }
                ?>    
                </table>
                <?php
                    }
                ?>
            </div>
            
            <div class="content" style="margin-top:10px;">
                <h2 style="text-align:center;">View Student Database</h2>
                <form action="libstudent.php" style="text-align:center;" method="post">
                    <input type="submit" name="viewuser" value="View Users">
                </form>
                <?php
                    if (isset($_POST['viewuser'])) {
                ?>
                <table class="bookstable">
                    <tr>
                        <th>Registration no.</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Department</th>
                        <th>Mail ID</th>
                        <th>Phone</th>
                    </tr>
                <?php
                    foreach ($result as $user) {
                ?>
                    <tr>
                        <td><?= $user['User_ID'] ?></td>
                        <td><?= $user['User_name'] ?></td>
                        <td><?= $user['Gender'] ?></td>
                        <td><?= $user['Dept'] ?></td>
                        <td><?= $user['Mail_ID'] ?></td>
                        <td><?= $user['Phone'] ?></td>
                    </tr>
                <?php
                    }
                ?>    
                </table>
                <?php
                    }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
