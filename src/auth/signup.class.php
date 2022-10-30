<?php

require __DIR__ . "../../../vendor/autoload.php";

class userSignup extends Db
{

    public $fullName;
    public $email;
    public $password;
    public $confirmPassword;

    public function __construct($fullName, $email, $password, $confirmPassword)
    {
        $this->fullName = $fullName;
        $this->email = $email;
        $this->password = $password;
        $this->confirmPassword = $confirmPassword;
    }
    public function signupUser($table)
    {
        try {
            $newUser = $this->createConnection()->prepare("INSERT INTO $table(fullName, email, password) VALUES (:fullName, :email , :password)");

            $hashedPassword = password_hash($this->password, PASSWORD_ARGON2I);

            $newUser->execute(['fullName' => $this->fullName, 'email' => $this->email, 'password' => $hashedPassword]);

            if ($newUser->rowCount() > 0) {

                header('location:../../public/signin.php');

                return true;
            } else {

                header('location:../../public/signup.php');

                return false;
            }
        } catch (PDOException $error) {
            echo ('Could not insert user in db: ' . $error->getMessage());
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
