<?php
require_once plugin_dir_path(__FILE__) . '../../services/InvoiceService.php';
require_once plugin_dir_path(__FILE__) . '../../components/util/MovieHelper.php';

class AllInvoicesVM extends WP_List_Table {

    private $invoices;
    private $total_items;
    private $invoice_service;

    public function __construct($args = array()) {
        parent::__construct($args);

        $this->invoice_service = new InvoiceService();
        $p = $this->get_all_invoice_data_for_list_table();
        $this->invoices=$p['invoices'];
        $this->total_items=$p['total_items'];
    }

    private function get_all_invoice_data_for_list_table() {
        $limit = get_user_meta(get_current_user_id(), 'invoices_per_page')[0];
        $page = isset($_REQUEST['paged']) && esc_html($_REQUEST['paged']) > 0 ? esc_html($_REQUEST['paged']) : 1;
        $offset = $limit * ($page - 1);

        $orderby = !empty($_REQUEST['orderby']) ? esc_html($_REQUEST['orderby']) : null;
        $order = !empty($_REQUEST['order']) ? esc_html($_REQUEST['order']) : null;

        if (isset($_REQUEST['s'])) {
            $invoice_number = esc_html($_REQUEST['s']);
            $invoice_data = $this->invoice_service->find_invoices_by_name($invoice_number, $limit, $offset, $orderby, $order);
            $total_items = $this->invoice_service->get_total_items($invoice_number);
        } else {

            $invoice_data = $this->invoice_service->get_all_invoices_for_list_table($limit, $offset, $orderby, $order);
            $total_items = $this->invoice_service->get_all_total_items();
        }
        return ['invoices'=>$invoice_data,'total_items'=> $total_items];
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


    public function prepare_items() {

        $columns = $this->get_columns();
        $hidden = [];
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = [$columns, $hidden, $sortable];


        $per_page = $this->get_items_per_page('invoices_per_page', 2);

        $total_items = $this->total_items;


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
            'delete' => "<a style='cursor: pointer' class='delete-invoice-btn' url='$url_delete'>" . __('Delete', 'movie-plugin') . "</a>",
        );

        return sprintf('%1$s %2$s', $item['invoice_number'], $this->row_actions($actions));
    }

}