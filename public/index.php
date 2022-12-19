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
    <title><?php pageTitle() ?></title>
    <link rel="stylesheet" href="./styles/index.css" />
</head>

<body>
    <?php include_once("./includes/nav.php") ?>

    <section class="hero">
        <div class="hero_text">
            <h1>Your healing journey starts with us</h1>
            <h2>Hoto Loto provides affordable health care with world-class exellency!</h2>
            <div class="hero_btns">
                <button class="btn_hero_secondary">Learn more</button>
                <button class="btn_hero_main">Book appointment</button>
            </div>
        </div>
        <div class="svg_img_wrapper">
            <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                <path fill="#FF0066" d="M54,-35C65,-12,65.7,13.1,54.9,34.8C44.2,56.5,22.1,74.7,-0.4,74.9C-22.9,75.1,-45.7,57.4,-55.5,36.3C-65.2,15.2,-61.8,-9.3,-50.3,-32.4C-38.9,-55.6,-19.5,-77.5,1,-78.1C21.5,-78.6,42.9,-57.9,54,-35Z" transform="translate(100 100)" />
            </svg>
            <!-- <div class="main_img_wrapper">
                <img src="./images/hero_main.png" />
            </div> -->
        </div>
    </section>
    <section>
        <div class="service_wrapper">
            <div class="services_text">
                <h3>We provide great services</h3>
                <h4>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Minus, harum officiis.
                </h4>
            </div>
            <div class="service">
                <p class="service_main_text">Medical</h3>
                <div>
                    <p>
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                        Id, accusamus molestiae. Nesciunt labore sint aut blanditiis,
                        fugit facilis in? Nulla cum odio enim tempore,
                        cumque consequatur porro minima nobis inventore.
                    </p>
                </div>
            </div>
            <div class="service">
                <p class="service_main_text">Psychological</h3>
                <div>
                    <p>
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                        Id, accusamus molestiae. Nesciunt labore sint aut blanditiis,
                        fugit facilis in? Nulla cum odio enim tempore,
                        cumque consequatur porro minima nobis inventore.
                    </p>
                </div>
            </div>
            <div class="service">
                <p class="service_main_text">Holistic</h3>
                <div>
                    <p>
                        Lorem, ipsum dolor sit amet consectetur adipisicing elit.
                        Id, accusamus molestiae. Nesciunt labore sint aut blanditiis,
                        fugit facilis in? Nulla cum odio enim tempore,
                        cumque consequatur porro minima nobis inventore.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="doctors_wrapper">
            <div class="doctors_img_wrapper">
                <div class="img_wrapper">
                    <img src="https://as1.ftcdn.net/v2/jpg/04/05/55/68/1000_F_405556861_Ku3M8Bu5mRvoaDtW2s7V3pr6BzFEHDjR.jpg" class="circle" alt="doctors_team" />
                </div>
            </div>
            <div class="quality_doctors_wrapper">
                <p class="quality_doctors_main_text">Qualifed doctors</p>
                <p class="quality_doctors_text">
                    We have highly experienced staff with proven skills in multiple fields
                </p>
                <div class="doctors_text_wrapper">
                    <ul>
                        <li>
                            #1 medical provider in south america.
                        </li>
                        <li>
                            #1 portable medical services in Brazil.
                        </li>
                        <li>
                            #1 positive facaility
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section>

        <div class="appoint_section_wrapper">
            <div class="appoint_wrapper">
                <p>Start your journey!</p>
                <button class="appoint_btn"> <a href="./appointments.php">Book an appointment</a></button>
            </div>
        </div>

    </section>

    <?php include_once("./includes/footer.php") ?>

</body>

</html>