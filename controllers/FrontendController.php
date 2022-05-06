<?php

class FrontendController {

    public function render() {

        switch ($_GET['page']) {

            case 'movies':

                include_once plugin_dir_path(__FILE__) . '../resources/views/film-svi-filmovi-page.php';
                break;

            case 'moviesettings':

                include_once plugin_dir_path(__FILE__) . '../resources/views/film-settings-page.php';
                break;

            case 'movie':

                wp_enqueue_style(
                    'film-page',
                    plugin_dir_url(__FILE__) . '../resources/css/film-page.css'
                );

                include_once plugin_dir_path(__FILE__) . '../resources/views/film-page.php';
                break;

            case 'movieview':

                wp_enqueue_style(
                    'film-prikaz-page',
                    plugin_dir_url(__FILE__) . '../resources/css/film-view-page.css'
                );

                include_once plugin_dir_path(__FILE__) . '../resources/views/film-prikaz-page.php';
                break;

        }

    }

}