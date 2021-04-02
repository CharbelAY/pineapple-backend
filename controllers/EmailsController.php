<?php

namespace app\controllers;

use app\core\BaseController;
use app\core\Request;
use app\models\User;

class EmailsController extends BaseController
{
    public function getEmails(){
        echo "Samir";
    }

    public function addEmails(Request $request){

        try{
            $user = new User();
            $body=$request->getBody();
            $user->loadModel($body);
            $user->save();
            return json_encode(["value"=>"Success"]);
        }catch (\Exception $e){
            return json_encode($e);
            echo("need to render error");
        }
    }
}