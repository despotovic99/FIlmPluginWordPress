<?php
$controller_name = FilmVM::CONTROLER_NAME;
$printer_name = FilmVM::PRINTER_NAME;
$action = FilmVM::PRINT_ACTION;
$action_delete = FilmVM::DELETE_ACTION;

$filmVM = new FilmVM();
$film = $filmVM->getFilm();
?>

<div class="wrap">

    <div class="blog-container">

        <div class="blog-body">
            <div class="blog-title">
                <h1><?= $film['naziv_filma'] ?></h1>
            </div>
            <div class="blog-summary">
                <p>Opis filma: <?= $film['opis'] ?></p>
            </div>
            <div class="blog-summary">
                <p>Datum prikazivanja: <?= $film['pocetak_prikazivanja'] ?></p>
            </div>
            <div class="blog-summary">
                <p>Duzina trajanja: <?= $film['duzina_trajanja'] ?> min</p>
            </div>
            <div class="blog-summary">
                <p>Predvidjeni uzrast: <?= $film['uzrast'] ?></p>
            </div>
            <div class="blog-summary">
                <p>Zanr: <?= $film['zanr'] ?></p>
            </div>
            <div class="blog-tags">
                <ul>
                    <li>
                        <form method="get">
                            <input type="hidden" name="page" value="filmpage">
                            <input type="hidden" name="<?= FilmVM::ID_INPUT_NAME ?>" value="<?= $film['film_id'] ?>">
                            <button class="btn-izmeni" type="submit">Izmeni</button>
                        </form>
                    </li>
                    <li>
                        <form method="post">
                            <input type="hidden" name="controller_name" value="<?= $controller_name ?>">
                            <input type="hidden" name="action" value="<?= $action_delete ?>">
                            <input type="hidden" name='<?= FilmVM::ID_INPUT_NAME ?>' value="<?= $film['film_id'] ?>">
                            <button class="btn-obrisi" type="submit">Obrisi</button>
                        </form>
                    </li>
                    <li>
                        <form method="get">
                            <input type="hidden" name="page" value="filmplugin">
                            <button class="btn-izmeni" type="submit">Otkazi</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>

        <div class="blog-footer ">
            <form method="post">
                <div>Odaberi format stampanja:</div>
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

                <div class="div-form-print-btn">
                    <button class="btn-izmeni" type="submit">Stampaj</button>
                </div>
            </form>

        </div>

    </div>


