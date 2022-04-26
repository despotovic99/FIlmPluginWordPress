<?php
require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
require_once plugin_dir_path(__FILE__) . '../../repositories/interface/FIlmPluginFilmRepoInterface.php';

class WP_Film_List_Table extends WP_List_Table {

    private $repo;

    private $filmData;

    public function __construct($args = array(), FIlmPluginFilmRepoInterface $filmRepo) {
        parent::__construct($args);
        $this->repo = $filmRepo;
    }

    public function get_film_data() {
        return $this->repo->getFilmDatafForListTable();
    }

    public function get_columns() {

        return [
            'cb' => '<input type="checkbox"/>',
            'naziv_filma' => 'Naziv filma',
            'uzrast' => 'Predvidjeni uzrast',
            'zanr' => 'Zanr',
            'action' => 'Akcije'
        ];

    }

    protected function column_default($item, $column_name) {

        switch ($column_name) {
            case 'naziv_filma':
            case 'uzrast':
            case 'zanr':
                return $item[$column_name];
            case 'print':
                return '<button>Stampaj</button>';
            default :
//                return print_r($item, true);
        }
    }

    protected function column_cb($item) {

        return sprintf('<input type="checkbox" value="%s"/>', $item['film_id']);
    }

    protected function get_sortable_columns() {

        $sortableColumns = [
            'naziv_filma' => ['naziv_filma', true],
            'zanr' => ['zanr', false],
            'uzrast' => ['uzrast', false],
        ];

        return $sortableColumns;

    }

    private function usort_reorder($a, $b) {

        $orderby = (!empty($_GET['orderby'])) ? $_GET['orderby'] : 'naziv_filma'; // po kojoj koloni
        $order = (!empty($_GET['order'])) ? $_GET['order'] : 'asc'; //rastuci ili opadajuci redosled
        $result = strcmp($a[$orderby], $b[$orderby]);

        return ($order == 'asc') ? $result : -$result;
    }

    public function prepare_items() {

        $this->filmData = $this->get_film_data();

        $columns = $this->get_columns();
        $hidden = [];
        $sortable = $this->get_sortable_columns();
        $this->_column_headers = [$columns, $hidden, $sortable];

        usort($this->filmData, [&$this, 'usort_reorder']);

        $perPage = 2;
        global $wp_query;
        $currentPage = $this->get_pagenum();
        $totalItems = count($this->filmData);

      //  $this->filmData = array_slice($this->filmData, (($currentPage - 1) * $perPage), $perPage);

        $this->set_pagination_args([
            'total_items'=>$totalItems,
            'per_page'=>$perPage,
            'total_pages'=>ceil($totalItems/$perPage)
        ]);


        $this->items = $this->filmData;
    }


}