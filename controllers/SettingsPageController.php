<?php
require_once plugin_dir_path(__FILE__).'../ViewModel/Settings/FilmUzrastOption.php';

class SettingsPageController {


    public function handleAction($action){

        switch ($action){

            case 'save_uzrast_option':
                $this->save_uzrast_option();
                break;

            default:
                break;
        }
    }

    public function render(){
        include_once plugin_dir_path(__FILE__) . '../resources/views/film-settings-page.php';
    }

    public function save_uzrast_option(){

        if(isset($_REQUEST[FilmUzrastOption::UZRAST_OPTION_NAME])){
            $uzrast= esc_html($_REQUEST[FilmUzrastOption::UZRAST_OPTION_NAME]);
            update_option(FilmUzrastOption::UZRAST_OPTION_NAME,$uzrast);
        }

    }
}