<?php
require_once plugin_dir_path(__FILE__) . '../../services/InvoiceService.php';
require_once plugin_dir_path(__FILE__) . '../../components/util/MovieHelper.php';

class AllInvoicesVM extends WP_List_Table {

    private $invoices;
    private $invoice_service;

    public function __construct($args = array()) {
        parent::__construct($args);

        $this->invoice_service = new InvoiceService();

        $this->invoices = $this->invoice_service->get_all_invoices_for_list_table();
    }

    public function get_columns() {

        return [
            'cb' => '<input type="checkbox"/>',
            'invoice_number' => __('Invoice number', 'movie-plugin'),
            'order_name' => __('Order name', 'movie-plugin'),
            'invoice_date' => __('Date', 'movie-plugin'),
            'customer_full_name' => __('Customer', 'movie-plugin'),
            'customer_email' => __('Email', 'movie-plugin'),
            'customer_address' => __('Address', 'movie-plugin'),
            'invoice_total' => __('Total', 'movie-plugin'),
        ];

    }

    protected function column_default($item, $column_name) {

        switch ($column_name) {
            case 'invoice_number':
            case 'invoice_date':
            case 'order_name':
            case 'customer_full_name':
            case 'customer_email':
            case 'customer_address':
            case 'invoice_total':
                return $item[$column_name];
            default :

        }
    }

    protected function column_cb($item) {

        return sprintf('<input type="checkbox" name="invoice[]" value="%s"/>', $item['invoice_id']);
    }

    protected function get_sortable_columns() {

        $sortableColumns = [
            'invoice_number' => ['invoice_number', true],
            'invoice_date' => ['invoice_date', false],
            'invoice_total' => ['invoice_total', false],
        ];

        return $sortableColumns;

    }

    private function usort_reorder($a, $b) {

        $orderby = (!empty($_GET['orderby'])) ? $_GET['orderby'] : 'invoice_number';
        $order = (!empty($_GET['order'])) ? $_GET['order'] : 'asc';
        $result = strcmp($a[$orderby], $b[$orderby]);

        return ($order == 'asc') ? $result : -$result;
    }

    public function prepare_items() {

        $columns = $this->get_columns();
        $hidden = [];
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = [$columns, $hidden, $sortable];


        $per_page = $this->get_items_per_page('invoices_per_page', 2);

        $current_page = $this->get_pagenum();
        $total_items = count($this->invoices);

        if ($this->invoices) {
            usort($this->invoices, [&$this, 'usort_reorder']);
            $this->invoices = array_slice($this->invoices, (($current_page - 1) * $per_page), $per_page);
        }

        $this->set_pagination_args([
            'total_items' => $total_items,
            'per_page' => $per_page,
            'total_pages' => ceil($total_items / $per_page)
        ]);


        $this->items = $this->invoices;


    }


    public function column_invoice_number($item) {
        $url_delete = MovieHelper::get_controller('Invoice', 'delete_invoice', [
            'invoice_id' => $item['invoice_id']
        ]);
        $actions = array(
            'view' => sprintf('<a href="?page=%s&%s=%s">%s</a>', 'invoice', 'invoice_id', $item['invoice_id'], __('View', 'movie-plugin')),
            'delete' => "<a class='delete-invoice-btn'>".__('Delete', 'movie-plugin')."</a>",
        );

        return sprintf('%1$s %2$s', $item['invoice_number'], $this->row_actions($actions));
    }

}