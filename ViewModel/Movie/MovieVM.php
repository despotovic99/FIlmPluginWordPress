<?php

use services\MovieService;
use services\MovieCategoryDatabaseService;

require_once plugin_dir_path(__FILE__) . '../../services/MovieService.php';
require_once plugin_dir_path(__FILE__) . '../../services/MovieCategoryDatabaseService.php';

class MovieVM {

    const ID_INPUT_NAME = 'movie_id';
    const NAZIV_FILMA_INPUT_NAME = 'movie_name';
    const OPIS_FILMA_INPUT_NAME = 'movie_description';
    const DATUM_FILMA_INPUT_NAME = 'movie_date';
    const DUZINA_FILMA_INPUT_NAME = 'movie_length';
    const UZRAST_FILM_INPUT_NAME = 'movie_age';
    const ZANR_FILMA_INPUT_NAME = 'movie_category';



    const CONTROLER_NAME = 'movie_controller';
    const SAVE_ACTION = 'save';
    const DELETE_ACTION = 'delete';
    const PRINT_ACTION = 'print';

    public function __construct() {

        $this->movie_db_service = new MovieService();
        $this->movie_category_db_service = new MovieCategoryDatabaseService();
    }

    public function get_movie() {

        if (!empty($_GET['movie_id'])) {
            $movie_id = esc_html($_GET['movie_id']);

            $movie = $this->movie_db_service->findMovieByID($movie_id);

        }

        if (!empty($movie))
            return $movie;

        return [
            'movie_id' => '',
            'movie_name' => '',
            'movie_description' => '',
            'movie_date' => '',
            'movie_length' => '',
            'movie_age' => '',
            'movie_category_slug' => '',
            'movie_category_id' => '',
        ];
    }

    public function get_movie_categories() {
        $categories = $this->movie_category_db_service->findAll();

        return $categories;
    }


}