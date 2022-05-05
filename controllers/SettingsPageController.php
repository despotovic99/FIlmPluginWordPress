<?php
require_once plugin_dir_path(__FILE__) . '../ViewModel/Settings/FilmUzrastOptionVM.php';
require_once plugin_dir_path(__FILE__) . 'interface/ControllerInterface.php';

class SettingsPageController implements ControllerInterface {


    public function handleAction($action) {

        switch ($action) {

            case 'save_uzrast_option':
                $this->save_uzrast_option();
                break;

            default:
                break;
        }
    }

    public function save_uzrast_option() {

        if (isset($_REQUEST[FilmUzrastOptionVM::UZRAST_OPTION_NAME])) {

            $uzrast = esc_html($_REQUEST[FilmUzrastOptionVM::UZRAST_OPTION_NAME]);
            update_option(FilmUzrastOptionVM::UZRAST_OPTION_NAME, $uzrast);
        }

    }
}