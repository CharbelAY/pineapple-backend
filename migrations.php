<?php

use app\core\Application;

require_once __DIR__ . "/vendor/autoload.php";

$config=[
    'db'=>[
        'dsn'=>"mysql:host=database;port=3306;dbname=admin;",
        'user'=>"root",
        'password'=>"root"
    ]
];


$app = new Application(dirname(__DIR__),$config);

echo(".................................Applying migration.......................");
$app->db->applyMigration();