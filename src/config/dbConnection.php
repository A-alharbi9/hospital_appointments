<?php

require __DIR__ . "../../../vendor/autoload.php";


$dot = Dotenv\Dotenv::CreateImmutable('../');

$dot->safeLoad();

class Db
{
    public $pdo;

    public function createConnection()
    {
        try {

            $this->pdo = new PDO("mysql:host=" . $_ENV['DB_HOST'] . ";dbname="  . $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);

            var_dump($this->pdo);

            $this->pdo->exec("CREATE TABLE IF NOT EXISTS patientData(
                Id INT(11) Not NULL AUTO_INCREMENT PRIMARY KEY, 
                fullName varchar(255),
                email varchar(255),
                password varchar(400)
            )");


            $this->pdo->exec("CREATE TABLE IF NOT EXISTS doctorData(
                Id INT(11) Not NULL AUTO_INCREMENT PRIMARY KEY, 
                fullName varchar(255),
                email varchar(255),
                password varchar(400)
            )");

            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $error) {
            echo ('Could not connect to db: ' . $error->getMessage());
            die();
        }
    }
}
