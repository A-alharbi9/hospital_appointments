<?php

require_once "../src/config/functions.global.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/PHP_projects/Hospital_appointments/src/config/Db.php";

require_once $_SERVER['DOCUMENT_ROOT'] . "/PHP_projects/Hospital_appointments/src/patient/addAppointment.php";


if (!isset($_SESSION)) {
    session_start();
}

if (isset($_POST['addDeptBtn'])) {
    try {

        $inputDepartment = $_POST['department'];

        $user = new Db();

        $addRowKey = $user->createConnection()->prepare("ALTER TABLE doctordata ADD FOREIGN KEY(department_id) REFERENCES departments(id) ON UPDATE CASCADE");

        $addUserDepartment = $user->createConnection()->prepare("UPDATE doctorData SET department_id=:department_id WHERE id=:id");

        $addUserDepartment->execute([
            'id' => $_SESSION['id'],
            'department_id' => $inputDepartment
        ]);
    } catch (PDOException $error) {

        die("Could not add user department: " . $error->getMessage());
        echo "<script>alert('Invalid date!\\nThe current UTC date up to six months is the only valid date.')</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php pageTitle('dashboard') ?></title>
    <link rel="stylesheet" href="./styles/dashboard.css" />
</head>

<body>

    <?php include_once("./includes/nav.php") ?>


    <div>
        <?php

        if (isset($_SESSION['fullName'])) {
        ?>

            <?php

            $db = new Db();

            if ($_SESSION['table'] === 'doctorData') {

            ?>
                <?php


                $checkDepartment = $db->createConnection()->query("SELECT * FROM doctorData where id=$_SESSION[id] AND department_Id < 1", PDO::FETCH_ASSOC);


                if ($checkDepartment->rowCount() > 0) {

                ?>
                    <div class="section_wrapper">
                        <div class="form_wrapper">

                            <div class="form_img_wrapper">
                                <img src="./images/department_image.jpg" alt="department_image" />
                            </div>

                            <div class="form_selection_wrapper">
                                <form method='post'>
                                    <div class="form_element element_department">
                                        <label for='department'> Choose your department: </label>
                                        <select name='department' required>
                                            <option value=''></option>

                                            <?php


                                            if (file_exists(dirname(__File__) . "../../src/cache/dashboard.txt")) {

                                                $file = unserialize(file_get_contents(dirname(__File__) . "../../src/cache/dashboard.txt"));

                                                for ($i = 0; $i < count($file); $i++) {

                                                    echo  "<option value=" . $file[$i]['department']['id'] . ">" . (string) $file[$i]['department']['name'] . "</option>";
                                                }
                                            } else {



                                                $data = $db->createConnection()->query("SELECT * FROM departments", PDO::FETCH_ASSOC);

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
                                    </div>

                                    <div class="form_button_wrapper">
                                        <button type='submit' name='addDeptBtn' class='addDeptBtn'>Add</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>

                <?php
                } else {
                ?>
                    <div class="doctor_dashboard_wrapper">

                        <div class="patients_app_wrapper">
                            <div class="patients_number_wrapper">
                                <?php


                                $data = $db->createConnection()->query("SELECT * FROM appointments WHERE DATE(appointmentDate) >= DATE(UTC_TIMESTAMP() + INTERVAL 1 WEEK)", PDO::FETCH_ASSOC);

                                if ($data->rowCount() > 0) {

                                    echo "<span class='patients_number'>" . $data->rowCount() . "</span>";
                                } else {
                                    echo "<span class='patients_number'>0</span>";
                                }
                                ?>
                                <p>patient(s) this week</p>
                            </div>

                            <div class="next_app_wrapper">
                                <p class='next_app_main'>Upcoming appointment</p>
                                <?php

                                $appRow = $data->fetch(PDO::FETCH_ASSOC);


                                if ($data->rowCount() > 0) {

                                    echo  "<p class='next_app_date'>" . $appRow['appointmentDate'] . "</p>";
                                } else {

                                    echo "<p class='next_app_date_clear'>No appointments</p>";
                                }


                                ?>
                            </div>
                        </div>
                    </div>

                    <div class="search_app_wrapper">
                        <input type="text" name="appSearchInput" class="appSearchInput" placeholder="search appointments" onkeyup="filterAppointments()">
                        <div class="app_table_wrapper">
                            <?php

                            $patientData = $db->createConnection()->query("SELECT * FROM appointments", PDO::FETCH_ASSOC);

                            if ($patientData->rowCount() > 0) {

                            ?>
                                <table>
                                    <thead>
                                        <tr>
                                            <td>
                                                Patient id
                                            </td>
                                            <td>
                                                App. date
                                            </td>
                                            <td>
                                                Department
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php foreach ($patientData as $row) { ?>

                                            <tr class="table_data_row">
                                                <td><?php echo $row['patient_id']; ?>
                                                </td>
                                                <td><?php echo $row['appointmentDate']; ?>
                                                </td>
                                                <td><?php echo $row['department_id']; ?>
                                                </td>
                                            </tr>

                                        <?php } ?>

                                    </tbody>
                                </table>
                            <?php
                            } else {
                            ?>
                                <h1>No appointments</h1>
                            <?php
                            }
                            ?>
                        </div>
                    </div>

                    <!-- <div class="toggle_wrapper">
                        <div class="toggle_btn_wrapper">
                            <button class="toggle_a">A</button>
                            
                            <button class="toggle_b">B</button>
                        </div> -->
    </div>

<?php
                }
            } else {
?>
<div class="patient_dashboard_wrapper">
    <div class="prevApp_wrapper">
        <div class="app_table_wrapper patTable">
            <p>Your previous appointments</p>

            <?php

                $patientData = $db->createConnection()->prepare("SELECT * FROM appointments INNER JOIN departments ON appointments.department_id = departments.id WHERE appointments.patient_id = :id AND Date(appointments.appointmentDate) <= UTC_TIMESTAMP()");

                $patientData->execute([
                    'id' => $_SESSION['id']
                ]);



                if ($patientData->rowCount() > 0) {

            ?>
                <table>
                    <thead>
                        <tr>
                            <td>
                                Appointment date
                            </td>
                            <td>
                                Department
                            </td>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($patientData as $row) { ?>

                            <tr class="table_data_row">
                                <td><?php echo $row['appointmentDate']; ?>
                                </td>
                                <td><?php echo $row['departmentName']; ?>
                                </td>
                            </tr>

                        <?php } ?>

                    </tbody>
                </table>
            <?php } else { ?>
                <div class="noApp_wrapper">
                    <p>No previous appointments!</p>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="upcApp_wrapper">
        <div class="app_table_wrapper patTable">
            <p>Your upcoming appointments</p>


            <?php

                $patientData = $db->createConnection()->prepare("SELECT * FROM appointments INNER JOIN departments ON appointments.department_id = departments.id WHERE appointments.patient_id = :id AND Date(appointments.appointmentDate) >= UTC_TIMESTAMP()");

                $patientData->execute([
                    'id' => $_SESSION['id']
                ]);

                if ($patientData->rowCount() > 0) {

            ?>
                <table>
                    <thead>
                        <tr>
                            <td>
                                Appointment date
                            </td>
                            <td>
                                Department
                            </td>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($patientData as $row) { ?>

                            <tr class="table_data_row">
                                <td><?php echo $row['appointmentDate']; ?>
                                </td>
                                <td><?php echo $row['departmentName']; ?>
                                </td>
                            </tr>

                        <?php } ?>

                    </tbody>
                </table>
            <?php } else { ?>
                <div class="noApp_wrapper">
                    <p>No upcoming appointments!</p>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php
            }
        } else {
            echo "<h1>Sign in to view this page!</h1>";
        }
?>
</div>

<?php include_once("./includes/footer.php") ?>
</div>
<script>
    function filterAppointments() {
        const inputTxt = document.querySelector('.appSearchInput').value.toUpperCase();

        const allRows = document.querySelectorAll('.table_data_row');

        for (let index = 0; index < allRows.length; index++) {


            if (allRows[index].innerText.toUpperCase().includes(inputTxt)) {

                allRows[index].style.display = 'table-row';

            } else {

                allRows[index].style.display = 'none';
            }
        }
    }
</script>
</body>

</html>