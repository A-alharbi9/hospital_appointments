<?php

require_once "../src/config/functions.global.php";

?>

<head>
    <link rel="stylesheet" href="./styles/nav.css" />
</head>
<nav>
    <span id="logo">
        <a>Hoto loto</a>
    </span>
    <ul>
        <?php
        foreach ($siteData['navItems'] as $key => $value) {
            echo "<li><a href=" . './' . ucwords($siteData['navItems'][strtolower($value)]) . '.php' . " >" . ucwords($siteData['navItems'][strtolower($value)]) . "</a></li>";
        }
        ?>
    </ul>
    <?=
    isset($_SESSION['fullName']) ?  "
            <div class='nav_auth_wrapper'>
                <button class='nav_btn_auth_main'>
                    <a href='../public/dashboard.php'>
                    " . $_SESSION['fullName'] . "
                    </a>
                </button> 
            </div>
            "
        :  "
            <div>
                <button class='nav_btn_secondary'>
                    <a href='../public/signIn.php'>
                        Sign in
                    </a>
                </button>
                <button class='nav_btn_main'>
                    <a href='../public/signUp.php'>
                        Sign up
                    </a>
                </button>
            </div>
                "
    ?>
</nav>