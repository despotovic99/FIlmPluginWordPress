<?php

namespace services;
use BaseRepository;
use MovieVM;

class MovieService {

    public function findMovieByID($id) {

        $result = BaseRepository::getBaseRepository()->getFilmRepository()->getFilmById($id);

        return $result;
    }

    public function findFilmByName($name) {

        $result = BaseRepository::getBaseRepository()->getFilmRepository()->getFilmByName($name);

        return $result;
    }

    public function deleteMovie($id) {

        $result = BaseRepository::getBaseRepository()->getFilmRepository()->deleteFilm($id);
    }

    public function updateMovie($id) {

        $movie = $this->validateMovie();

        if (!$movie) {
            return;
        }

        $result = BaseRepository::getBaseRepository()->getFilmRepository()->updateFilm($id, $movie);

        return $result;
    }

    public function saveMovie() {

        $movie = $this->validateMovie();

        if (!$movie) {
            return;
        }

        $result = BaseRepository::getBaseRepository()->getFilmRepository()->saveNewFilm($movie);

        return $result;
    }

    private function validateMovie() {


        if (empty($_POST[MovieVM::NAZIV_FILMA_INPUT_NAME])) {
        // ovo ne sme da bude u servisu menjaj !

            return false;
        }

        if (empty($_POST[MovieVM::OPIS_FILMA_INPUT_NAME])) {

            return false;
        }

        if (empty($_POST[MovieVM::DATUM_FILMA_INPUT_NAME])) {

            return false;
        }

        if (empty($_POST[MovieVM::DUZINA_FILMA_INPUT_NAME])) {

            return false;
        }

        if (empty($_POST[MovieVM::UZRAST_FILM_INPUT_NAME])) {

            return false;
        }

        if (empty($_POST[MovieVM::ZANR_FILMA_INPUT_NAME])) {

            return false;
        }

        $zanr_id = esc_html($_POST[MovieVM::ZANR_FILMA_INPUT_NAME]);

        $zanr = BaseRepository::getBaseRepository()->getZanrRepository()->daLiPostojiZanrId($zanr_id);

        if (!$zanr) {

            return false;
        }

        $uzrast = esc_html($_POST[MovieVM::UZRAST_FILM_INPUT_NAME]);
        $predvidjeniUzrast = get_option(FilmUzrastOptionVM::UZRAST_OPTION_NAME);
        if ($zanr['slug'] === 'horor' && $uzrast < $predvidjeniUzrast) {
            $uzrast = $predvidjeniUzrast;
        }

        return [
            'naziv_filma' => esc_html($_POST[MovieVM::NAZIV_FILMA_INPUT_NAME]),
            'opis' => esc_html($_POST[MovieVM::OPIS_FILMA_INPUT_NAME]),
            'pocetak_prikazivanja' => esc_html($_POST[MovieVM::DATUM_FILMA_INPUT_NAME]),
            'duzina_trajanja' => esc_html($_POST[MovieVM::DUZINA_FILMA_INPUT_NAME]),
            'uzrast' => $uzrast,
            'zanr_id' => $zanr_id,
        ];

    }

}