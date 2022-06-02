<?php

class MovieRepository {

    public function __construct() {
        global $wpdb;
        $this->db = $wpdb;
        $this->movie_table_name = $this->db->prefix . BaseRepository::MOVIE_TABLE_NAME;
        $this->movie_category_table_name = $this->db->prefix . BaseRepository::MOVIE_CATEGORIES_TABLE_NAME;
    }


    public function check_movie_tables() {
        $this->create_movie_category_table();
        $this->fill_category_table();

        $this->create_movie_table();
    }

    private function create_movie_table() {

        $query = 'CREATE TABLE IF NOT EXISTS ' . $this->movie_table_name
            . '  (
        id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        movie_name VARCHAR(255) NOT NULL,
        movie_description VARCHAR(255) NOT NULL,
        movie_date DATE NOT NULL,
        movie_length VARCHAR(50) NOT NULL,
        movie_age INT(3) NOT NULL,
        movie_category_id INT NOT NULL,
        FOREIGN KEY (movie_category_id) REFERENCES  ' . $this->db->prefix . BaseRepository::MOVIE_CATEGORIES_TABLE_NAME . ' (id) )';

        $result = $this->db->query($query);
        return $result;
    }

    public function get_movie_by_id($id) {
        $query = "SELECT  m.`id` AS movie_id , 
                            movie_name ,
                            movie_description,
                            movie_date, 
                            movie_length,
                            movie_age,  
                            c.id AS movie_category_id,
                            c.movie_category_name AS movie_category_name, 
                            movie_category_slug
                            FROM " . $this->movie_table_name . " m
                            INNER JOIN " . $this->db->prefix . BaseRepository::MOVIE_CATEGORIES_TABLE_NAME . " c 
                            ON m.movie_category_id=c.id
                            WHERE m.id=' " . $id . " ' ";

        $result = $this->db->get_row($query, ARRAY_A);

        return $result;
    }

    public function get_movie_by_name($name, $limit, $offset, $column_name = 'movie_name', $order = 'ASC') {
        $column_name = $column_name === null ? 'movie_name' : $column_name;
        $query = "SELECT  m . `id` as movie_id , movie_name , movie_age,  c. movie_category_name as movie_category_name, movie_date, movie_length
                            FROM " . $this->movie_table_name . " m
                            INNER JOIN " . $this->db->prefix . BaseRepository::MOVIE_CATEGORIES_TABLE_NAME . " c 
                            ON m . movie_category_id = c . id
                            WHERE movie_name LIKE '%" . $name . "%' 
                            ORDER BY " . $column_name . "   " . $order . "
                            LIMIT " . $limit . " OFFSET " . $offset;

        $query_total_items = "SELECT count(*) as total_items
                                                      FROM " . $this->movie_table_name .
            " WHERE movie_name LIKE '%" . $name . "%' ";

        $result = $this->db->get_results($query, ARRAY_A);

        $total_items = $this->db->get_row($query_total_items, ARRAY_A);

        return [$result, $total_items];
    }

    public function get_movie_data_for_list_table($limit, $offset, $column_name = 'movie_name', $order = 'ASC') {

        $column_name = $column_name === null ? 'movie_name' : $column_name;
        $query = "SELECT  m . `id` as movie_id , movie_name , movie_age,  c. movie_category_name as movie_category_name, movie_date, movie_length
                            FROM " . $this->movie_table_name . " m
                            INNER JOIN " . $this->db->prefix . BaseRepository::MOVIE_CATEGORIES_TABLE_NAME . " c 
                            ON m. movie_category_id = c . id
                            ORDER BY " . $column_name . "   " . $order . "
                            LIMIT " . $limit . " OFFSET " . $offset;

        $query_total_items = "SELECT count(*) as total_items
                                                      FROM " . $this->movie_table_name;

        $result = $this->db->get_results($query, ARRAY_A);

        $total_items = $this->db->get_row($query_total_items, ARRAY_A);

        return [$result, $total_items];
    }

    public function save_new_movie($movie) {

        $result = $this->db->insert($this->movie_table_name, $movie);
        if ($result) {
            $last_id = $this->db->insert_id;

            return $last_id;
        }

        return false;
    }

    public function update_movie($id, $movie) {

        $result = $this->db->update($this->movie_table_name, $movie, ['id' => $id]);
        if ($result) {
            return $id;
        }

        return false;
    }

    public function delete_movie($id) {
        $result = $this->db->delete($this->movie_table_name, ['id' => $id]);
        return $result;
    }

//

    private function create_movie_category_table() {

        $query = 'CREATE TABLE IF NOT EXISTS `'
            . $this->movie_category_table_name . '` (
            `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            `movie_category_name` VARCHAR(50) NOT NULL,
            `movie_category_slug` VARCHAR(50) NOT NULL,
            UNIQUE (`movie_category_slug`)
        ) DEFAULT CHARACTER SET utf8';

        $this->db->query($query);
    }

    private function fill_category_table() {

        $query = "SELECT `movie_category_name`, `movie_category_slug`  FROM `" . $this->movie_category_table_name . "`";

        $result = $this->db->get_results($query);
        if ($result) {
            return;
        }

        foreach ($this->categories() as $category) {
            $this->db->insert($this->movie_category_table_name, ['movie_category_name' => $category[0], 'movie_category_slug' => $category[1]]);
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

        $query = 'SELECT * FROM  ' . $this->movie_category_table_name;
        $result = $this->db->get_results($query, ARRAY_A);

        return $result;
    }

    public function get_movie_category_by_slug($zanrSlug) {

        $query = "SELECT `movie_category_name`, `movie_category_slug` FROM  $this->movie_category_table_name  WHERE `movie_category_slug`=%s ";
        $sql = $this->db->prepare($query, [$zanrSlug]);
        $result = $this->db->get_row($sql, ARRAY_A);

        return $result;
    }

    public function get_movie_category_by_id($id) {

        $query = "SELECT `movie_category_name`, `movie_category_slug` FROM  $this->movie_category_table_name  WHERE `id`=%d ";
        $sql = $this->db->prepare($query, [$id]);
        $result = $this->db->get_row($sql, ARRAY_A);

        return $result;
    }

}