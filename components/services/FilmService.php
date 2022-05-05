<?php

class FilmService {

    public function findFilmByID($id) {

        $result = BaseRepository::getBaseRepository()->getFilmRepository()->getFilmById($id);

        return $result;
    }

    public function findFilmByName($name){

        $result = BaseRepository::getBaseRepository()->getFilmRepository()->getFilmByName($name);

        return $result;
    }

    public function deleteFilm($id) {

        $result = BaseRepository::getBaseRepository()->getFilmRepository()->deleteFilm($id);
    }

    public function updateFilm($id) {

        $film = $this->validateFilm();

        if (!$film) {
            return;
        }

        $result = BaseRepository::getBaseRepository()->getFilmRepository()->updateFilm($id, $film);

        return $result;
    }

    public function saveFilm() {

        $film = $this->validateFilm();

        if (!$film) {
            return;
        }

        $result = BaseRepository::getBaseRepository()->getFilmRepository()->saveNewFilm($film);

        return $result;
    }

    private function validateFilm() {


        if (empty($_POST[FilmVM::NAZIV_FILMA_INPUT_NAME])) {

            return false;
        }

        if (empty($_POST[FilmVM::OPIS_FILMA_INPUT_NAME])) {

            return false;
        }

        if (empty($_POST[FilmVM::DATUM_FILMA_INPUT_NAME])) {

            return false;
        }

        if (empty($_POST[FilmVM::DUZINA_FILMA_INPUT_NAME])) {

            return false;
        }

        if (empty($_POST[FilmVM::UZRAST_FILM_INPUT_NAME])) {

            return false;
        }

        if (empty($_POST[FilmVM::ZANR_FILMA_INPUT_NAME])) {

            return false;
        }

        $zanr_id = esc_html($_POST[FilmVM::ZANR_FILMA_INPUT_NAME]);

        $zanr = BaseRepository::getBaseRepository()->getZanrRepository()->daLiPostojiZanrId($zanr_id);

        if (!$zanr) {

            return false;
        }

        $uzrast = esc_html($_POST[FilmVM::UZRAST_FILM_INPUT_NAME]);
        $predvidjeniUzrast = get_option(FilmUzrastOptionVM::UZRAST_OPTION_NAME);
        if ($zanr['slug'] === 'horor' && $uzrast < $predvidjeniUzrast) {
            $uzrast = $predvidjeniUzrast;
        }

        return [
            'naziv_filma' => esc_html($_POST[FilmVM::NAZIV_FILMA_INPUT_NAME]),
            'opis' => esc_html($_POST[FilmVM::OPIS_FILMA_INPUT_NAME]),
            'pocetak_prikazivanja' => esc_html($_POST[FilmVM::DATUM_FILMA_INPUT_NAME]),
            'duzina_trajanja' => esc_html($_POST[FilmVM::DUZINA_FILMA_INPUT_NAME]),
            'uzrast' => $uzrast,
            'zanr_id' => $zanr_id,
        ];

    }

}