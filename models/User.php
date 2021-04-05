<?php

namespace app\models;

use app\core\DbModel;

class User extends DbModel
{

    public string $email;
    public int $providerId;

    public function tableName(): string
    {
        return 'users';
    }

    public function attributes(): array
    {
        return ['email','providerId'];
    }

    public function dontSave(): array
    {
        return [];
    }

    public function isValidEmail(){
        return $this->isNotFromColombia() && $this->validEmail();
    }

    private function isNotFromColombia(){
        return filter_var($this->email,FILTER_VALIDATE_EMAIL);
    }
    private function validEmail(){
        return preg_match("/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/",$this->email);
    }

    public function getEmailName(){
        return substr($this->email,0,strpos($this->email,'@'));
    }

}