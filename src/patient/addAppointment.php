<?php
require_once $_SERVER['DOCUMENT_ROOT'] . "/PHP_projects/Hospital_appointments/src/config/Db.php";

class Patient extends Db
{


    public function addAppointment($inputDepartment, $inputDate, $inputHour, $inputMinute)
    {


        $minDate = date("Y-m-d");
        $maxDate = date("Y-m-d", mktime(0, 0, 0, date("m") + 6, date("d"), date("y")));


        $inputHour = $inputHour > 9 ? $inputHour : "0" . $inputHour;
        $inputMinute = (string) strlen($inputMinute) > 1 ? $inputMinute : "0" . $inputMinute;

        $formattedInput = (string) "$inputDate $inputHour:$inputMinute";

        $currentTime = new DateTime();

        $currentTime->createFromFormat("Y-m-d H:i:s", $formattedInput);
        $currentTimeDate = (array) $currentTime;

        $id = $_SESSION['id'];

        if ($inputDate >= $minDate && $inputDate <= $maxDate) {
            try {

                if ($formattedInput < $currentTimeDate['date']) {

                    echo "<script>alert('Invalid time!\\nInput time must be bigger than current UTC time.')</script>";
                } else {


                    $this->createConnection()->exec("CREATE TABLE IF NOT EXISTS departments(
                    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    departmentName VARCHAR(50) NOT NULL,
                    dateCreated DATETIME NOT NULL DEFAULT UTC_TIMESTAMP()
                )");

                    $checkDepartments = $this->createConnection()->prepare("SELECT * FROM departments WHERE departmentName =:departmentName");

                    $addDepartments = $this->createConnection()->prepare("INSERT IGNORE INTO departments(departmentName) VALUES (:departmentName)");

                    $departments = [
                        'Cardiology',
                        'Pediatrics',
                        'ENT',
                        'Dermatology',
                        'Dentistry',
                        'Neurology',
                        'Ophthalmology'
                    ];

                    foreach ($departments as $department) {

                        $checkDepartments->execute(['departmentName' => $department]);

                        if ($checkDepartments->rowCount() < 1) {

                            $addDepartments->execute(['departmentName' => $department]);
                        }
                    }



                    $this->createConnection()->exec("CREATE TABLE IF NOT EXISTS appointments(
                    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    appointmentDate DATETIME NOT NULL,
                    department_id INT NOT NULL,
                    patient_id INT NOT NULL,
                    dateCreated DATETIME NOT NULL DEFAULT UTC_TIMESTAMP(),
                    CONSTRAINT fk_key_department FOREIGN KEY(department_id) REFERENCES departments(id) ON UPDATE CASCADE,
                    CONSTRAINT fk_key_patient FOREIGN KEY(patient_id) REFERENCES patientdata(id) ON UPDATE CASCADE
                )");

                    $fetchId = $this->createConnection()->prepare("SELECT * FROM departments WHERE departmentName =:departmentName");

                    $fetchId->execute(['departmentName' => $inputDepartment]);

                    $row = $fetchId->fetch(PDO::FETCH_ASSOC);

                    $checkAppointments = $this->createConnection()->prepare("SELECT * FROM appointments WHERE department_id=:department_id AND appointmentDate = :appointmentDate");

                    $checkAppointments->execute([
                        'department_id' => $row['id'],
                        'appointmentDate' => $formattedInput
                    ]);


                    if ($checkAppointments->rowCount() < 1) {

                        $appointment = $this->createConnection()->prepare("INSERT IGNORE INTO appointments(appointmentDate, department_id, patient_id, dateCreated) VALUES (:appointmentDate, :department_id, :patient_id, UTC_TIMESTAMP())");

                        $appointment
                            ->execute(
                                [
                                    'patient_id' => $id,
                                    'department_id' => $row['id'],
                                    'appointmentDate' => $formattedInput,
                                ]
                            );
                        echo "<script>alert('Your appointment has been added!')</script>";
                    } else {

                        echo "<script>alert('Your appointment was not added!')</script>";
                    }

                    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }
            } catch (PDOException $error) {

                die("Could not add to database: " . $error->getMessage());
            }
        } else {

            echo "<script>alert('Invalid date!\\nThe current UTC date up to six months is the only valid date.')</script>";
        }
    }
}
