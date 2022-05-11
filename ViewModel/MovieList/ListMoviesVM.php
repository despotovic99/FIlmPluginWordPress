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
        if (isset($_REQUEST['page']) && isset($_REQUEST['s'])) {
            $name = esc_html($_REQUEST['s']);

            $movie_data = BaseRepository::get_base_repository()->get_movie_repository()->get_movie_by_name($name);
        } else {

            $movie_data = BaseRepository::get_base_repository()->get_movie_repository()->get_movie_data_for_list_table();
        }


        return new WP_Movie_List_Table(null, $movie_data);

    }


}