<?php
require_once 'interface/ControllerInterface.php';
require_once plugin_dir_path(__FILE__) . '../ViewModel/NoviFilm/FilmVM.php';
require_once plugin_dir_path(__FILE__) . '../ViewModel/Settings/FilmUzrastOptionVM.php';

class FilmController implements ControllerInterface {


    public static function getFilm() {

        if (isset($_GET[FilmVM::ID_FILMA_INPUT])) {
            $id_filma = esc_html($_GET[FilmVM::ID_FILMA_INPUT]);
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


    public function handleAction($action) {

        switch ($action) {
            case FilmVM::SAVE_ACTION:
                $this->sacuvajFilm();
                break;

            case FilmVM::DELETE_ACTION:
                $this->deleteFilm();
                break;
        }

    }

    private function sacuvajFilm() {

        $film = $this->validateFilm();
        if (!$film) {

            return;
        }

        if (isset($_POST[FilmVM::ID_FILMA_INPUT]) &&
            !empty($_POST[FilmVM::ID_FILMA_INPUT]) &&
            $_POST[FilmVM::ID_FILMA_INPUT] !== '') {

            $id = esc_html($_POST[FilmVM::ID_FILMA_INPUT]);

            BaseRepository::getBaseRepository()->getFilmRepository()->updateFilm($id, $film);
            $_GET['page']='filmpage';
            return;
        }

        $result = BaseRepository::getBaseRepository()->getFilmRepository()->saveNewFilm($film);

        if ($result) {
            $_GET[FilmVM::ID_FILMA_INPUT] = $result;
        }

    }

    private function validateFilm() {

        if (!isset($_POST[FilmVM::NAZIV_FILMA_INPUT]) ||
            empty($_POST[FilmVM::NAZIV_FILMA_INPUT]) ||
            $_POST[FilmVM::NAZIV_FILMA_INPUT] == '') {

            return false;
        }

        if (!isset($_POST[FilmVM::OPIS_FILMA_INPUT]) ||
            empty($_POST[FilmVM::OPIS_FILMA_INPUT]) ||
            $_POST[FilmVM::OPIS_FILMA_INPUT] == '') {

            return false;
        }

        if (!isset($_POST[FilmVM::DATUM_FILMA_INPUT]) ||
            empty($_POST[FilmVM::DATUM_FILMA_INPUT]) ||
            $_POST[FilmVM::DATUM_FILMA_INPUT] == '') {

            return false;
        }

        if (!isset($_POST[FilmVM::DUZINA_FILMA_INPUT]) ||
            empty($_POST[FilmVM::DUZINA_FILMA_INPUT]) ||
            $_POST[FilmVM::DUZINA_FILMA_INPUT] == '') {

            return false;
        }

        if (!isset($_POST[FilmVM::UZRAST_FILM_INPUT]) ||
            empty($_POST[FilmVM::UZRAST_FILM_INPUT]) ||
            $_POST[FilmVM::UZRAST_FILM_INPUT] == '') {

            return false;
        }

        if (!isset($_POST[FilmVM::ZANR_FILMA_INPUT]) ||
            empty($_POST[FilmVM::ZANR_FILMA_INPUT]) ||
            $_POST[FilmVM::ZANR_FILMA_INPUT] == '') {

            return false;
        }

        $zanr_id = esc_html($_POST[FilmVM::ZANR_FILMA_INPUT]);

        $zanr = BaseRepository::getBaseRepository()->getZanrRepository()->daLiPostojiZanrId($zanr_id);

        if (!$zanr) {

            return false;
        }

        $uzrast = esc_html($_POST[FilmVM::UZRAST_FILM_INPUT]);
        $predvidjeniUzrast = get_option(FilmUzrastOptionVM::UZRAST_OPTION_NAME);
        if ($zanr['slug'] === 'horor' && $uzrast < $predvidjeniUzrast) {
            $uzrast = $predvidjeniUzrast;
        }

        return [
            'naziv_filma' => esc_html($_POST[FilmVM::NAZIV_FILMA_INPUT]),
            'opis' => esc_html($_POST[FilmVM::OPIS_FILMA_INPUT]),
            'pocetak_prikazivanja' => esc_html($_POST[FilmVM::DATUM_FILMA_INPUT]),
            'duzina_trajanja' => esc_html($_POST[FilmVM::DUZINA_FILMA_INPUT]),
            'uzrast' => $uzrast,
            'zanr_id' => $zanr_id,
        ];

    }

    private function deleteFilm() {

        if (!isset($_POST[FilmVM::ID_FILMA_INPUT]) ||
            empty($_POST[FilmVM::ID_FILMA_INPUT]) ||
            esc_html($_POST[FilmVM::ID_FILMA_INPUT]) == '') {

            return;
        }

        $id = $_POST[FilmVM::ID_FILMA_INPUT];

        $result = BaseRepository::getBaseRepository()->getFilmRepository()->deleteFilm($id);


    }

}