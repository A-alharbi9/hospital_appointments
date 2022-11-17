<?php

if (!isset($_SESSION)) {

    session_start();
}

if (isset($_POST['signinBtn'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']);

    require_once "../../src/config/Db.php";
    require_once "../../src/auth/signin.class.php";

    $db = new Db();

    $db->createConnection();

    $isPatient = $role === "patient";

    $currentTable = $isPatient ? "patientData" : "doctorData";

    if ($db->doesExistInDb($email, $currentTable)) {
        $user = new userSignin($email, $password);

        $user->signinUser($currentTable);
    } else {

        echo "<script>alert('Incorrect email and/or password')</script>";

        echo "<script>location.href='../../public/signin.php'</script>";
    }
}
