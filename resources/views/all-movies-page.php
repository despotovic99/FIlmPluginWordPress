<?php
require_once plugin_dir_path(__FILE__) . '../../ViewModel/MovieList/ListMoviesVM.php';

$movie_list_vm = new ListMoviesVM();
$movie_list_table = $movie_list_vm->get_list_table();

?>

<div class="wrap">

    <h3><?= __('All movies','movie-plugin')?></h3>
    <form method="get">
        <input type="hidden" name="page" value="movie">
        <button class="button-primary" type="submit"><?= __('New movie','movie-plugin')?></button>
    </form>

    <?php $movie_list_table->prepare_items(); ?>
    <form method="get" >
        <p class="search-box">
            <input type="hidden" name="page" value="movies" />
            <?php $movie_list_table->search_box(esc_html(__('Find movie','movie-plugin')), 'search_movie'); ?>
        </p>
    </form>

    <?php
    $movie_list_table->display();
    ?>

</div>