<?php

class MovieCategoryRepository {


    private $table_name;
    private $db;


    public function __construct() {
        global $wpdb;
        $this->db = $wpdb;
        $this->table_name = $this->db->prefix . BaseRepository::MOVIE_CATEGORIES_TABLE_NAME;
    }


    public function check_database_and_fill_table() {

        $this->create_database_table();
        $this->fill_table();
    }

    private function create_database_table() {

        $query = 'CREATE TABLE IF NOT EXISTS `'
            . $this->table_name . '` (
            `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `movie_category_name` VARCHAR(50) NOT NULL,
            `movie_category_slug` VARCHAR(50) NOT NULL,
            UNIQUE (`movie_category_slug`)
        ) DEFAULT CHARACTER SET utf8';

        $this->db->query($query);
    }

    private function fill_table() {

        $query = "SELECT `movie_category_name`, `movie_category_slug`  FROM `" . $this->table_name . "`";

        $result = $this->db->get_results($query);

        if ($result) {
            return;
        }

        foreach ($this->categories() as $category) {
            $this->db->insert($this->table_name, ['movie_category_name' => $category[0], 'movie_category_slug' => $category[1]]);
        }

    }

    private function categories() {
        return [
            ['Komedija', 'komedija'],
            ['Horor', 'horor'],
            ['Drama', 'drama'],
        ];
    }

    public function get_movie_categories() {

        $query = 'SELECT * FROM  ' . $this->table_name;
        $result = $this->db->get_results($query, ARRAY_A);

        return $result;
    }

    public function get_movie_category_by_slug($zanrSlug) {

        $query = "SELECT `movie_category_name`, `movie_category_slug` FROM  $this->table_name  WHERE `movie_category_slug`=%s ";

        $sql = $this->db->prepare($query, [$zanrSlug]);

        $result = $this->db->get_row($sql, ARRAY_A);

        return $result;
    }
    public function get_movie_category_by_id($id) {

        $query = "SELECT `movie_category_name`, `movie_category_slug` FROM  $this->table_name  WHERE `id`=%d ";

        $sql = $this->db->prepare($query, [$id]);

        $result = $this->db->get_row($sql, ARRAY_A);

        return $result;
    }

}