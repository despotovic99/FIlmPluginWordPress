<?php

namespace services;
use BaseRepository;
use MovieVM;

class MovieService {

    public function findMovieByID($id) {

        $result = BaseRepository::get_base_repository()->get_movie_repository()->get_movie_by_id($id);

        return $result;
    }

    public function findFilmByName($name) {

        $result = BaseRepository::get_base_repository()->get_movie_repository()->get_movie_by_name($name);

        return $result;
    }

    public function deleteMovie($id) {

        $result = BaseRepository::get_base_repository()->get_movie_repository()->delete_movie($id);
    }

    public function updateMovie($id,$movie) {


        if (!$movie) {
            return;
        }

        $result = BaseRepository::get_base_repository()->get_movie_repository()->update_movie($id, $movie);

        return $result;
    }

    public function saveMovie($movie) {


        $result = BaseRepository::get_base_repository()->get_movie_repository()->save_new_movie($movie);

        return $result;
    }



}