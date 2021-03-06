<?php


namespace app\core;


abstract class Model
{

    public function loadModel($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                if ($value !== "") {
                    $this->{$key} = $value;
                }
            }
        }
    }

}