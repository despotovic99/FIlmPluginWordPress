<?php

use services\MovieService;

require_once plugin_dir_path(__FILE__) . '../../services/MovieService.php';
require_once plugin_dir_path(__FILE__) . '/WP_Movie_List_Table.php';

class ListMoviesVM {


    public function __construct() {

        $this->movie_db_service = new MovieService();
    }

    public function get_list_table() {

        $movie_data = null;
        $limit = get_user_meta(get_current_user_id(), 'movies_per_page')[0];
        $page = isset($_REQUEST['paged']) && esc_html($_REQUEST['paged'])>0 ?esc_html($_REQUEST['paged']) : 1;
        $offset = $limit * ($page-1);

        $orderby=isset($_REQUEST['orderby'])?$_REQUEST['orderby']:null;
        $order=isset($_REQUEST['order'])?$_REQUEST['order']:null;

        if (isset($_REQUEST['s'])) {
            $name = esc_html($_REQUEST['s']);

            $movie_data = BaseRepository::get_base_repository()
                ->get_movie_repository()
                ->get_movie_by_name($name, $limit,$offset,$orderby,$order);
        } else {

            $movie_data = BaseRepository::get_base_repository()
                ->get_movie_repository()
                ->get_movie_data_for_list_table($limit,$offset,$orderby,$order);
        }


        return new WP_Movie_List_Table(null, $movie_data);

    }

//    function get_search_action(){
//        $this->get
//    }


}