<?php

require_once __DIR__ . "/vendor/autoload.php";

use app\controllers\EmailsController;
use app\core\Application;

function cors() {
    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: Origin, Authorization, X-Requested-With, Content-Type, Accept");

        exit(0);
    }
}

cors();

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

$app->router->get("/exportcsv", [EmailsController::class, "exportcsv"]);


$app->router->post("/addemail",[EmailsController::class,"addEmails"]);

$app->router->post("/deleteEmails",[EmailsController::class,"deleteEmails"]);

$app->run();