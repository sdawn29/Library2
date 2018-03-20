<?php
    $server = 'localhost';
    $username = 'root';
    $password = '';
    $dbname = 'db_srm_lib';
    $msg = "Registration Succesful Login to continue";
    
    $conn = mysqli_connect($server, $username, $password, $dbname);

    if(!$conn) {
        die("Connection failed: ".mysqli_connect_error());
    }

    if (isset($_POST['submit'])) {
        $searchType = $_POST['searchtype'];
        $searchQuery = $_POST['q'];

        $q1 = "select * from book_master where book_id = ?";
        $q2 = "select * from book_master where lower({{type}}) like '%{{query}}%'";

        if ($searchType == 'bookId') {
            $sql = $q1;
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("d", $searchQuery);

            $stmt->execute();
            $res = $stmt->get_result();
        } else {
            $sql = $q2;
            if ($searchType == 'author') {
                $sql = str_replace("{{type}}", "author1", $sql);
            } else {
                $sql = str_replace("{{type}}", "book_title", $sql);
            }
            $searchQuery = strtolower($searchQuery);
            $sql = str_replace("{{query}}", $searchQuery, $sql);
            
            $res = $conn->query($sql);
        }

        $result = $res->fetch_all(MYSQLI_ASSOC);
    }
?>

<!DOCTYPE <!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Welcome User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../styles/welcome.css" />
</head>
<body>
    <div class="header">
        <h2>Online Library Management System</h2>
    </div>
    <div class="container">
        <div class="heading">
            <h2>Search</h2>
            <p>for any books</p>
        </div>
        <div class="searchbox">
            <form action="#" method="POST">
                <input type="radio" name="searchtype" value="bookId" checked>By Book ID
                <input type="radio" name="searchtype" value="author">By Author name
                <input type="radio" name="searchtype" value="bookName">By Book Name<br>
                <input type="text" name="q" class="inputsearchbox">
                <input type="submit" name="submit" value="Search">
                
            </form>
        </div> <!-- searchbox -->
<?php
    if (isset($_POST['submit'])) {
?>
        <table>
            <tr>
                <th>bookid</th>
                <th>book name</th>
                <th>book author</th>
            </tr>
<?php
        foreach ($result as $book) {
?>
            <tr>
                <td><?php echo $book['book_id'] ?></td>
                <td><?php echo $book['book_title'] ?></td>
                <td><?php echo $book['author1'] ?></td>
            </tr>
<?php
        } // for book in $result
?>
        </table>
<?php
    } // if isset($_POST['submit'])
?>
    </div>
</body>
</html>
