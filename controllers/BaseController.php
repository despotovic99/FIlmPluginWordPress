<?php
require_once 'SettingsController.php';
require_once 'MovieController.php';

class BaseController {

    private $is_internal = true;

    public function handle_action($action) {

        if ($this->is_internal) {
            $this->validate_method_call();
        }

        if ($action) {
            if (method_exists($this, $action) && is_callable([$this,$action])) {
                $this->$action();
            } else {
                $this->json_response(['error' => 'Method ' . $action . ' not exsist!'], 404);
            }
        }

    }


    protected function validate_method_call() {

        $user = wp_get_current_user();

        if (!$user->ID) {

            exit('Odjebi');
        }

    }

    protected function json_response($data, $status_code) {

        wp_send_json($data,$status_code);
    }

}