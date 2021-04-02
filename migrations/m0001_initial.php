<?php

class m0001_initial{

    public function up(){
        $db = \app\core\Application::$app->db;

        $SQLUsers="
        CREATE TABLE users(
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
        )ENGINE=INNODB
        ";

        $db->pdo->exec($SQLUsers);

    }

    public function down(){
        $db = \app\core\Application::$app->db;
        $SQLUsers = "DROP TABLE users ;";
        $db->pdo->exec($SQLUsers);
    }

}