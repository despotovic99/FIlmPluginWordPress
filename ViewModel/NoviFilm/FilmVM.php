<?php
require_once plugin_dir_path(__FILE__) . '../../components/services/FilmService.php';
require_once plugin_dir_path(__FILE__) . '../../components/services/ZanrDatabaseService.php';

class FilmVM {

    const ID_INPUT_NAME = 'film_id';
    const NAZIV_FILMA_INPUT_NAME = 'naziv_filma';
    const OPIS_FILMA_INPUT_NAME = 'opis_filma';
    const DATUM_FILMA_INPUT_NAME = 'datum_prikazivanja_filma';
    const DUZINA_FILMA_INPUT_NAME = 'duzina_filma';
    const UZRAST_FILM_INPUT_NAME = 'uzrast_film';
    const ZANR_FILMA_INPUT_NAME = 'zanr_filma';

    const PRINTER_NAME = 'printers';


    const CONTROLER_NAME = 'film-controller';
    const SAVE_ACTION = 'sacuvaj-film';
    const DELETE_ACTION = 'obrisi-film';
    const PRINT_ACTION = 'stampaj-film';

    public function __construct() {

        $this->filmDBService = new FilmService();
        $this->zanrDBService = new ZanrDatabaseService();
    }

    public function getFilm() {

        if (!empty($_GET[FilmVM::ID_INPUT_NAME])) {
            $id_filma = esc_html($_GET[FilmVM::ID_INPUT_NAME]);

            $film = $this->filmDBService->findFilmByID($id_filma);

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
        $zanrovi = $this->zanrDBService->findAll();

        return $zanrovi;
    }


}