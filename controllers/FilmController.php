<?php
require_once 'interface/ControllerInterface.php';
require_once plugin_dir_path(__FILE__) . '../components/services/FilmDatabaseService.php';
require_once plugin_dir_path(__FILE__) . '../components/services/ZanrDatabaseService.php';
require_once plugin_dir_path(__FILE__) . '../ViewModel/NoviFilm/FilmVM.php';

class FilmController implements ControllerInterface {


    public function __construct() {

        $this->filmDBService = new FilmDatabaseService();
    }

    public function handleAction($action) {

        switch ($action) {
            case FilmVM::SAVE_ACTION:
                $id = $this->sacuvajFilm();
                $url = 'admin.php?page=filmpage';

                if ($id) {
                    $url = 'admin.php?page=filmviewpage&' . FilmVM::ID_INPUT_NAME . '=' . $id;
                }

                wp_redirect(admin_url($url));
                break;

            case FilmVM::DELETE_ACTION:
                $this->deleteFilm();
                wp_redirect(admin_url('admin.php?page=filmplugin'));
                break;
        }

    }

    private function sacuvajFilm() {

        $id = '';

        if (!empty($_POST[FilmVM::ID_INPUT_NAME])) {

            $id = esc_html($_POST[FilmVM::ID_INPUT_NAME]);

            $result = $this->filmDBService->updateFilm($id);

        } else {

            $result = $this->filmDBService->saveFilm();
        }

        if ($result)
            $id = $result;

        return $id;

    }


    private function deleteFilm() {

        if (empty($_POST[FilmVM::ID_INPUT_NAME]) ||
            esc_html($_POST[FilmVM::ID_INPUT_NAME]) == '') {

            return;
        }

        $id = $_POST[FilmVM::ID_INPUT_NAME];

        $this->filmDBService->deleteFilm($id);

    }

}