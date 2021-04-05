<?php

namespace app\controllers;

use app\core\Application;
use app\core\BaseController;
use app\core\Request;
use app\models\Provider;
use app\models\User;

class EmailsController extends BaseController
{
    public function getEmails(){
        $users = new User();
        $this->render("emailsList",["users"=>$users->getAll()]);
    }

    public function addEmails(Request $request){

        try{
            $user = new User();
            $body=$request->getBody();
            $user->loadModel($body);
            if($user->isValidEmail()){
                $provider = new Provider();
                $provider->setProviderName($user->email);
                $providerInsertedId=0;
                if(!$provider->exists()){
                    $providerInsertedId = $provider->save();
                }else{
                    $providerInsertedId = (int) $provider->getId();
                }
                $user->providerId=$providerInsertedId;
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
            return json_encode(["value"=>$e->getMessage()]);
        }
    }

    public function deleteEmails(Request $request){
        $ids = array_keys($request->getBody());
        if($ids){
            $user = new User();
            $user->delete($ids);
        }
        header('Location: ' . "/get-emails");
        exit();
    }
}