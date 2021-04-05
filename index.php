<?php

require_once __DIR__ . "/vendor/autoload.php";

use app\controllers\EmailsController;
use app\core\Application;

$config = [
    'db' => [
        'dsn' => "mysql:host=database;port=3306;dbname=admin;",
        'user' => "root",
        'password' => "root"
    ]
];

$app = new Application(__DIR__,$config);

$app->router->get("/", function () {
    echo("Home screen");
});

$app->router->get("/get-emails", [EmailsController::class, "getEmails"]);

$app->router->post("/addemail",[EmailsController::class,"addEmails"]);

$app->router->post("/deleteEmails",[EmailsController::class,"deleteEmails"]);

$app->run();