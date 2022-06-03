<?php
require_once 'MovieRepository.php';
require_once 'InvoiceRepository.php';

class BaseRepository {

    private static $base_repository;
    /**
     * @var wpdb
     */
    private $db;

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

}