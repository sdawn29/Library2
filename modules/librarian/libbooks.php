<?php 
    session_start();
    if( !isset($_SESSION['username']) ){
        header("Location: https://localhost/library2/librarian.html", true, 301);
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
                <li><a href="libbooks.php" class="active">Books</a></li>
                <li><a href="#">Staff And Students</a></li>
                <li><a href="#">Reports</a></li>
                <li><a href="#">Change Password</a></li
            </ul>
        </div>
        <div class="content">
            <h2 style="margin:0 8px">Books</h2>
            <p style="margin:0 8px">You can Add, Modify or Delete books from the Database</p>
        </div>
        <div class="content2">
            <div class="addbook">
                <h2 style="margin:0 8px;">Add Book</h2>
                <form action="libbooks.php" method="post">
                    <input type="text" name="booktitle" placeholder="Enter Book Tiitle" required><br>
                    <input type="text" name="edition" placeholder="Enter Book Edition" required><br>
                    <input type="text" name="author" placeholder="Enter Author Name" required><br>
                    <input type="text" name="publisher" placeholder="Enter Publisher Name" required><br>
                    <input type="text" name="price" placeholder="Enter Price of Book" required><br>
                    <input type="text" name="booktype" placeholder="Enter Type of Book" required><br>
                    <input type="submit" value="Add" name="addBooks">
                </form>
            </div>
            <div class="deletebook">
                <h2 style="margin:0 8px">Delete A Book</h2>
                <form action="libbooks.php" method="post">
                    <input type="text" name="bookid" style="width:200px;" placeholder="Enter Book ID"><br>
                    <input type="submit" value="Delete" class="delbutton" name="deletebook">
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
            <div class="issuebook">
                <h2 style="margin:0 8px">Issue a Book</h2>
                <form action="libbooks.php" method="post">
                    <input type="text" name="bookid" style="width:200px;" placeholder="Enter Book ID"><br>
                    <input type="text" name="userid" style="width:200px;" placeholder="Enter User ID"><br>
                    <input type="submit" value="Issue" name="issuebook">
                    <?php
                        if (isset($_POST['issuebook'])){
                            if(mysqli_query($conn,$sql)) {
                                echo 'Book Issued to '.$userid;
                            } else {
                                echo 'Error Issuing Book';
                            }
                        }
                    ?>
                </form>
        </div>
        <div class="content" style="margin-top:10px;">
            <h2 style="text-align:center;">View Books</h2>
            <form action="libbooks.php" style="text-align:center;" method="post">
                <input type="submit" name="viewbooks" value="View Books">
            </form>
            <?php
                if (isset($_POST['viewbooks'])) {
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
</body>
</html>
