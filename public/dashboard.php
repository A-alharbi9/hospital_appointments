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


    <h1>Dashboard</h1>

    <div class="dashboard_wrapper">
        <?php

        if (isset($_SESSION['fullName'])) {
        ?>
            <h2><?= $_SESSION['table'] === 'doctorData' ? "Welcome Dr. $_SESSION[fullName]" : "Welcome, $_SESSION[fullName]" ?> </h2>

            <?php

            if ($_SESSION['table'] === 'doctorData') {

            ?>
                <?php

                $user = new Db();

                $checkDepartment = $user->createConnection()->query("SELECT * FROM doctorData where id=$_SESSION[id] AND department_Id < 1", PDO::FETCH_ASSOC);


                if ($checkDepartment->rowCount() > 0) {

                ?>

                    <form method='post'>

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

                        <button type='submit' name='addDeptBtn' class='addDeptBtn'>Add</button>

                    </form>

                <?php
                } else {
                ?>
                    <div class="doctor_dashboard_wrapper">

                        <div class="patients_app_wrapper">
                            <div class="patients_number_wrapper">
                                <?php
                                $fetchAppointments = new Db();

                                $data = $fetchAppointments->createConnection()->query("SELECT * FROM appointments WHERE DATE(appointmentDate) <= DATE(UTC_TIMESTAMP() + INTERVAL 1 WEEK)", PDO::FETCH_ASSOC);

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

                            $patientData = $fetchAppointments->createConnection()->query("SELECT * FROM appointments", PDO::FETCH_ASSOC);

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

<h3>Have a nice day!</h3>
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