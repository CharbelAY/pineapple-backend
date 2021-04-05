<?php


namespace app\core;


use PDO;

abstract class DbModel extends Model
{

    public function save(){
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $dontSave = $this->dontSave();
        $attributes = array_diff($attributes, $dontSave);
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $statement = self::prepare("INSERT INTO $tableName (" . implode(',', $attributes) . ") VALUES (" . implode(",", $params) . ")");
        foreach ($attributes as $attribute) {
            $statement->bindValue(":$attribute", $this->{$attribute});
        }
        $statement->execute();
        return true;
    }

    public function exists(){
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $dontSave = $this->dontSave();
        $attributes = array_diff($attributes, $dontSave);
        $statement = "SELECT 1 FROM $tableName WHERE (";
        foreach ($attributes as $attribute){
            $statement .= "$attribute = :$attribute";
        }
        $statement.=")";
        $statement = self::prepare($statement);
        foreach ($attributes as $attribute){
            $statement->bindValue(":$attribute",$this->{$attribute});
        }
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll(){
        $tableName = $this->tableName();
        $statement = "SELECT * FROM $tableName";
        $statement = self::prepare($statement);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);

    }

    public function delete($ids){
        $tableName = $this->tableName();
        $params = str_repeat('?,', count($ids) - 1) . '?';
        $statement = self::prepare("DELETE FROM $tableName WHERE id IN ($params)");
        $statement->execute($ids);
    }
    public static function prepare($sql)
    {
        return Application::$app->db->pdo->prepare($sql);
    }
}