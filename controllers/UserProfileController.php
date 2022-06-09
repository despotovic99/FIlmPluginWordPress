<?php
require_once plugin_dir_path(__FILE__) . '../services/UserProfileService.php';

class UserProfileController {

    public function __construct() {

        $this->user_profile_service = new UserProfileService();
    }

    public function update_user_meta_data($user_id) {

        $value = 0;
        if (!empty($_REQUEST['can_user_print_input'])) {

            $value = sanitize_text_field(wp_unslash($_REQUEST['can_user_print_input']));
        }


        $result = $this->user_profile_service->set_user_print_option($user_id, $value);

        return $result;
    }

}