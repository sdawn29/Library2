<?php 
    session_start();
        
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
                    <li style="float:right;" class="brand"><a href="librarian.html" class="session" style="color:#B2FF59"><?php echo $_SESSION['username'] ?></a></li>
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
            <h2>Books</h2>
            <p>You can Add, Modify or Delete books from the Database</p>
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
        </div>
    </div>
</body>
</html>
