<?php


namespace app\models;


use app\core\DbModel;

class Provider extends DbModel
{

    public string $providerName;

    public function tableName(): string
    {
        return 'provider';
    }

    public function attributes(): array
    {
        return ['providerName'];
    }

    public function dontSave(): array
    {
        return [];
    }

    public function setProviderName($email)
    {
        $this->providerName =  explode(".",explode("@",$email)[1])[0];

    }
}