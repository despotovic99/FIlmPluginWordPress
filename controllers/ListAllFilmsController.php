<?php
require_once plugin_dir_path(__FILE__) . 'interface/ControllerInterface.php';
require_once plugin_dir_path(__FILE__) . '../ViewModel/FilmList/ListAllFilmsVM.php';

class ListAllFilmsController implements ControllerInterface {

    private static $filmData = null;

    public static function getFilmDataForList() {
        if (self::$filmData !== null) {
            return self::$filmData;
        }
        return BaseRepository::getBaseRepository()->getFilmRepository()->getFilmDatafForListTable();
    }

    public function setFilmData() {

        if (isset($_REQUEST['page']) && isset($_REQUEST['s'])) {
            $name = esc_html($_REQUEST['s']);

            self::$filmData = BaseRepository::getBaseRepository()->getFilmRepository()->getFilmByName($name);
        }

    }


    public function handleAction($action) {

        switch ($action) {
            case  ListAllFilmsVM::PRETRAGA_FILMOVA:
                $this->setFilmData();
                break;
        }

    }
}