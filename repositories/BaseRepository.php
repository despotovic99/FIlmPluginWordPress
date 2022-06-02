<?php
require_once 'MovieRepository.php';
require_once 'InvoiceRepository.php';

class BaseRepository {

    const MOVIE_TABLE_NAME = 'movieplugin_movies';
    const MOVIE_CATEGORIES_TABLE_NAME = 'movieplugin_movie_categories';

    const INVOICE_TABLE_NAME = 'movieplugin_invoices';
    const INVOICE_ITEMS_TABLE_NAME = 'movieplugin_invoice_items';

    private $db;

    private static $base_repository;
    private $movie_repository;
    private  $invoice_repository;

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

        $this->movie_repository = new MovieRepository();
        $this->movie_repository->check_movie_tables();

        $this->invoice_repository=new InvoiceRepository();
        $this->invoice_repository->initialize_invoice_tables();

    }


    public function is_plugin_initialized() {

        $table_name_movies = $this->db->prefix . self::MOVIE_TABLE_NAME;
        $table_name_movie_categories = $this->db->prefix . self::MOVIE_CATEGORIES_TABLE_NAME;
        $table_name_invoices = $this->db->prefix . self::INVOICE_TABLE_NAME;
        $table_name_invoices_items = $this->db->prefix . self::INVOICE_ITEMS_TABLE_NAME;

        return $this->db->get_var('SHOW TABLES LIKE ' . $table_name_movies) === $table_name_movies
            && $this->db->get_var('SHOW TABLES LIKE ' . $table_name_movie_categories) === $table_name_movie_categories
            && $this->db->get_var('SHOW TABLES LIKE '.$table_name_invoices)===$table_name_invoices
            && $this->db->get_var('SHOW TABLES LIKE '.$table_name_invoices_items)===$table_name_invoices_items;
    }


}