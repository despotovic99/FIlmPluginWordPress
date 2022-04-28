<?php
require_once plugin_dir_path(__FILE__) . '../../controllers/FilmController.php';

class FilmVM {

    const ID_FILMA_INPUT = 'id_filma';
    const NAZIV_FILMA_INPUT = 'naziv_filma';
    const OPIS_FILMA_INPUT = 'opis_filma';
    const DATUM_FILMA_INPUT = 'datum_prikazivanja_filma';
    const DUZINA_FILMA_INPUT = 'duzina_filma';
    const UZRAST_FILM_INPUT = 'uzrast_film';
    const ZANR_FILMA_INPUT = 'zanr_filma';

    const CONTROLER_NAME = 'film-controller';
    const SAVE_ACTION = 'sacuvaj-film';

    public static function getFilm() {
        $film = FilmController::getFilm();

        if (!empty($film))
            return $film;

        return [
            'film_id'=>'',
            'naziv_filma'=>'',
            'opis'=>'',
            'pocetak_prikazivanja'=>'',
            'duzina_trajanja'=>'',
            'uzrast'=>'',
            'slug'=>'',
        ];
    }

    public static function getZanroviFilm() {
        $zanrovi = FilmController::getZanroviFilm();
        return $zanrovi;
    }


}