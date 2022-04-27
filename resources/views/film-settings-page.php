<?php
require_once plugin_dir_path(__FILE__) . '../../ViewModel/Settings/FilmUzrastOption.php';

$controller_name = FilmUzrastOption::CONTROLER_NAME;
$predvidjeniUzrast = FilmUzrastOption::getPredvidjeniUzrast();
$uzrastOptionName = FilmUzrastOption::UZRAST_OPTION_NAME;
?>

<div class="wrap">
    <h1><?= esc_html(get_admin_page_title()) ?></h1>
    <form action="" method="post">

        <input type="hidden" name="controller_name" value="<?= $controller_name ?>">
        <!--        todo ovde bi trebalo da prosledim ime metode-->
        <input type="hidden" name="action" value="save_uzrast_option">

        <p>Predvidjen uzrast za horor filmove</p>
        <input type='text' name='<?= $uzrastOptionName ?>' value='<?= $predvidjeniUzrast ?>'>
        <?php

        submit_button(__('Sacuvaj podesavanja', 'textdomain'));
        ?>
    </form>
</div>
