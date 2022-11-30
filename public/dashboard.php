<?php

require_once "../src/config/functions.global.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/PHP_projects/Hospital_appointments/src/config/Db.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/PHP_projects/Hospital_appointments/src/patient/addAppointment.php";


if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST['addAppointBtn'])) {

    date_default_timezone_set("UTC");

    $inputDate = $_POST['inputDate'];
    $inputHour = $_POST['inputHour'];
    $inputMinute = $_POST['inputMinute'];

    $department = $_POST['departmentName'];

    $patient = new Patient();

    $patient->addAppointment($department, $inputDate, $inputHour, $inputMinute);
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
    ?>

        <h1><?= "Welcome, $_SESSION[fullName]" ?> </h1>
        <form method='post'>

            <label for='departmentName'> department: </label>
            <select name='departmentName' required>
                <option value=''></option>

                <?php

                $fetchData = new Db();

                $data = $fetchData->createConnection()->query("SELECT * FROM departments", PDO::FETCH_ASSOC);

                if ($data->rowCount() > 0) {

                    foreach ($data as $row) {

                        echo  "<option value=$row[departmentName]>$row[departmentName]</option>";
                    }
                }

                ?>
            </select>

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

</body>

</html>