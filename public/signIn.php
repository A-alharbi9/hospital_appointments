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
    <link rel="stylesheet" href="./styles/signIn.css" />
    <title><?php pageTitle('sign in') ?></title>
</head>

<body>

    <?php include_once("./includes/nav.php") ?>

    <div class="section_wrapper">

        <div class="form_wrapper">

            <div class="form_img_wrapper">
                <img src="../public/images/signin_image.jpg" alt="signin_image" />
            </div>

            <div class="form_selection_wrapper">

                <div class="selectionContainer" onclick="activeEle(event)">
                    <button class="doctor_btn">
                        <p>Doctor</p>
                    </button>
                    <button class="patient_btn active">Patient</button>
                </div>


                <div class="patientForm">
                    <form action="../src/auth/signin.php" method="post">
                        <input type="hidden" name="role" value="patient" />
                        <div class="form_element">
                            <label for="email"> Email: </label>
                            <input type="email" name="email" placeholder="Your email" required />
                        </div>

                        <div class="form_element">
                            <label for="password"> Password: </label>
                            <input type="password" name="password" placeholder="Your password" required />
                        </div>

                        <div class="form_button_wrapper">
                            <button type="submit" name="signinBtn">Sign in</button>
                        </div>
                    </form>
                </div>

                <div class="doctorForm">
                    <form action="../src/auth/signin.php" method="post">

                        <input type="hidden" name="role" value="doctor" />


                        <div class="form_element">
                            <label for="email"> Email: </label>
                            <input type="email" name="email" placeholder="Your email" required />
                        </div>

                        <div class="form_element">
                            <label for="password"> Password: </label>
                            <input type="password" name="password" placeholder="Your password" required />
                        </div>

                        <div class="form_button_wrapper">
                            <button type="submit" name="signinBtn">Sign in</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>

    <?php include_once("./includes/footer.php") ?>


</body>
<script>
    function activeEle(event) {

        let ele = event.target;

        let eleDoc = document.querySelector('.doctor_btn');

        let eleDocForm = document.querySelector('.doctorForm');

        let elePat = document.querySelector('.patient_btn');

        let elePatForm = document.querySelector('.patientForm');


        if (ele.innerText.toLowerCase() === 'doctor') {

            eleDoc.classList.add("active");
            eleDocForm.style.display = "flex"
            eleDocForm.style.flexDirection = "column"
            eleDocForm.style.justifyContent = "center"
            eleDocForm.style.alignItems = "center"

            elePat.classList.remove("active");
            elePatForm.style.display = "none"
        } else {

            elePat.classList.add("active");
            elePatForm.style.display = "flex"
            elePatForm.style.flexDirection = "column"
            elePatForm.style.justifyContent = "center"
            elePatForm.style.alignItems = "center"

            eleDoc.classList.remove("active");
            eleDocForm.style.display = "none"
        }

    }
</script>

</html>