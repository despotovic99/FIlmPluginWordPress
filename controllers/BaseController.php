<?php
require_once 'SettingsPageController.php';
require_once 'MovieController.php';

class BaseController {

    public function index($controller_name) {

        $controller = null;
        switch ($controller_name) {

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
            $controller->handle_action($action);
        }

    }

}