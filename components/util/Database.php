<?php

class Database {

    const MOVIE_TABLE_NAME = 'movieplugin_movies';
    const MOVIE_CATEGORIES_TABLE_NAME = 'movieplugin_movie_categories';

    const INVOICE_TABLE_NAME = 'movieplugin_invoices';
    const INVOICE_ITEMS_TABLE_NAME = 'movieplugin_invoice_items';

    /**
     * @var wpdb
     */
    private $db;
    /**
     * @var string
     */
    private $movie_table_name;
    /**
     * @var string
     */
    private $movie_category_table_name;
    /**
     * @var string
     */
    private $invoice_table_name;
    /**
     * @var string
     */
    private $invoice_items_table_name;

    public function __construct() {
        global $wpdb;
        $this->db = $wpdb;
        $this->movie_table_name = $this->db->prefix . self::MOVIE_TABLE_NAME;
        $this->movie_category_table_name = $this->db->prefix . self::MOVIE_CATEGORIES_TABLE_NAME;

        $this->invoice_table_name = $this->db->prefix . self::INVOICE_TABLE_NAME;
        $this->invoice_items_table_name = $this->db->prefix . self::INVOICE_ITEMS_TABLE_NAME;
    }


    public function is_plugin_initialized() {

        $table_name_movies = $this->db->prefix . self::MOVIE_TABLE_NAME;
        $table_name_movie_categories = $this->db->prefix . self::MOVIE_CATEGORIES_TABLE_NAME;
        $table_name_invoices = $this->db->prefix . self::INVOICE_TABLE_NAME;
        $table_name_invoices_items = $this->db->prefix . self::INVOICE_ITEMS_TABLE_NAME;

        return $this->db->get_var('SHOW TABLES LIKE ' . $table_name_movies) === $table_name_movies
            && $this->db->get_var('SHOW TABLES LIKE ' . $table_name_movie_categories) === $table_name_movie_categories
            && $this->db->get_var('SHOW TABLES LIKE ' . $table_name_invoices) === $table_name_invoices
            && $this->db->get_var('SHOW TABLES LIKE ' . $table_name_invoices_items) === $table_name_invoices_items;
    }

    public function install() {
        $this->create_movie_category_table();
        $this->fill_category_table();

        $this->create_movie_table();

        $this->create_invoice_table();
        $this->create_invoice_items_table();
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
        FOREIGN KEY (movie_category_id) REFERENCES  ' . $this->db->prefix . self::MOVIE_CATEGORIES_TABLE_NAME . ' (id) )';

        $this->db->query($query);
    }


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


    private function create_invoice_table() {

        $query = 'CREATE TABLE IF NOT EXISTS ' . $this->invoice_table_name . '(
         invoice_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
         invoice_number VARCHAR(255) NOT NULL,
         order_id BIGINT UNSIGNED NOT NULL ,
         user_id BIGINT UNSIGNED NOT NULL,
         customer_id BIGINT UNSIGNED,
         invoice_date DATE NOT NULL,
         customer_full_name VARCHAR(255) NOT NULL,
         customer_address VARCHAR(255) NOT NULL,
         customer_email VARCHAR(255) NOT NULL,
         invoice_currency VARCHAR(10) NOT NULL,
         invoice_total FLOAT NOT NULL,
         FOREIGN KEY (order_id) REFERENCES ' . $this->db->prefix . 'posts(ID),
         FOREIGN KEY (user_id) REFERENCES ' . $this->db->prefix . 'users(ID),
         FOREIGN KEY (customer_id) REFERENCES ' . $this->db->prefix . 'users(ID))';

        $this->db->query($query);

    }

    private function create_invoice_items_table() {

        $query = 'CREATE TABLE IF NOT EXISTS ' . $this->invoice_items_table_name . '(
         invoice_item_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
         invoice_id INT UNSIGNED NOT NULL,
         product_name VARCHAR(255) NOT NULL,
         product_quantity INT NOT NULL,
         product_price FLOAT NOT NULL,
         FOREIGN KEY (invoice_id) REFERENCES ' . $this->invoice_table_name . '(invoice_id) ON DELETE CASCADE )';

        $this->db->query($query);
    }

}