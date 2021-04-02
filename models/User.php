<?php

namespace app\models;

use app\core\DbModel;

class User extends DbModel
{

    public string $email;

    public function tableName(): string
    {
        return 'users';
    }

    public function attributes(): array
    {
        return ['email'];
    }

    public function dontSave(): array
    {
        return [];
    }

}