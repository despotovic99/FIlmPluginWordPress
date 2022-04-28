<?php

class FilmPluginFilmRepo {

    public function __construct() {
        global $wpdb;
        $this->db = $wpdb;
        $this->nazivTabele = $this->db->prefix . BaseRepository::NAZIV_FILM_TABELE;
    }


    public function checkFilmTableAndRunMigrations() {

        $this->createFilmTable();
    }

    private function createFilmTable() {

        $query = 'CREATE TABLE IF NOT EXISTS ' . $this->nazivTabele
            . '  (
        id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        naziv_filma VARCHAR(255) NOT NULL,
        opis VARCHAR(255) NOT NULL,
        pocetak_prikazivanja DATE NOT NULL,
        duzina_trajanja VARCHAR(50) NOT NULL,
        uzrast INT(3) NOT NULL,
        zanr_id INT NOT NULL,
        FOREIGN KEY (zanr_id) REFERENCES  ' . $this->db->prefix . BaseRepository::NAZIV_ZANR_TABELE . ' (id) )';

        $result = $this->db->query($query);
        return $result;
    }

    public function getAllFilmData() {

    }

    public function getFilmByName($name){
        $query = "SELECT  f.`id` AS film_id , naziv_filma , uzrast,  z.naziv_zanr AS zanr, pocetak_prikazivanja, duzina_trajanja
                            FROM ".$this->nazivTabele ." f
                            INNER JOIN ".$this->db->prefix.BaseRepository::NAZIV_ZANR_TABELE." z 
                            ON f.zanr_id=z.id
                            WHERE naziv_filma LIKE '%".$name."%' ";

        $result = $this->db->get_results($query, ARRAY_A);

        return $result;
    }

    public function getFilmDatafForListTable() {

        $query = "SELECT  f.`id` AS film_id , naziv_filma , uzrast,  z.naziv_zanr AS zanr, pocetak_prikazivanja, duzina_trajanja
                            FROM ".$this->nazivTabele ." f
                            INNER JOIN ".$this->db->prefix.BaseRepository::NAZIV_ZANR_TABELE." z 
                            ON f.zanr_id=z.id";

        $result = $this->db->get_results($query, ARRAY_A);

        return $result;
    }
}