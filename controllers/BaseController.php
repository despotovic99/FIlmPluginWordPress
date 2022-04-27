<?php
require_once 'SettingsPageController.php';
require_once plugin_dir_path(__FILE__).'../ViewModel/Settings/FilmUzrastOption.php';

class BaseController {

    public function index($controllerName) {

        $controller = null;
        switch ($controllerName) {

            case FilmUzrastOption::CONTROLER_NAME:
                $controller = new SettingsPageController();
                break;

            default:
                break;
        }

        if ($controller !== null) {
            $action = $_REQUEST['action'] ? :'';
            $controller->handleAction($action);
        }

    }

}