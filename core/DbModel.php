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
        return $this->lastInsertedId();
    }

    public function searchForEmails($emailName,$provider,$sortingColumn,$sortingOrder,$column){
        $tableName = $this->tableName();
        $statement = "SELECT * FROM $tableName WHERE $column LIKE '%{$emailName}%' AND $column LIKE '%$provider%'";
        if($sortingColumn){
            $statement .= "ORDER BY $sortingColumn $sortingOrder";
        }
        $statement = self::prepare($statement);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getId(){
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $dontSave = $this->dontSave();
        $attributes = array_diff($attributes, $dontSave);
        $statement = "SELECT id FROM $tableName WHERE (";
        foreach ($attributes as $attribute){
            $statement .= "$attribute = :$attribute";
        }
        $statement.=")";
        $statement = self::prepare($statement);
        foreach ($attributes as $attribute){
            $statement->bindValue(":$attribute",$this->{$attribute});
        }
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC)["id"];
    }

    public function exists(){
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $dontSave = $this->dontSave();
        $attributes = array_diff($attributes, $dontSave);
        $statement = "SELECT 1 FROM $tableName WHERE (";
        foreach ($attributes as $attribute){
            $statement .= "$attribute = :$attribute and ";
        }
        $statement= substr($statement,0,-4);
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

    public function getAllWithIds(array $ids){
        $tableName = $this->tableName();
        $ids = join("','",array_keys($ids));
        $statement = "SELECT * FROM $tableName WHERE id IN ('$ids')";
        $statement = self::prepare($statement);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getFirst($id){
        if($id){
            $tableName = $this->tableName();
            $statement = "SELECT * FROM $tableName WHERE id = $id";
            $statement = self::prepare($statement);
            $statement->execute();
            return $statement->fetch(PDO::FETCH_ASSOC);
        }else{
            return null;
        }
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

    private function lastInsertedId(){
        return Application::$app->db->pdo->lastInsertId();
    }
}