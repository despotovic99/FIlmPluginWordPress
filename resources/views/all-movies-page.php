<?php
require_once plugin_dir_path(__FILE__) . '../../ViewModel/MovieList/ListMoviesVM.php';

$movie_list_vm = new ListMoviesVM();
$movie_list_table = $movie_list_vm->get_list_table();

?>

<div class="wrap">

    <h3>Lista filmova</h3>
    <form method="get">
        <input type="hidden" name="page" value="movie">
        <button class="button-primary" type="submit">Novi film</button>
    </form>

    <?php $movie_list_table->prepare_items(); ?>
    <form method="post">
        <p class="search-box">
            <?php $movie_list_table->search_box('Pretrazi filmove', 'search_movie'); ?>
        </p>
    </form>

    <?php
    $movie_list_table->display();
    ?>

</div>