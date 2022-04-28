<?php
require_once 'interface/ControllerInterface.php';
require_once plugin_dir_path(__FILE__) . '../ViewModel/NoviFilm/FilmVM.php';

class FilmController implements ControllerInterface {


    public static function getFilm() {

        if (isset($_REQUEST[FilmVM::ID_FILMA_INPUT])) {
            $id_filma = esc_html($_REQUEST[FilmVM::ID_FILMA_INPUT]);
            if (empty($id_filma) || $id_filma === '') {
                return;
            }
            $film = BaseRepository::getBaseRepository()->getFilmRepository()->getFilmById($id_filma);

            return $film;
        }

    }

    public static function getZanroviFilm() {
        $zanrovi = BaseRepository::getBaseRepository()->getZanrRepository()->getZanroviFromTable();

        return $zanrovi;
    }

    public function render() {

        wp_enqueue_style(
            'film-page',
            plugin_dir_url(__FILE__) . '../resources/css/film-page.css'
        );

        include_once plugin_dir_path(__FILE__) . '../resources/views/film-page.php';
    }

    public function handleAction($action) {

        switch ($action) {
            case FilmVM::SAVE_ACTION:
                $this->sacuvajFilm();
                break;
        }

    }

    private function sacuvajFilm() {

        $film = $this->validateFilm();
        if (!$film) {
            // prikazi gresku
            return;
        }

        if (isset($_REQUEST[FilmVM::ID_FILMA_INPUT]) &&
            !empty($_REQUEST[FilmVM::ID_FILMA_INPUT]) &&
            $_REQUEST[FilmVM::ID_FILMA_INPUT] !== '') {

            $id = esc_html($_REQUEST[FilmVM::ID_FILMA_INPUT]);
            return BaseRepository::getBaseRepository()->getFilmRepository()->updateFilm($id, $film);
        }

        $result = BaseRepository::getBaseRepository()->getFilmRepository()->saveNewFilm($film);

        if($result){
            $_REQUEST[FilmVM::ID_FILMA_INPUT]=$result;
        }

    }

    private function validateFilm() {

        if (!isset($_REQUEST[FilmVM::NAZIV_FILMA_INPUT]) ||
            empty($_REQUEST[FilmVM::NAZIV_FILMA_INPUT]) ||
            $_REQUEST[FilmVM::NAZIV_FILMA_INPUT] == '') {

            return false;
        }

        if (!isset($_REQUEST[FilmVM::OPIS_FILMA_INPUT]) ||
            empty($_REQUEST[FilmVM::OPIS_FILMA_INPUT]) ||
            $_REQUEST[FilmVM::OPIS_FILMA_INPUT] == '') {

            return false;
        }

        if (!isset($_REQUEST[FilmVM::DATUM_FILMA_INPUT]) ||
            empty($_REQUEST[FilmVM::DATUM_FILMA_INPUT]) ||
            $_REQUEST[FilmVM::DATUM_FILMA_INPUT] == '') {

            return false;
        }

        if (!isset($_REQUEST[FilmVM::DUZINA_FILMA_INPUT]) ||
            empty($_REQUEST[FilmVM::DUZINA_FILMA_INPUT]) ||
            $_REQUEST[FilmVM::DUZINA_FILMA_INPUT] == '') {

            return false;
        }

        if (!isset($_REQUEST[FilmVM::UZRAST_FILM_INPUT]) ||
            empty($_REQUEST[FilmVM::UZRAST_FILM_INPUT]) ||
            $_REQUEST[FilmVM::UZRAST_FILM_INPUT] == '') {

            return false;
        }

        if (!isset($_REQUEST[FilmVM::ZANR_FILMA_INPUT]) ||
            empty($_REQUEST[FilmVM::ZANR_FILMA_INPUT]) ||
            $_REQUEST[FilmVM::ZANR_FILMA_INPUT] == '') {

            return false;
        }


        return [
            'naziv_filma' => esc_html($_REQUEST[FilmVM::NAZIV_FILMA_INPUT]),
            'opis' => esc_html($_REQUEST[FilmVM::OPIS_FILMA_INPUT]),
            'pocetak_prikazivanja' => esc_html($_REQUEST[FilmVM::DATUM_FILMA_INPUT]),
            'duzina_trajanja' => esc_html($_REQUEST[FilmVM::DUZINA_FILMA_INPUT]),
            'uzrast' => esc_html($_REQUEST[FilmVM::UZRAST_FILM_INPUT]),
            'zanr_id' => esc_html($_REQUEST[FilmVM::ZANR_FILMA_INPUT]),
        ];

    }

}