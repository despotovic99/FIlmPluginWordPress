<?php

$printer_name = MovieVM::PRINTER_NAME;
$action = MovieVM::PRINT_ACTION;
$action_delete = MovieVM::DELETE_ACTION;

$movie_vm = new MovieVM();
$movie = $movie_vm->get_movie();
?>

<div class="wrap">

    <div class="blog-container">

        <div class="blog-body">
            <div class="blog-title">
                <h1><?= $movie['naziv_filma'] ?></h1>
            </div>
            <div class="blog-summary">
                <p>Opis filma: <?= $movie['opis'] ?></p>
            </div>
            <div class="blog-summary">
                <p>Datum prikazivanja: <?= $movie['pocetak_prikazivanja'] ?></p>
            </div>
            <div class="blog-summary">
                <p>Duzina trajanja: <?= $movie['duzina_trajanja'] ?> min</p>
            </div>
            <div class="blog-summary">
                <p>Predvidjeni uzrast: <?= $movie['uzrast'] ?></p>
            </div>
            <div class="blog-summary">
                <p>Zanr: <?= $movie['zanr'] ?></p>
            </div>
            <div class="blog-tags">
                <ul>
                    <li>
                        <form method="get">
                            <input type="hidden" name="page" value="movies">
                            <input type="hidden" name="<?= MovieVM::ID_INPUT_NAME ?>" value="<?= $movie['film_id'] ?>">
                            <button class="btn-izmeni" type="submit">Izmeni</button>
                        </form>
                    </li>
                    <li>
                        <form method="post">
                            <input type="hidden" name="controller_name" value="movie_controller">
                            <input type="hidden" name="action" value="<?= $action_delete ?>">
                            <input type="hidden" name='<?= MovieVM::ID_INPUT_NAME ?>' value="<?= $movie['film_id'] ?>">
                            <button class="btn-obrisi" type="submit">Obrisi</button>
                        </form>
                    </li>
                    <li>
                        <form method="get">
                            <input type="hidden" name="page" value="movies">
                            <button class="btn-izmeni" type="submit">Otkazi</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <div class="blog-footer ">
            <form method="post">
                <div>Odaberi format stampanja:</div>
                <input type="hidden" name="controller_name" value="movie_controller"">
                <input type="hidden" name="action" value="<?= $action ?>">
                <div class="form-printers">
                    <div>
                        <input type="radio" name="<?= $printer_name ?>" value="word">Word
                    </div>
                    <div>
                        <input type="radio" name="<?= $printer_name ?>" value="pdf">PDF
                    </div>
                </div>

                <div class="div-form-print-btn">
                    <button class="btn-izmeni" type="submit">Stampaj</button>
                </div>
            </form>

        </div>

    </div>


