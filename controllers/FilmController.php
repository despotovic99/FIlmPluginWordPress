<?php
require_once 'interface/ControllerInterface.php';
require_once plugin_dir_path(__FILE__) . '../components/services/FilmDatabaseService.php';
require_once plugin_dir_path(__FILE__) . '../components/services/ZanrDatabaseService.php';
require_once plugin_dir_path(__FILE__) . '../components/services/printers/FilmPrinterService.php';
require_once plugin_dir_path(__FILE__) . '../ViewModel/NoviFilm/FilmVM.php';

class FilmController implements ControllerInterface {


    public function __construct() {

        $this->filmDBService = new FilmDatabaseService();
        $this->filmPrintService = new FilmPrinterService();
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

            case FilmVM::PRINT_ACTION:

                $this->printFilm();
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

        if (empty($_POST[FilmVM::ID_INPUT_NAME])) {

            return;
        }

        $id = esc_html($_POST[FilmVM::ID_INPUT_NAME]);

        $this->filmDBService->deleteFilm($id);

    }

    private function printFilm() {

        if (empty($_POST[FilmVM::PRINTER_NAME]) ||
            empty($_GET[FilmVM::ID_INPUT_NAME])) {

            return;
        }
        $format = esc_html($_POST[FilmVM::PRINTER_NAME]);

        $film = $this->filmDBService->findFilmByID(esc_html($_GET[FilmVM::ID_INPUT_NAME]));
        if (!$film) {

            return;
        }

        try {

            $file = $this->filmPrintService->printFilm($format, $film);

            $url = admin_url($file);

            header("Location: $url");
//            unlink(plugin_dir_path(__FILE__).'../../../wp-admin/'.$file);
        } catch (Exception $e) {

            return;
        }


    }

}