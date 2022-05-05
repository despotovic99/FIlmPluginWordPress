<?php
require_once 'SettingsPageController.php';
require_once 'FilmController.php';
require_once plugin_dir_path(__FILE__) . '../ViewModel/Settings/FilmUzrastOptionVM.php';
require_once plugin_dir_path(__FILE__) . '../ViewModel/FilmList/ListAllFilmsVM.php';
require_once plugin_dir_path(__FILE__) . '../ViewModel/NoviFilm/FilmVM.php';

class BaseController {

    public function index($controllerName) {

        $controller = null;
        switch ($controllerName) {

            case FilmUzrastOptionVM::CONTROLER_NAME:
                $controller = new SettingsPageController();
                break;

            case FilmVM::CONTROLER_NAME :
                $controller = new FilmController();
                break;

            default:
                return;
        }

        if ($controller !== null) {
            $action = esc_html($_REQUEST['action']) ?: '';
            $controller->handleAction($action);
        }

    }

}