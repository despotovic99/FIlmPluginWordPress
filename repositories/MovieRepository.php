<?php

class MovieRepository {

    public function __construct() {
        global $wpdb;
        $this->db = $wpdb;
        $this->table_name = $this->db->prefix . BaseRepository::MOVIE_TABLE_NAME;
    }


    public function check_movie_table() {

        $this->create_movie_table();
    }

    private function create_movie_table() {

        $query = 'CREATE TABLE IF NOT EXISTS ' . $this->table_name
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
                            FROM " . $this->table_name . " m
                            INNER JOIN " . $this->db->prefix . BaseRepository::MOVIE_CATEGORIES_TABLE_NAME . " c 
                            ON m.movie_category_id=c.id
                            WHERE m.id=' " . $id . " ' ";

        $result = $this->db->get_row($query, ARRAY_A);

        return $result;
    }

    public function get_movie_by_name($name) {
        $query = "SELECT  m . `id` as movie_id , movie_name , movie_age,  c. movie_category_name as movie_category_name, movie_date, movie_length
                            FROM " . $this->table_name . " m
                            INNER JOIN " . $this->db->prefix . BaseRepository::MOVIE_CATEGORIES_TABLE_NAME . " c 
                            ON m . movie_category_id = c . id
                            WHERE movie_name LIKE '%" . $name . "%' ";

        $result = $this->db->get_results($query, ARRAY_A);

        return $result;
    }

    public function get_movie_data_for_list_table() {

        $query = "SELECT  m . `id` as movie_id , movie_name , movie_age,  c. movie_category_name as movie_category_name, movie_date, movie_length
                            FROM " . $this->table_name . " m
                            INNER JOIN " . $this->db->prefix . BaseRepository::MOVIE_CATEGORIES_TABLE_NAME . " c 
                            ON m. movie_category_id = c . id";

        $result = $this->db->get_results($query, ARRAY_A);

        return $result;
    }

    public function save_new_movie($movie) {

        if (!BaseRepository::get_base_repository()
            ->get_movie_category_repository()->get_movie_category_by_id($movie['movie_category_id'])) {
            return;
        }

        $result = $this->db->insert($this->table_name, $movie);

        if ($result) {
            $last_id = $this->db->insert_id;

            return $last_id;
        }

        return false;
    }

    public function update_movie($id, $movie) {


        $result = $this->db->update($this->table_name, $movie, ['id' => $id]);

        if($result){
            return $id;
        }

        return false;
    }

    public function delete_movie($id) {

        $result = $this->db->delete($this->table_name, ['id' => $id]);

        return $result;
    }

}