<?php

class m0001_initial{

    public function up(){
        $db = \app\core\Application::$app->db;

        $SQLUsers="
        CREATE TABLE users(
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL,
        providerId INT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
        )ENGINE=INNODB
        ";

        $db->pdo->exec($SQLUsers);

        $SQLProvider="
        CREATE TABLE provider(
        id INT AUTO_INCREMENT PRIMARY KEY,
        providerName VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
        )ENGINE=INNODB
        ";

        $db->pdo->exec($SQLProvider);


    }

    public function down(){
        $db = \app\core\Application::$app->db;
        $SQLUsers = "DROP TABLE users ;";
        $db->pdo->exec($SQLUsers);

        $SQLProvider = "DROP TABLE provider ;";
        $db->pdo->exec($SQLProvider);
    }

}