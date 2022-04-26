<?php

class BaseRepository {

    const NAZIV_FILM_TABELE='filmplugin_filmovi';
    const NAZIV_ZANR_TABELE='filmplugin_zanrovi';

    private $db;


    private $zanrRepository;
    private $filmRepository;

    /**
     * @param string $tableFilm
     * @param string $tableZanr
     */
    public function __construct() {
        global $wpdb;
        $this->db=$wpdb;
    }


    public function initializeFilmPluginTables(){

        $this->zanrRepository = new FilmPluginZanrRepo();
        $this->zanrRepository->checkDatabaseAndRunMigrations();

        $this->filmRepository= new FilmPluginFilmRepo();
        $this->filmRepository->checkFilmTableAndRunMigrations();

    }

    /**
     * @return mixed
     */
    public function getZanrRepository() {
        return $this->zanrRepository;
    }

    /**
     * @return mixed
     */
    public function getFilmRepository() {
        return $this->filmRepository;
    }




}