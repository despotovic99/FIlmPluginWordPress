<?php
require_once plugin_dir_path(__FILE__) . '../../ViewModel/FilmList/ListAllFilmsVM.php';

$searchbox_id = ListAllFilmsVM::SEARCHBOX_ID;

$filmListVM = new ListAllFilmsVM();
$filmListTable = $filmListVM->getListTable();

?>

<div class="wrap">


    <h3>Lista filmova</h3>
    <form method="get">
        <input type="hidden" name="page" value="filmpage">
        <button class="button-primary" type="submit">Novi film</button>
    </form>

    <?php $filmListTable->prepare_items(); ?>
    <form method="post">

        <p class="search-box">
            <?php $filmListTable->search_box('Pretrazi filmove', $searchbox_id); ?>
        </p>
    </form>

    <?php
    $filmListTable->display();
    ?>

</div>