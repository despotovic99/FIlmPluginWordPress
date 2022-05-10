<?php

$movie_vm = new MovieVM();
$movie = $movie_vm->get_movie();
$movie_categories = $movie_vm->get_movie_categories();

?>

<div class="wrap">

    <div class="sadrzaj-strane">

        <h1>Dodaj novi film</h1>
        <div class="buttons-above-form-wraper">
            <div>
                <form method="get">
                    <input type="hidden" name="page" value="movies">
                    <button class=" btn-otkazi" type="submit">Otkazi</button>
                </form>
            </div>

            <div>
                <form  method="post">
                    <input type="hidden" name="controller_name" value="movie_controller">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name='movie_id' value="<?= $movie['movie_id'] ?>">
                    <button class="btn-obrisi"  type="submit">Obrisi</button>
                </form>
            </div>

        </div>

        <form class="forma" method="post">
            <input type="hidden" name="controller_name" value="movie_controller">
            <input type="hidden" name="action" value="save">

            <input type="hidden" name='movie_id' value="<?= $movie['movie_id'] ?>">
            <div class="forma-left-side">
                <div class="input-div-wrapper">
                    <label>Naziv filma: </label>
                    <input type="text" name="movie_name" placeholder="Naziv filma"
                           value="<?= $movie['movie_name'] ?>">
                </div>

                <div class="input-div-wrapper div-opis">
                    <textarea name="movie_description" placeholder="Opis"><?= $movie['movie_description'] ?></textarea>
                </div>
            </div>

            <div class="forma-right-side">
                <div class="input-div-wrapper">
                    <label>Datum prikazivanja: </label>
                    <input type="date" name="movie_date" value="<?= $movie['pocetak_prikazivanja'] ?>">
                </div>

                <div class="input-div-wrapper">
                    <label>Duzina trajanja filma: </label>
                    <input type="number" name="movie_length" placeholder="Duzina trajanja filma"
                           value="<?= $movie['movie_lenght'] ?>">
                </div>

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
                            <input type="radio" name="movie_category"
                                <?php
                                if ($category['id'] === $movie['movie_category_id'])
                                    echo 'checked';
                                ?>
                                   value="<?= $category['id'] ?>"/> <?= $category['category_name'] ?>
                        </div>
                        <?php
                    }
                    ?>

                </div>
            </div>

            <div class="forma-bottom-div">
                <div class="forma-button-wrapper">
                    <button class="button-primary" type="submit">Sacuvaj</button>
                </div>
            </div>
        </form>
    </div>

</div>
