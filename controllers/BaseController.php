<?php
require_once 'SettingsPageController.php';
require_once 'MovieController.php';

class BaseController {

    public function index($controllerName) {

        $controller = null;
        switch ($controllerName) {

            case 'settings_controller':
                $controller = new SettingsPageController();
                break;

            case 'movie_controller' :
                $controller = new MovieController();
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