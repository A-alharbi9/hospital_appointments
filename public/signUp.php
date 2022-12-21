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
    <link rel="stylesheet" href="./styles/signUp.css" />
    <title><?php pageTitle('sign up') ?></title>
</head>

<body>

    <?php include_once("./includes/nav.php") ?>

    <div class="section_wrapper">

        <div class="form_wrapper">
            <div class="form_img_wrapper">
                <img src="../public/images/signup_image.jpg" alt="signup_image" />
            </div>

            <form action="../src/auth/signup.php" method="post">

                <div class="form_element">
                    <label for="role">Are you a</label>

                    <select name="role">
                        <option value="patient">patient</option>
                        <option value="doctor">doctor</option>
                    </select>
                </div>

                <div class="form_element">
                    <label for="fullName"> Full name: </label>
                    <input type="text" name="fullName" placeholder="Your full name" />
                </div>

                <div class="form_element">
                    <label for="email"> Email: </label>
                    <input type="email" name="email" placeholder="Your email" />
                </div>

                <div class="form_element">
                    <label for="password"> Password: </label>
                    <input type="password" name="password" placeholder="Your password" />
                </div>

                <div class="form_element">
                    <label for="confirmPassword"> Confirm Password: </label>
                    <input type="password" name="confirmPassword" placeholder="Your confirm password" />
                </div>

                <div class="form_button_wrapper">
                    <button type="submit" name="signupBtn">Sign up</button>
                </div>
            </form>
        </div>
    </div>

    <?php include_once("./includes/footer.php") ?>

</body>

</html>