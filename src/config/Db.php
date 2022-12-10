<?php

require_once $_SERVER['DOCUMENT_ROOT'] . "/PHP_projects/Hospital_appointments/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT'] . "/PHP_projects/Hospital_appointments");

$dotenv->safeLoad();


class Db
{
    public $pdo;


    public function createConnection()
    {
        try {

            $this->pdo = new PDO("mysql:host=" . $_ENV['DB_HOST'] . ";dbname="  . $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);

            $this->pdo->exec("CREATE TABLE IF NOT EXISTS `patientData`(
                `Id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
                `fullName` varchar(255),
                `email` varchar(255),
                `password` varchar(400)
            )");


            $this->pdo->exec("CREATE TABLE IF NOT EXISTS `doctorData`(
                `Id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
                `fullName` varchar(255),
                `email` varchar(255),
                `password` varchar(400),
                `department_id` INT NOT NULL DEFAULT 0
            )");

            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $this->pdo;
        } catch (PDOException $error) {
            echo ('Could not connect to db: ' . $error->getMessage());
            die();
        }
    }
    public function doesExistInDb($userEmail, $table)
    {
        try {

            $doesExist = $this->pdo->prepare("SELECT * FROM $table WHERE email=:email");

            $doesExist->execute(['email' => $userEmail]);

            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            if ($doesExist->rowCount() > 0) {

                return true;
            } else {

                return false;
            }
        } catch (PDOException $error) {
            echo ('Could not search in db: ' . $error->getMessage());
            die();
        }
    }
}
