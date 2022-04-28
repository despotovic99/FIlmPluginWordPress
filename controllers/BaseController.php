<?php
require_once 'SettingsPageController.php';
require_once  'ListAllFilmsController.php';
require_once plugin_dir_path(__FILE__).'../ViewModel/Settings/FilmUzrastOptionVM.php';
require_once plugin_dir_path(__FILE__).'../ViewModel/FilmList/ListAllFilmsVM.php';

class BaseController {

    public function index($controllerName) {

        $controller = null;
        switch ($controllerName) {

            case FilmUzrastOptionVM::CONTROLER_NAME:
                $controller = new SettingsPageController();
                break;

            case ListAllFilmsVM::CONTROLER_NAME:
                $controller = new ListAllFilmsController();
                break;

            default:
                break;
        }

        if ($controller !== null) {
            $action = esc_html($_REQUEST['action']) ? :'';
            $controller->handleAction($action);
        }

    }

}