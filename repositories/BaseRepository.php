<?php
require_once 'FilmRepository.php';
require_once 'ZanrRepository.php';
class BaseRepository {

    const NAZIV_FILM_TABELE='filmplugin_filmovi';
    const NAZIV_ZANR_TABELE='filmplugin_zanrovi';

    private $db;

    private static $baseRepository;
    private  $zanrRepository;
    private $filmRepository;

    /**
     * @param string $tableFilm
     * @param string $tableZanr
     */
    private function __construct() {
        global $wpdb;
        $this->db=$wpdb;
    }

    public static function getBaseRepository(){
        if(self::$baseRepository==null){
            self::$baseRepository = new BaseRepository();
        }
        return self::$baseRepository;
    }

    public function initializeFilmPluginTables(){

        $this->zanrRepository = new ZanrRepository();
        $this->zanrRepository->checkDatabaseAndRunMigrations();

        $this->filmRepository= new FilmRepository();
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