<?php
require_once 'MovieRepository.php';
require_once 'MovieCategoryRepository.php';
require_once 'InvoiceRepository.php';

class BaseRepository {

    const MOVIE_TABLE_NAME = 'movieplugin_movies';
    const MOVIE_CATEGORIES_TABLE_NAME = 'movieplugin_movie_categories';

    const INVOICE_TABLE_NAME = 'movieplugin_invoices';

    private $db;

    private static $base_repository;
    private $movie_category_repository;
    private $movie_repository;

    private $invoice_repository;

    /**
     * @param string $tableFilm
     * @param string $tableZanr
     */
    private function __construct() {
        global $wpdb;
        $this->db = $wpdb;
    }

    public static function get_base_repository() {
        if (self::$base_repository == null) {
            self::$base_repository = new BaseRepository();
        }
        return self::$base_repository;
    }

    public function initialize_movie_plugin_tables() {

        $this->movie_category_repository = new MovieCategoryRepository();
        $this->movie_category_repository->check_database_and_fill_table();

        $this->movie_repository = new MovieRepository();
        $this->movie_repository->check_movie_table();

        $this->invoice_repository=new InvoiceRepository();
        $this->invoice_repository->initialize_invoice_table();

    }

    /**
     * @return mixed
     */
    public function get_movie_category_repository() {
        if ($this->movie_category_repository) {
            return $this->movie_category_repository;
        }
        return new MovieCategoryRepository();
    }

    /**
     * @return mixed
     */
    public function get_movie_repository() {
        if ($this->movie_repository) {
            return $this->movie_repository;
        }
        return new MovieRepository();
    }

    public function is_plugin_initialized() {

        $table_name_movies = $this->db->prefix . self::MOVIE_TABLE_NAME;
        $table_name_movie_categories = $this->db->prefix . self::MOVIE_CATEGORIES_TABLE_NAME;
        $table_name_invoices = $this->db->prefix . self::INVOICE_TABLE_NAME;

        return $this->db->get_var('SHOW TABLES LIKE ' . $table_name_movies) === $table_name_movies
            && $this->db->get_var('SHOW TABLES LIKE ' . $table_name_movie_categories) === $table_name_movie_categories
            && $this->db->get_var('SHOW TABLES LIKE '.$table_name_invoices)===$table_name_invoices;
    }


}