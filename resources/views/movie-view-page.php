<?php

$movie_vm = new MovieVM();
$movie = $movie_vm->get_movie();
?>

<div class="wrap">

    <div class="blog-container">

        <div class="blog-body">
            <div class="blog-title">
                <h1><?= $movie['movie_name'] ?></h1>
            </div>
            <div class="blog-summary">
                <p>Opis filma: <?= $movie['movie_description'] ?></p>
            </div>
            <div class="blog-summary">
                <p>Datum prikazivanja: <?= $movie['movie_date'] ?></p>
            </div>
            <div class="blog-summary">
                <p>Duzina trajanja: <?= $movie['movie_length'] ?> min</p>
            </div>
            <div class="blog-summary">
                <p>Predvidjeni uzrast: <?= $movie['movie_age'] ?></p>
            </div>
            <div class="blog-summary">
                <p>Zanr: <?= $movie['movie_category_name'] ?></p>
            </div>
            <div class="blog-tags">
                <ul>
                    <li>
                        <form method="get">
                            <input type="hidden" name="page" value="movie">
                            <input type="hidden" name="movie_id" value="<?= $movie['movie_id'] ?>">
                            <button class="btn-update" type="submit">Izmeni</button>
                        </form>
                    </li>
                    <li>
                        <form method="post">
                            <input type="hidden" name="controller_name" value="Movie">
                            <input type="hidden" name="action" value="delete_movie">
                            <input type="hidden" name='movie_id' value="<?= $movie['movie_id'] ?>">
                            <button class="btn-delete" type="submit">Obrisi</button>
                        </form>
                    </li>
                    <li>
                        <form method="get">
                            <input type="hidden" name="page" value="movies">
                            <button class="btn-update" type="submit">Otkazi</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <div class="blog-footer ">
            <form method="post">
                <div>Odaberi format stampanja:</div>
                <input type="hidden" name="controller_name" value="Movie"">
                <input type="hidden" name="action" value="print_movie">
                <input type="hidden" name="movie_id" value="<?=$movie['movie_id']?>">
                <div class="form-printers">
                    <div>
                        <input type="radio" name="printer" value="word">Word
                    </div>
                    <div>
                        <input type="radio" name="printer" value="pdf">PDF
                    </div>
                </div>

                <div class="div-form-print-btn">
                    <button class="btn-update" type="submit">Stampaj</button>
                </div>
            </form>

        </div>

    </div>


