<?php
require_once plugin_dir_path(__FILE__) . '../../ViewModel/Settings/MovieSettingsVM.php';

$movie_settings_vm = new MovieSettingsVM();
$age = $movie_settings_vm->get_age();
?>

<div class="wrap">
    <h1><?= esc_html(get_admin_page_title()) ?></h1>
    <form action="" method="post">

        <input type="hidden" name="controller_name" value="settings_controller">
        <input type="hidden" name="action" value="save_age_option">

        <p>Predvidjen uzrast za horor filmove</p>
        <input type='text' name='horror_movie_min_age_option' value='<?= $age ?>'>
        <?php

        submit_button(__('Sacuvaj podesavanja', 'textdomain'));
        ?>
    </form>
</div>
