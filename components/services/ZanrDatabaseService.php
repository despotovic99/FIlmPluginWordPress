<?php

class ZanrDatabaseService {

    public function findAll() {

        $result = BaseRepository::getBaseRepository()->getZanrRepository()->getZanroviFromTable();
        return $result;
    }

}