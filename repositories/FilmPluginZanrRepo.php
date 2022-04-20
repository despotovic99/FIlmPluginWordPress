<?php

class FilmPluginZanrRepo {


    private $nazivTabele;
    private $db;


    public function __construct() {
        global $wpdb;
        $this->db = $wpdb;
        $this->nazivTabele = $wpdb->prefix . 'filmplugin_zanrovi';
    }


    public function checkDatabaseAndRunMigrations() {

        $this->createDatabaseTable();
        $this->fillTable();
    }

    private function createDatabaseTable() {

        $query = 'CREATE TABLE IF NOT EXISTS `'
            . $this->nazivTabele . '` (
            `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `naziv_zanr` VARCHAR(50) NOT NULL,
            `slug` VARCHAR(50) NOT NULL,
            UNIQUE (`slug`)
        ) DEFAULT CHARACTER SET utf8';

        $this->db->query($query);
    }

    private function fillTable() {

        $query = "SELECT `naziv_zanr`, `slug`  FROM `" . $this->nazivTabele . "`";

        $result = $this->db->get_results($query);

        if ($result) {
            return;
        }

        foreach ($this->zanroviList() as $zanr) {
            $this->db->insert($this->nazivTabele, ['naziv_zanr' => $zanr[0], 'slug' => $zanr[1]]);
        }

    }

    private function zanroviList() {
        return [
            ['Komedija', 'komedija'],
            ['Horor', 'horor'],
            ['Drama', 'drama'],
        ];
    }

    public function getZanroviFromTable() {

        $query = 'SELECT * FROM  ' . $this->nazivTabele;
        $result = $this->db->get_results($query);

        return $result;
    }

    public function daLiPostojiZanr($zanrSlug) {

        $query = "SELECT `naziv_zanr`, `slug` FROM  $this->nazivTabele  WHERE `slug`=%s ";

        $sql = $this->db->prepare($query, [$zanrSlug]);

        $result = $this->db->get_results($sql,ARRAY_A);

        if(!$result){
            return false;
        }
        return true;
    }

}