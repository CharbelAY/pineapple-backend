<?php

namespace app\controllers;

use app\core\Application;
use app\core\BaseController;
use app\core\Request;
use app\models\Provider;
use app\models\User;
use app\services\CsvService;

class EmailsController extends BaseController
{
    public function getEmails(){
        $filteringOptions=["Ascending","Descending"];
        $filteringColumns=["email","created_at"];
        $filteringOrder=["ASC","DESC"];
        $users = new User();
        $provider = new Provider();
        $providerName = $provider->getFirst($_GET["provider-filtering"])["providerName"];
        $searchedUsers = $users->searchForEmails($_GET["email"],$providerName,$_GET["sorting-column"],$_GET["sorting-order"],"email");
        foreach ($searchedUsers as$key=>$user){
            $searchedUsers[$key]["providerName"]=$provider->getFirst($user["providerId"])["providerName"];
        }
        $this->render("emailsList",["users"=>$searchedUsers,"filteringColumns"=>$filteringColumns,"filteringOrder"=>$filteringOrder,"providers"=>$provider->getAll(),"history"=>$_GET,"filteringOptions"=>$filteringOptions]);
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

    public function exportcsv(Request $request){
        $body = $request->getBody();
        $filename="exportedUsers.csv";
        $service = new CsvService();
        $user=new User();
        $provider=new Provider();
        $data=$user->getAllWithIds($body);
        foreach ($data as$key=>$d){
            $provName=$provider->getFirst($d["providerId"])["providerName"];
            unset($d["id"]);
            unset($d["providerId"]);
            $data[$key]=$d;
            $data[$key]["providerName"]=$provName;
        }
        $result = $service->generateCSV($filename,$data);
        if($result){
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=".$filename);
            header("Content-Type: application/csv; ");

            readfile($filename);

            unlink($filename);
        }else{
            header('Location: ' . "/get-emails");
            exit();
        }

    }
}