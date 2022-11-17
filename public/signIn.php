<?php

require_once "../src/config/functions.global.php";



// if (!isset($_SESSION)) {


//     header('location:dashboard.php');
// }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/signin.css" />
    <title><?php pageTitle('sign in') ?></title>
</head>

<body>

    <div class="selectionContainer" onclick="activeEle(event)">
        <button class="doctorBtn">
            <p>Doctor</p>
        </button>
        <button class="patientBtn active">Patient</button>
    </div>


    <div class="patientForm">
        <form action="../src/auth/signin.php" method="post">

            <input type="hidden" name="role" value="patient" />
            <label for="email"> Email: </label>
            <input type="email" name="email" placeholder="Your email" required />
            <label for="password"> Password: </label>
            <input type="password" name="password" placeholder="Your password" required />

            <button type="submit" name="signinBtn">Sign in</button>

        </form>
    </div>

    <div class="doctorForm">
        <form action="../src/auth/signin.php" method="post">

            <input type="hidden" name="role" value="doctor" />
            <label for="email"> Email: </label>
            <input type="email" name="email" placeholder="Your email" required />
            <label for="password"> Password: </label>
            <input type="password" name="password" placeholder="Your password" required />

            <button type="submit" name="signinBtn">Sign in</button>

        </form>
    </div>

    <script>
        function activeEle(event) {

            let ele = event.target;

            let eleDoc = document.querySelector('.doctorBtn');

            let eleDocForm = document.querySelector('.doctorForm');

            let elePat = document.querySelector('.patientBtn');

            let elePatForm = document.querySelector('.patientForm');


            if (ele.innerText.toLowerCase() === 'doctor') {

                eleDoc.classList.add("active");
                eleDocForm.style.display = "block"

                elePat.classList.remove("active");
                elePatForm.style.display = "none"
            } else {

                elePat.classList.add("active");
                elePatForm.style.display = "block"

                eleDoc.classList.remove("active");
                eleDocForm.style.display = "none"
            }

        }
    </script>
</body>

</html>