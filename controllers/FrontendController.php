<?php

class FrontendController {

    public function render() {

        switch ($_REQUEST['page']) {

            case 'filmplugin':

                include_once plugin_dir_path(__FILE__) . '../resources/views/film-svi-filmovi-page.php';
                break;

            case 'filmpluginsettings':

                include_once plugin_dir_path(__FILE__) . '../resources/views/film-settings-page.php';
                break;

            case 'filmpage':

                wp_enqueue_style(
                    'film-page',
                    plugin_dir_url(__FILE__) . '../resources/css/film-page.css'
                );

                include_once plugin_dir_path(__FILE__) . '../resources/views/film-page.php';
                break;
        }

    }

}