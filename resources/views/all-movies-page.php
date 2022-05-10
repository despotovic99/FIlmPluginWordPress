<?php
require_once plugin_dir_path(__FILE__) . '../../ViewModel/MovieList/ListMoviesVM.php';

$movieListVM = new ListMoviesVM();
$movieListTable = $movieListVM->getListTable();

?>

<div class="wrap">

    <h3>Lista filmova</h3>
    <form method="get">
        <input type="hidden" name="page" value="movies">
        <button class="button-primary" type="submit">Novi film</button>
    </form>

    <?php $movieListTable->prepare_items(); ?>
    <form method="post">
        <p class="search-box">
            <?php $movieListTable->search_box('Pretrazi filmove', 'search_movie'); ?>
        </p>
    </form>

    <?php
    $movieListTable->display();
    ?>

</div>