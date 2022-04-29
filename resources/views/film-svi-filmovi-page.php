<?php
require_once plugin_dir_path(__FILE__) . '../../ViewModel/FilmList/ListAllFilmsVM.php';

$filmListTable = ListAllFilmsVM::getListTable();
$searchbox_id = ListAllFilmsVM::SEARCHBOX_ID;
$controller_name = ListAllFilmsVM::CONTROLER_NAME;
$pretraga_filmova = ListAllFilmsVM::PRETRAGA_FILMOVA;
?>

<div class="wrap">


    <h3>Lista filmova</h3>
    <form method="get">
        <input type="hidden" name="page" value="filmpage">
        <button class="button-primary" type="submit">Novi film</button>
    </form>

    <?php $filmListTable->prepare_items(); ?>
    <form method="post">
        <input type="hidden" name="controller_name" value="<?= $controller_name ?>">
        <input type="hidden" name="action" value="<?= $pretraga_filmova ?>"

        <p class="search-box">
            <?php $filmListTable->search_box('Pretrazi filmove', $searchbox_id); ?>
        </p>
    </form>

    <?php
    $filmListTable->display();
    ?>

</div>