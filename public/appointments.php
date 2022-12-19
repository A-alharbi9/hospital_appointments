<?php

require_once "../src/config/functions.global.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/PHP_projects/Hospital_appointments/src/config/Db.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/PHP_projects/Hospital_appointments/src/patient/addAppointment.php";


if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST['addAppointBtn'])) {

    $inputDate = $_POST['inputDate'];
    $inputHour = $_POST['inputHour'];
    $inputMinute = $_POST['inputMinute'];
    $departmentId =  $_POST['department'];

    $patient = new Patient();

    if (isset($_POST['patient'])) {

        $patientId =  $_POST['patient'];

        $patient->addAppointment($departmentId, $inputDate, $inputHour, $inputMinute, $patientId);
    } else {

        $patient->addAppointment($departmentId, $inputDate, $inputHour, $inputMinute);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php pageTitle('appointments') ?></title>
</head>

<body>

    <?php include_once("./includes/nav.php") ?>

    <h1>Appointments</h1>
    <?php


    if (isset($_SESSION['fullName'])) {
    ?>

        <h2><?= "Welcome, $_SESSION[fullName]" ?> </h2>

        <h3>Add an appointment:</h1>

            <form method='post'>

                <label for='department'> department: </label>
                <select name='department' required>
                    <option value=''></option>

                    <?php


                    if (file_exists(dirname(__File__) . "../../src/cache/dashboard.txt")) {

                        $file = unserialize(file_get_contents(dirname(__File__) . "../../src/cache/dashboard.txt"));

                        for ($i = 0; $i < count($file); $i++) {

                            echo  "<option value=" . $file[$i]['department']['id'] . ">" . (string) $file[$i]['department']['name'] . "</option>";
                        }
                    } else {

                        $fetchData = new Db();

                        $data = $fetchData->createConnection()->query("SELECT * FROM departments", PDO::FETCH_ASSOC);

                        $_SESSION["departments"] = array();

                        if ($data->rowCount() > 0) {

                            $i = 0;

                            foreach ($data as $row) {

                                if (in_array($row['departmentName'], $_SESSION['departments']) == false) {

                                    $_SESSION["departments"][$i] = [
                                        "department" => [
                                            'id' => $row['id'],
                                            'name' => $row['departmentName']
                                        ]
                                    ];

                                    $i++;
                                }

                                echo  "<option value=$row[id]>$row[departmentName]</option>";
                            }
                        }

                        file_put_contents(dirname(__File__) . "../../src/cache/dashboard.txt", serialize($_SESSION["departments"]));
                    }

                    ?>
                </select>
                <?php if ($_SESSION['table'] === 'doctorData') { ?>
                    <label for='patient'> patient: </label>
                    <select name='patient' required>
                        <option value=''></option>

                        <?php


                        if (file_exists(dirname(__File__) . "../../src/cache/appointments.txt")) {

                            $file = unserialize(file_get_contents(dirname(__File__) . "../../src/cache/appointments.txt"));

                            for ($i = 0; $i < count($file); $i++) {

                                echo  "<option value=" . $file[$i]['patient']['id'] . ">" . (string) $file[$i]['patient']['name'] . "</option>";
                            }
                        } else {

                            $fetchData = new Db();

                            $patientData = $fetchData->createConnection()->query("SELECT * FROM patientData", PDO::FETCH_ASSOC);

                            $_SESSION["patients"] = array();

                            if ($patientData->rowCount() > 0) {

                                $i = 0;

                                foreach ($patientData as $row) {

                                    if (in_array($row['fullName'], $_SESSION['patients']) == false) {

                                        $_SESSION["patients"][$i] = [
                                            "patient" => [
                                                'id' => $row['Id'],
                                                'name' => $row['fullName']
                                            ]
                                        ];

                                        $i++;
                                    }

                                    echo  "<option value=$row[Id]>$row[fullName]</option>";
                                }
                            }

                            file_put_contents(dirname(__File__) . "../../src/cache/appointments.txt", serialize($_SESSION["patients"]));
                        }
                        ?>
                    </select>
                <?php
                }
                ?>

                <label for='inputDate'> choose date: </label>
                <input type='date' name='inputDate' required />

                <label for='inputHour'> choose time: </label>
                <input type='number' name='inputHour' min='8' max='13' step='1' placeholder='H' required />
                <span>:</span>
                <input type='number' name='inputMinute' min='00' max='59' step='15' placeholder='M' required />

                <button type='submit' name='addAppointBtn' class='addAppointBtn'>Add</button>

            </form>

        <?php
    } else {
        echo "<h1>Sign in to view this page!</h1>";
    }
        ?>

        <?php include_once("./includes/footer.php") ?>
</body>

</html>