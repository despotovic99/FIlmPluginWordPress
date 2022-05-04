<?php

class FilmRepository {

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

    public function getFilmById($id) {
        $query = "SELECT  f.`id` AS film_id , 
                            naziv_filma ,
                            opis,
                            pocetak_prikazivanja, 
                            duzina_trajanja,
                            uzrast,  
                            z.id AS id_zanra,
                            z.naziv_zanr AS zanr, 
                            slug
                            FROM " . $this->nazivTabele . " f
                            INNER JOIN " . $this->db->prefix . BaseRepository::NAZIV_ZANR_TABELE . " z 
                            ON f.zanr_id=z.id
                            WHERE f.id=' " . $id . " ' ";

        $result = $this->db->get_row($query, ARRAY_A);

        return $result;
    }

    public function getFilmByName($name) {
        $query = "SELECT  f . `id` as film_id , naziv_filma , uzrast,  z . naziv_zanr as zanr, pocetak_prikazivanja, duzina_trajanja
                            FROM " . $this->nazivTabele . " f
                            INNER JOIN " . $this->db->prefix . BaseRepository::NAZIV_ZANR_TABELE . " z 
                            ON f . zanr_id = z . id
                            WHERE naziv_filma LIKE '%" . $name . "%' ";

        $result = $this->db->get_results($query, ARRAY_A);

        return $result;
    }

    public function getFilmDatafForListTable() {

        $query = "SELECT  f . `id` as film_id , naziv_filma , uzrast,  z . naziv_zanr as zanr, pocetak_prikazivanja, duzina_trajanja
                            FROM " . $this->nazivTabele . " f
                            INNER JOIN " . $this->db->prefix . BaseRepository::NAZIV_ZANR_TABELE . " z 
                            ON f . zanr_id = z . id";

        $result = $this->db->get_results($query, ARRAY_A);

        return $result;
    }

    public function saveNewFilm($film) {

        if (!BaseRepository::getBaseRepository()
            ->getZanrRepository()->daLiPostojiZanrId($film['zanr_id'])) {
            return;
        }

        $result = $this->db->insert($this->nazivTabele, $film);

        if ($result) {
            $last_id = $this->db->insert_id;

            return $last_id;
        }

        return false;
    }

    public function updateFilm($id, $film) {


        $result = $this->db->update($this->nazivTabele, $film, ['id' => $id]);

        if($result){
            return $id;
        }

        return false;
    }

    public function deleteFilm($id) {

        $result = $this->db->delete($this->nazivTabele, ['id' => $id]);

        return $result;
    }

}