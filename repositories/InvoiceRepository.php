<?php

class InvoiceRepository {

    /**
     * @var string
     */
    private $invoice_table_name;
    /**
     * @var string
     */
    private $invoice_items_table_name;
    /**
     * @var wpdb
     */
    private $db;

    public function __construct() {
        global $wpdb;
        $this->db = $wpdb;
        $this->invoice_table_name = $this->db->prefix . Database::INVOICE_TABLE_NAME;
        $this->invoice_items_table_name = $this->db->prefix . Database::INVOICE_ITEMS_TABLE_NAME;
    }


    public function get_all_invoices($limit = 10, $offset = 1, $orderby = '', $order = 'ASC') {
        $orderby = $orderby === null ? 'invoice_id' : $orderby;
        $query = 'SELECT * FROM ' . $this->invoice_table_name
            . '  ORDER BY  ' . $orderby . ' ' . $order
            . '  LIMIT  ' . $limit . ' OFFSET ' . $offset;


        $result = $this->db->get_results($query, ARRAY_A);

        return $result;
    }

    public function get_invoices_by_name($name, $limit = 10, $offset = 1, $orderby = '', $order = 'ASC') {
        $orderby = $orderby === null ? 'invoice_id' : $orderby;
        $query = 'SELECT * FROM ' . $this->invoice_table_name
            . ' WHERE invoice_number LIKE  "%'.$name.'%"'
            . '  ORDER BY  ' . $orderby . ' ' . $order
            . '  LIMIT  ' . $limit . ' OFFSET ' . $offset;


        $result = $this->db->get_results($query, ARRAY_A);

        return $result;
    }

    public function get_total_items($invoice_number=''){

        $query_total_items = "SELECT count(*) as total_items
                                                      FROM " . $this->invoice_table_name;
             if($invoice_number!=='')
                 $query_total_items.=" WHERE invoice_number LIKE '%" . $invoice_number . "%' ";

//        $total_items = $this->db->get_row($query_total_items, ARRAY_A);
        $total_items = $this->db->get_var($query_total_items);

        return $total_items;
    }


    public function save_invoice($invoice, $invoice_items) {
        // todo implementiraj transakcije
        $result = $this->db->insert($this->invoice_table_name, $invoice);

        if (!$result) {

            return $result;
        }

        $last_id = $this->db->insert_id;

        foreach ($invoice_items as $invoice_item) {
            $invoice_item['invoice_id'] = $last_id;
            $this->db->insert($this->invoice_items_table_name, $invoice_item);
        }

        return true;
    }

    public function delete_invoice_by_id($invoice_id) {

        $result = $this->db->delete($this->invoice_table_name, ['invoice_id' => $invoice_id]);

        return $result;
    }

    public function get_invoice_by_id($invoice_id) {

        //todo sql injection proveri fje wordpressove
        // get_results ne preventuje sql injection
        $query = 'SELECT * FROM ' . $this->invoice_table_name . ' WHERE invoice_id=%d';
        $query = $this->db->prepare($query, [$invoice_id]);

        $result = $this->db->get_row($query, ARRAY_A);
        if (!$result)
            return $result;
        $result['invoice_items'] = [];

        $query = 'SELECT * FROM ' . $this->invoice_items_table_name . ' WHERE invoice_id=%d';
        $query = $this->db->prepare($query, [$invoice_id]);
        $invoice_items = $this->db->get_results($query, ARRAY_A);

        if ($invoice_items) {
            $result['invoice_items'] = $invoice_items;
        }

        return $result;
    }


}


