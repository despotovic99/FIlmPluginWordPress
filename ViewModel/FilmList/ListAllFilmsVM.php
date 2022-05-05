<?php
require_once plugin_dir_path(__FILE__) . '../../components/services/FilmDatabaseService.php';
require_once plugin_dir_path(__FILE__) . '/WP_Film_List_Table.php';

class ListAllFilmsVM {


    const SEARCHBOX_ID = 'pretrazi_film_searchbox_id';

    public function __construct() {

        $this->filmDBService = new FilmDatabaseService();
    }

    public function getListTable() {

        $filmData = null;
        if (isset($_REQUEST['page']) && isset($_REQUEST['s'])) {
            $name = esc_html($_REQUEST['s']);

            $filmData = BaseRepository::getBaseRepository()->getFilmRepository()->getFilmByName($name);
        } else {

            $filmData = BaseRepository::getBaseRepository()->getFilmRepository()->getFilmDatafForListTable();
        }


        return new WP_Film_List_Table(null, $filmData);

    }


}