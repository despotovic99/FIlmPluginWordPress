<?php

class InvoiceRepository {

    public function __construct() {
        global $wpdb;
        $this->db = $wpdb;
        $this->table_name = $this->db->prefix . BaseRepository::INVOICE_TABLE_NAME;
    }


    public function initialize_invoice_table() {

        $query = 'CREATE TABLE IF NOT EXISTS ' . $this->table_name . '(
         invoice_id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
         invoice_number VARCHAR(255) NOT NULL,
         order_id BIGINT UNSIGNED NOT NULL ,
         user_id BIGINT UNSIGNED NOT NULL,
         customer_id BIGINT UNSIGNED NOT NULL,
         invoice_date DATE NOT NULL,
         customer_full_name VARCHAR(255) NOT NULL,
         customer_address VARCHAR(255) NOT NULL,
         customer_email VARCHAR(255) NOT NULL,
         FOREIGN KEY (order_id) REFERENCES ' . $this->db->prefix . 'posts(ID),
         FOREIGN KEY (user_id) REFERENCES ' . $this->db->prefix . 'users(ID),
         FOREIGN KEY (customer_id) REFERENCES ' . $this->db->prefix . 'users(ID))';

        $result = $this->db->query($query);
        return $result;
    }

    public function get_all_invoices() {

        $query = 'SELECT * FROM ' . $this->table_name;

        $result = $this->db->get_results($query, ARRAY_A);

        return $result;
    }

}


