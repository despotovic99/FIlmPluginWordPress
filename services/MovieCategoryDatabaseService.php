<?php

namespace services;
use BaseRepository;

class MovieCategoryDatabaseService {

    public function findAll() {

        $result = BaseRepository::getBaseRepository()->getZanrRepository()->getZanroviFromTable();
        return $result;
    }

}