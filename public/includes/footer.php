<?php

require_once "../src/config/functions.global.php";

?>

<head>
    <link rel="stylesheet" href="./styles/footer.css" />
</head>
<footer>
    <div class="items_logo_wrapper">
        <div class="footer_logo_wrapper">
            <span id="logo">
                <a href="../public/index.php">Hoto loto</a>
            </span>
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit.
                Eos ducimus esse numquam aut.
            </p>
        </div>
        <div class="items_wrapper">
            <ul class="item">
                <p class="footer_main_text">Company</p>
                <li>news</li>
                <li>about us</li>
            </ul>
            <ul class="item">
                <p class="footer_main_text">Polices</p>
                <li>privacy policy</li>
                <li>cookies policy</li>
                <li>terms & services</li>
            </ul>
            <ul class="item">
                <p class="footer_main_text">Contact</p>
                <li>+1-512-555-5212</li>
                <li>test@company.com</li>
            </ul>
        </div>
    </div>
    <div class="copy_wrapper">
        All right reserved <?php echo date('Y') ?>
    </div>
</footer>