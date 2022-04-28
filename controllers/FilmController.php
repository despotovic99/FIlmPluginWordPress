<?php
require_once 'interface/ControllerInterface.php';
require_once plugin_dir_path(__FILE__) . '../ViewModel/NoviFilm/FilmVM.php';

class FilmController implements ControllerInterface {


    public static function getFilm() {

        if (isset($_REQUEST[FilmVM::ID_FILMA_INPUT])) {
            $id_filma = esc_html($_REQUEST[FilmVM::ID_FILMA_INPUT]);
            if (empty($id_filma) || $id_filma === ''){
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

    }
}