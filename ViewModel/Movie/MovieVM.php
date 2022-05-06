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

    const PRINTER_NAME = 'printer';


    const CONTROLER_NAME = 'movie_controller';
    const SAVE_ACTION = 'save';
    const DELETE_ACTION = 'delete';
    const PRINT_ACTION = 'print';

    public function __construct() {

        $this->movieDBService = new MovieService();
        $this->movieCategoryDBService = new MovieCategoryDatabaseService();
    }

    public function getMovie() {

        if (!empty($_GET['movie_id'])) {
            $movie_id = esc_html($_GET['movie_id']);

            $film = $this->movieDBService->findMovieByID($movie_id);

        }

        if (!empty($film))
            return $film;

        return [
            'film_id' => '',
            'naziv_filma' => '',
            'opis' => '',
            'pocetak_prikazivanja' => '',
            'duzina_trajanja' => '',
            'uzrast' => '',
            'slug' => '',
            'id_zanra' => '',
        ];
    }

    public function getZanroviFilm() {
        $zanrovi = $this->movieCategoryDBService->findAll();

        return $zanrovi;
    }


}