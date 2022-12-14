<?php

if (!isset($_SESSION)) {
    session_start();
}

require __DIR__ . "../../../vendor/autoload.php";

class userSignin extends Db
{
    public $email;
    public $password;

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }
    public function signinUser($table)
    {
        try {
            $existingUser = $this->createConnection()->prepare("SELECT * FROM $table WHERE email=:email");

            $existingUser->execute(['email' => $this->email]);

            if ($existingUser->rowCount() > 0) {
                $row = $existingUser->fetch(PDO::FETCH_ASSOC);

                if (password_verify($this->password, $row['password'])) {

                    header('location:../../public/dashboard.php');


                    $_SESSION['id'] = $row['Id'];
                    $_SESSION['fullName'] = $row['fullName'];
                    $_SESSION['table'] = $table;
                } else {

                    echo "<script>alert('Incorrect email and/or password')</script>";

                    echo "<script>location.href='../../public/signin.php'</script>";
                }
            }
        } catch (PDOException $error) {
            echo ('Could not sign in user: ' . $error->getMessage());
            die();
        }
    }
    public function isValidFullName()
    {
        if (!preg_match('/$[A-Za-z]+$/', $this->fullName)) {
            return false;
        }
        return true;
    }
    public function isValidEmail()
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        return true;
    }
    public function isValidPassword()
    {
        if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[#?!@$%^&*-]).{8,}$/', $this->fullName)) {
            return false;
        }
    }
    public function isPasswordMatch()
    {
        if ($this->password !== $this->confirmPassword) {
            return false;
        }
        return true;
    }
}
