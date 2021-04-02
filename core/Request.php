<?php

namespace app\core;


class Request
{
    public function getPath()
    {
        $path = $_SERVER["REQUEST_URI"];
        $position = strpos($path, '?');
        if ($position == false) {
            return $path;
        }
        return substr($path, 0, $position);

    }

    public function isGet()
    {
        return $this->method() === "GET";
    }

    public function method()
    {
        return $_SERVER["REQUEST_METHOD"];
    }

    public function isPost()
    {
        return $this->method() === "POST";
    }

    public function getBody()
    {
        $body = [];
        if ($this->method() === "GET") {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if ($this->method() === "POST") {
            if(!empty($_POST)){
                foreach ($_POST as $key => $value) {
                    $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }else{
                $post = json_decode(file_get_contents('php://input'), true);
                if(json_last_error() == JSON_ERROR_NONE)
                {
                    foreach ($post as $key=>$value){
                        $body[$key] = filter_var($value, FILTER_SANITIZE_STRING);
                    }
                }
            }
        }
        return $body;
    }
}