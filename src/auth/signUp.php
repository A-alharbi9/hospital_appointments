<?php

if (!isset($_SESSION)) {

    session_start();
}


if (isset($_POST['signupBtn'])) {
    $fullName = trim($_POST['fullName']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);
    $role = trim($_POST['role']);

    require_once "../../src/config/Db.php";
    require_once "../../src/auth/signup.class.php";

    $db = new Db();

    $db->createConnection();

    $isPatient = $role === "patient";

    $currentTable = $isPatient ? "patientData" : "doctorData";

    if (!$db->doesExistInDb($email, $currentTable)) {
        $user = new userSignup($fullName, $email, $password, $confirmPassword);

        $user->signupUser($currentTable);
    } else {
        header('location:../../public/signin.php');
    }
}
