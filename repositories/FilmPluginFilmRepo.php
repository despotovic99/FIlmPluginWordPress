<?php
require_once 'interface/FIlmPluginFilmRepoInterface.php';

class FilmPluginFilmRepo implements FIlmPluginFilmRepoInterface {

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

    public function getFilmDatafForListTable() {

        $query = "SELECT  `id` AS film_id ,`post_title` AS naziv_filma , pm1.`meta_value` AS uzrast, pm2.`meta_value` AS zanr
                            FROM `wp_posts` p 
                            INNER JOIN `wp_postmeta` pm1 
                            ON p.`id`=pm1.`post_id`
                            INNER JOIN `wp_postmeta` pm2
                            ON p.`id`=pm2.`post_id`
                            WHERE `post_type`='film_type' AND (`post_status`='publish' OR `post_status`='draft') 
                            AND pm1.`meta_key`='_film_type_uzrast_meta_key'  AND pm2.`meta_key`='_film_type_zanr'";

        $result = $this->db->get_results($query, ARRAY_A);

        return $result;
    }
}