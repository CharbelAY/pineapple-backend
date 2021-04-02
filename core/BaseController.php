<?php


namespace app\core;


class BaseController
{
    public string $layout = "baseLayout";

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function render($view, $params = [])
    {
        return Application::$app->router->render_view($view, $params);
    }
}