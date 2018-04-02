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
    
    extract($_POST);
    
    $conn = mysqli_connect($server, $username, $password, $dbname);

    if(!$conn) {
        die("Connection failed: ".mysqli_connect_error());
    }

    if (isset($_POST['addBooks'])){
        $sql = "INSERT INTO bookmaster (book_title, edition, author1, price, publisher, book_type) VALUES('$booktitle', '$edition', '$author', '$price', '$publisher', '$booktype')";
        if(mysqli_query($conn,$sql)) {
            header("Location: http://localhost/library2/modules/librarian/libbooks.php", true, 301);
            exit();
        }
        else {
            echo "Error".$sql."<br>".mysqli_error($conn);
        }
        mysqli_close($conn);
    }

    if (isset($_POST['deletebook'])){
        $q1 = "DELETE FROM bookmaster WHERE book_id=?";
        $sql = $q1;
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("d", $bookid);
        $stmt->execute();
        mysqli_close($conn);
        
    }

    if (isset($_POST['issuebook'])){
        $sql = "INSERT INTO book_issue_details (book_issue_date, book_due_date, book_id, user_id) VALUES(CURDATE(), DATE_ADD(CURDATE(), INTERVAL 7 DAY), '$bookid', '$userid')";
        // mysqli_query($conn,$sql);
    }

    if (isset($_POST['viewbooks'])) {
        $sql = "SELECT * FROM bookmaster";
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
                <li><a href="#">Change Password</a></li
            </ul>
        </div>
        <div class="content">
            <h2 style="margin:0 8px">Staff And Students Portal</h2>
            <p style="margin:0 8px">You can Add, View or Delete Students data from the Database</p>
        </div>
        <div class="content2">
            <div class="addbook">
                <h2 style="margin:0 8px;">Add Students</h2>
                <form action="libbooks.php" method="post">
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
                    <input type="submit" value="Add User" name="adduser">
                </form>
            </div>
            <div class="deletebook">
                <h2 style="margin:0 8px">Remove a Student</h2>
                <form action="libbooks.php" method="post">
                    <input type="text" name="userid" style="width:200px;" placeholder="Enter Registration No." autocomplete="off"><br>
                    <input type="submit" value="Remove user" class="delbutton" name="removeuser">
                    <?php
                        if (isset($_POST['deletebook'])){ 
                            if($stmt->affected_rows > 0){
                                echo '1 Book Deleted';
                            }
                            else {
                                echo 'Error Deleting Book';
                            }
                        }
                    ?>
                </form>
            </div>
            
            <div class="content" style="margin-top:10px;">
                <h2 style="text-align:center;">View Student Database</h2>
                <form action="libbooks.php" style="text-align:center;" method="post">
                    <input type="submit" name="viewusers" value="View Users">
                </form>
                <?php
                    if (isset($_POST['viewstudents'])) {
                ?>
                <table class="bookstable">
                    <tr>
                        <th>Book ID</th>
                        <th>Edition</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>Price</th>
                        <th>Book Type</th>
                    </tr>
                <?php
                    foreach ($result as $book) {
                ?>
                    <tr>
                        <td><?= $book['book_id'] ?></td>
                        <td><?= $book['edition'] ?></td>
                        <td><?= $book['book_title'] ?></td>
                        <td><?= $book['author1'] ?></td>
                        <td><?= $book['publisher'] ?></td>
                        <td><?= $book['price'] ?></td>
                        <td><?= $book['book_type'] ?></td>
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
