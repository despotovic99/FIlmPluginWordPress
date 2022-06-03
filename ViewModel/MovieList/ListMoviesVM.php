<?php

use services\MovieService;

require_once plugin_dir_path(__FILE__) . '../../services/MovieService.php';
require_once plugin_dir_path(__FILE__) . '/WP_Movie_List_Table.php';

class ListMoviesVM {


    /**
     * @var MovieService
     */
    private $movie_service;

    public function __construct() {

        $this->movie_service = new MovieService();
    }

    public function get_list_table() {

        $limit = get_user_meta(get_current_user_id(), 'movies_per_page')[0];
        $page = isset($_REQUEST['paged']) && esc_html($_REQUEST['paged']) > 0 ? esc_html($_REQUEST['paged']) : 1;
        $offset = $limit * ($page - 1);

        $orderby = !empty($_REQUEST['orderby']) ? esc_html($_REQUEST['orderby']) : null;
        $order = !empty($_REQUEST['order']) ? esc_html($_REQUEST['order']) : null;

        if (isset($_REQUEST['s'])) {
            $name = esc_html($_REQUEST['s']);

            $movie_data = $this->movie_service->find_movie_by_name($name, $limit, $offset, $orderby, $order);
        } else {

            $movie_data = $this->movie_service->find_all_movies($limit, $offset, $orderby, $order);
        }


        return new WP_Movie_List_Table(null, $movie_data);

    }

//    function get_search_action(){
//        $this->get
//    }


}