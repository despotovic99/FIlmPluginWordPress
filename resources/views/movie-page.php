<?php

$movie_vm = new MovieVM();
$movie = $movie_vm->get_movie();
$movie_categories = $movie_vm->get_movie_categories();

?>

<div class="wrap">

    <div class="content">

        <h1>Dodaj novi film</h1>
        <div class="buttons-above-form-wraper">
            <div>
                <form method="get">
                    <input type="hidden" name="page" value="movies">
                    <button class=" btn-cancel" type="submit">Otkazi</button>
                </form>
            </div>

            <div>
                <form method="post">
                    <input type="hidden" name="controller_name" value="Movie">
                    <input type="hidden" name="action" value="delete_movie">
                    <input type="hidden" name='movie_id' value="<?= $movie['movie_id'] ?>">
                    <button class="btn-delete" type="submit">Obrisi</button>
                </form>
            </div>

        </div>

        <form class="form" method="post">
            <input type="hidden" name="controller_name" value="Movie">
            <input type="hidden" name="action" value="save_movie">

            <input type="hidden" name='movie_id' value="<?= $movie['movie_id'] ?>">
            <div class="form-left-side">
                <div class="input-div-wrapper">
                    <label>Naziv filma: </label>
                    <input type="text" name="movie_name" placeholder="Naziv filma"
                           value="<?= $movie['movie_name'] ?>">
                </div>

                <div class="input-div-wrapper div-opis">
                    <textarea name="movie_description" placeholder="Opis"><?= $movie['movie_description'] ?></textarea>
                </div>
            </div>

            <div class="form-right-side">
                <div class="input-div-wrapper">
                    <label>Datum prikazivanja: </label>
                    <input type="date" name="movie_date" value="<?= $movie['movie_date'] ?>">
                </div>

                <div class="input-div-wrapper">
                    <label>Duzina trajanja filma: </label>
                    <input type="number" name="movie_length" placeholder="Duzina trajanja filma"
                           value="<?= $movie['movie_length'] ?>">
                </div

                <div class="input-div-wrapper">
                    <label>Predvidjeni uzrast za film:</label>
                    <input type="number" name="movie_age" value="<?= $movie['movie_age'] ?>" placeholder="uzrast">
                </div>

                <div class="input-div-wrapper">
                    <label>
                        Zanr filma:
                    </label>
                    <?php
                    foreach ($movie_categories as $category) { ?>
                        <div>
                            <input type="radio" name="movie_category_id"
                                <?php
                                if ($category['id'] === $movie['movie_category_id'])
                                    echo 'checked';
                                ?>
                                   value="<?= $category['id'] ?>"/> <?= $category['movie_category_name'] ?>
                        </div>
                        <?php
                    }
                    ?>

                </div>

                <div class="form-bottom-div">
                    <div class="form-button-wrapper">
                        <button class="button-primary" type="submit">Sacuvaj</button>
                    </div>
                </div>

        </form>
    </div>

</div>

</div>
