<?php
require_once plugin_dir_path(__FILE__) . 'interface/ControllerInterface.php';

class SettingsPageController implements ControllerInterface {


    public function handle_action($action) {

        switch ($action) {

            case 'save_age_option':
                $this->save_age_option();
                break;

            default:
                break;
        }
    }

    public function save_age_option() {

        if (isset($_POST['horror_movie_min_age_option'])) {

            $age = esc_html($_POST['horror_movie_min_age_option']);
            update_option('horror_movie_min_age_option', $age);
        }

    }
}