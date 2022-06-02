<?php

class Update {

    private function is_plugin_initialized() {

        return BaseRepository::get_base_repository()->is_plugin_initialized();

    }

    private function initialize_plugin() {

        BaseRepository::get_base_repository()->initialize_movie_plugin_tables();
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