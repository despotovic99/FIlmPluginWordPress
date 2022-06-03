<?php

class MovieRepository {

    /**
     * @var string
     */
    private $movie_table_name;
    /**
     * @var string
     */
    private $movie_category_table_name;
    /**
     * @var wpdb
     */
    private $db;

    public function __construct() {
        global $wpdb;
        $this->db = $wpdb;
        $this->movie_table_name = $this->db->prefix . Database::MOVIE_TABLE_NAME;
        $this->movie_category_table_name = $this->db->prefix . Database::MOVIE_CATEGORIES_TABLE_NAME;
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
                            INNER JOIN " . $this->movie_category_table_name. " c 
                            ON m.movie_category_id=c.id
                            WHERE m.id=%d ";

        $query = $this->db->prepare($query,[$id ]);
        $result = $this->db->get_row($query, ARRAY_A);

        return $result;
    }

    public function get_movie_by_name($name, $limit, $offset, $column_name = 'movie_name', $order = 'ASC') {
        // todo ovde mozes da popijes sql injection
        $column_name = $column_name === null ? 'movie_name' : $column_name;
        $query = "SELECT  m . `id` as movie_id , movie_name , movie_age,  c. movie_category_name as movie_category_name, movie_date, movie_length
                            FROM " . $this->movie_table_name . " m
                            INNER JOIN " . $this->movie_category_table_name. " c 
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
        // todo ovde mozes da popijes sql injection takodje
        $column_name = $column_name === null ? 'movie_name' : $column_name;
        $query = "SELECT  m . `id` as movie_id , movie_name , movie_age,  c. movie_category_name as movie_category_name, movie_date, movie_length
                            FROM " . $this->movie_table_name . " m
                            INNER JOIN " . $this->movie_category_table_name . " c 
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