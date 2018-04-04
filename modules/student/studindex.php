<?php 
    session_start();
    if( !isset($_SESSION['username']) ){
        header("Location: https://localhost/library2/modules/liblogin.php", true, 301);
        exit();
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
                    <li style="float:left; font-weight:600;" class="brand" ><a href="#">Online Library Management System Student Portal</a></li>
                    <li style="float:right;" class="brand"><a href="logout.php" class="session" style="color:#f44336">Sign Out</a></li>
                    <li style="float:right;" class="brand"><a href="librarian.html" class="session" style="color:#B2FF59"><?php echo $_SESSION['username'] ?></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="navmenu">
            <ul>
                
                <li><a href="studindex.php" class="active">Home</a></li>
                <li><a href="studbook.php">Books</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact Us</a></li>
                <li><a href="#">FAQ</a></li
            </ul>
        </div>
        <div class="content">
            <h2>Welcome To Online Library Management Student Portal</h2>
            <p>Select any Option from the side bar</p>
        </div>
    </div>
</body>
</html>
