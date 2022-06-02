<?php

use services\MovieService;
use services\MovieCategoryDatabaseService;

require_once plugin_dir_path(__FILE__) . '../../services/MovieService.php';
require_once plugin_dir_path(__FILE__) . '../../services/MovieCategoryDatabaseService.php';

class MovieVM {

    const ID_INPUT_NAME = 'movie_id';

    public function __construct() {

        $this->movie_service = new MovieService();
    }

    public function get_movie() {

        if (!empty($_GET['movie_id'])) {
            $movie_id = esc_html($_GET['movie_id']);

            $movie = $this->movie_service->find_movie_by_id($movie_id);

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
            'movie_category_name' => '',
            'movie_category_slug' => '',
            'movie_category_id' => '',
        ];
    }

    public function get_movie_categories() {
        $categories = $this->movie_service->find_all_categories();

        return $categories;
    }


}