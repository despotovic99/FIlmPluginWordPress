<?php
require_once 'interface/ControllerInterface.php';

class FilmController implements ControllerInterface {

    public function render() {

        wp_enqueue_style(
            'film-page',
            plugin_dir_url(__FILE__) . '../resources/css/film-page.css'
        );

        include_once plugin_dir_path(__FILE__) . '../resources/views/film-page.php';
    }

    public function handleAction($action) {



    }
}