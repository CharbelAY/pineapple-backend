<?php

namespace app\controllers;

use app\core\Application;
use app\core\BaseController;
use app\core\Request;
use app\models\User;

class EmailsController extends BaseController
{
    public function getEmails(){
        $this->render("emailsList",[]);
    }

    public function addEmails(Request $request){

        try{
            $user = new User();
            $body=$request->getBody();
            $user->loadModel($body);
            if($user->isValidEmail()){
                if($user->exists()){
                    return json_encode(["value"=>"this email already exists"]);
                }else{
                    $user->save();
                    return json_encode(["value"=>"Success"]);
                }
            }else{
                return json_encode(["value"=>"email is invalid"]);
            }
        }catch (\Exception $e){
            return json_encode(["value"=>$e]);
        }
    }
}