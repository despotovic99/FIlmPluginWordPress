<?php
require_once plugin_dir_path(__FILE__).'../../ViewModel/Settings/FilmUzrastOption.php';


$predvidjeniUzrast = FilmUzrastOption::getPredvidjeniUzrast();
$uzrastOptionName = FilmUzrastOption::UZRAST_OPTION_NAME;
?>

    <div class="wrap">
    <h1><?= esc_html(get_admin_page_title()) ?></h1>
    <form action="" method="post">

        <p>Predvidjeni uzrasti za filmove</p>
        <input type='text' name='<?=$uzrastOptionName?>' value='<?= $predvidjeniUzrast ?>' >
        <?php

        submit_button(__('Sacuvaj podesavanja', 'textdomain'));
        ?>
    </form>
</div>
