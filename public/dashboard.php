<?php

require_once "../src/config/functions.global.php";

if (!isset($_SESSION)) {
    session_start();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php pageTitle('dashboard') ?></title>
</head>

<body>

    <h1>Dashboard</h1>
    <?php
    if (isset($_SESSION['fullName'])) {
        echo "<h1>Welcome, " . $_SESSION['fullName'] . "</h1>";
    } else {
        echo "<h1>Sign in to view this page!</h1>";
    }
    ?>

</body>

</html>