<?php
require_once plugin_dir_path(__FILE__) . '../util/Database.php';

class Update {

    private function is_plugin_initialized() {

        $installer = new Database();
        return $installer->is_plugin_initialized();
    }

    private function initialize_plugin() {

        $installer = new Database();
        $installer->install();
        $this->create_dirs();
    }

    public function init_or_update_plugin() {

        if (!$this->is_plugin_initialized()) {

            $this->initialize_plugin();
        }
    }

    private function create_dirs() {
        $path = FILES_DIR;
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
    }
}