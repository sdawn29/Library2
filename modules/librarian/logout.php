<?php
    session_start();
    session_destroy();
    header("Location: https://localhost/library2/librarian.html", true, 301);
    exit();
?>