<?php

class FrontendController {

    public function render() {

        switch ($_GET['page']) {

            case 'movies':

                include_once plugin_dir_path(__FILE__) . '../resources/views/all-movies-page.php';
                break;

            case 'moviesettings':

                include_once plugin_dir_path(__FILE__) . '../resources/views/movie-settings-page.php';
                break;

            case 'movie':

                wp_enqueue_style(
                    'film-page',
                    plugin_dir_url(__FILE__) . '../resources/css/film-page.css'
                );

                include_once plugin_dir_path(__FILE__) . '../resources/views/movie-page.php';
                break;

            case 'movieview':

                wp_enqueue_style(
                    'film-prikaz-page',
                    plugin_dir_url(__FILE__) . '../resources/css/film-view-page.css'
                );

                include_once plugin_dir_path(__FILE__) . '../resources/views/movie-view-page.php';
                break;

            case 'movie_settings_test':

                include_once plugin_dir_path(__FILE__) . '../resources/views/movie-test-page.php';
                break;

            case 'invoices':

                wp_enqueue_script(
                    'movie-plugin-delete-invoice-btn',
                    plugins_url('../resources/js/all-invoices-page.js', __FILE__),
                    ['jquery'],
                    '1.0.0',
                    true
                );

                include_once plugin_dir_path(__FILE__) . '../resources/views/all-invoices-page.php';
                break;
            case 'invoice':

                include_once plugin_dir_path(__FILE__) . '../resources/views/invoice-view-page.php';
                break;
        }

    }

}