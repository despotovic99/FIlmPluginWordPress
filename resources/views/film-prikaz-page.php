<?php
$controller_name = FilmVM::CONTROLER_NAME;
$printer_name = FilmVM::PRINTER_NAME;
$action = FilmVM::PRINT_ACTION;

$film = FilmVM::getFilm();
?>

<div class="wrap">

    <div class="sadrzaj-strane">

        <div class="div-naslov-action-wrapper">
            <div class="div-naslov">
                <h1><?= $film['naziv_filma'] ?></h1>
            </div>
            <div class="div-naslov-action">
                <a class="button-secondary" href="?page=filmpage&<?= FilmVM::ID_INPUT_NAME ?>=<?= $film['film_id'] ?>">Izmeni</a>
            </div>
        </div>

        <div class="div-sadrzaj">

            <div class="div-film-sadrzaj">
                <p>Opis filma: </p>
                <p><?= $film['opis'] ?></p>
            </div>

            <div class="div-film-sadrzaj">
                <p>Datum prikazivanja: <?= $film['pocetak_prikazivanja'] ?></p>
            </div>

            <div class="div-film-sadrzaj">
                <p>Duzina trajanja: <?= $film['duzina_trajanja'] ?> min</p>
            </div>

            <div class="div-film-sadrzaj">
                <p>Predvidjeni uzrast: <?= $film['uzrast'] ?></p>
            </div>

            <div class="div-film-sadrzaj">
                <p>Zanr: <?= $film['zanr'] ?></p>
            </div>

        </div>

        <div class="div-print-wrapper">

            <form method="post">
                <p>Odaberi format stampanja: </p>
                <input type="hidden" name="controller_name" value="<?= $controller_name ?>">
                <input type="hidden" name="action" value="<?= $action ?>">
                <div class="form-printers">
                    <div>
                        <input type="radio" name="<?= $printer_name ?>" value="word">Word
                    </div>
                    <div>
                        <input type="radio" name="<?= $printer_name ?>" value="pdf">PDF
                    </div>
                </div>

                <div>
                    <button type="submit">Stampaj</button>
                </div>
            </form>

        </div>

    </div>

</div>
