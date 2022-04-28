<?php
require_once plugin_dir_path(__FILE__) . '../../controllers/ListAllFilmsController.php';
require_once plugin_dir_path(__FILE__) . '/WP_Film_List_Table.php';

class ListAllFilmsVM {


    const SEARCHBOX_ID = 'pretrazi_film_searchbox_id';
    const CONTROLER_NAME = 'list-all-films';
    const PRETRAGA_FILMOVA = 'pretraga_filmova';

    public static function getListTable() {

        $filmData = ListAllFilmsController::getFilmDataForList();
        return new WP_Film_List_Table(null,$filmData);

    }


}