<?php

namespace services;
use BaseRepository;

class MovieCategoryDatabaseService {

    public function find_all() {

        $result = BaseRepository::get_base_repository()->get_movie_category_repository()->get_movie_categories();
        return $result;
    }

}