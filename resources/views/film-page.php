<?php
$controller_name = FilmVM::CONTROLER_NAME;
$action_save=FilmVM::SAVE_ACTION;
$action_delete=FilmVM::DELETE_ACTION;

$id_film_input = FilmVM::ID_FILMA_INPUT;
$naziv_filma_input = FilmVM::NAZIV_FILMA_INPUT;
$opis_filma_input = FilmVM::OPIS_FILMA_INPUT;
$datum_prikazivanja_input = FilmVM::DATUM_FILMA_INPUT;
$duzina_trajanja_input = FilmVM::DUZINA_FILMA_INPUT;
$uzrast_input = FilmVM::UZRAST_FILM_INPUT;
$zanr_input = FilmVM::ZANR_FILMA_INPUT;

$film = FilmVM::getFilm();
$zanrovi = FilmVM::getZanroviFilm();

?>

<div class="wrap">

    <div class="sadrzaj-strane">

        <h1>Dodaj novi film</h1>
        <div class="buttons-above-form-wraper">
            <div>
                <form method="get">
                    <input type="hidden" name="page" value="filmplugin">
                    <button class=" btn-otkazi" type="submit">Otkazi</button>
                </form>
            </div>

            <div>
                <form  action="<?=admin_url('admin.php?page=filmplugin')?>" method="post">
                    <input type="hidden" name="controller_name" value="<?=$controller_name?>">
                    <input type="hidden" name="action" value="<?=$action_delete?>">
                    <input type="hidden" name='<?= $id_film_input ?>' value="<?= $film['film_id'] ?>">
                    <button class="btn-obrisi"  type="submit">Obrisi</button>
                </form>
            </div>

        </div>

        <form class="forma" method="post">
            <input type="hidden" name="controller_name" value="<?=$controller_name?>">
            <input type="hidden" name="action" value="<?=$action_save?>">

            <input type="hidden" name='<?= $id_film_input ?>' value="<?= $film['film_id'] ?>">
            <div class="forma-left-side">
                <div class="input-div-wrapper">
                    <label>Naziv filma: </label>
                    <input type="text" name="<?= $naziv_filma_input ?>" placeholder="Naziv filma"
                           value="<?= $film['naziv_filma'] ?>">
                </div>

                <div class="input-div-wrapper div-opis">
                    <textarea name="<?= $opis_filma_input ?>" placeholder="Opis"><?= $film['opis'] ?></textarea>
                </div>
            </div>

            <div class="forma-right-side">
                <div class="input-div-wrapper">
                    <label>Datum prikazivanja: </label>
                    <input type="date" name="<?= $datum_prikazivanja_input ?>" value="<?= $film['pocetak_prikazivanja'] ?>">
                </div>

                <div class="input-div-wrapper">
                    <label>Duzina trajanja filma: </label>
                    <input type="number" name="<?=$duzina_trajanja_input ?>" placeholder="Duzina trajanja filma"
                           value="<?= $film['duzina_trajanja'] ?>">
                </div>

                <div class="input-div-wrapper">
                    <label>Predvidjeni uzrast za film:</label>
                    <input type="number" name="<?= $uzrast_input ?>" value="<?= $film['uzrast'] ?>" placeholder="uzrast">
                </div>

                <div class="input-div-wrapper">
                    <label>
                        Zanr filma:
                    </label>
                    <?php
                    foreach ($zanrovi as $z) { ?>
                        <div>
                            <input type="radio" name="<?=$zanr_input?>"
                                <?php
                                if ($z['id'] === $film['id_zanra'])
                                    echo 'checked';
                                ?>
                                   value="<?= $z['id'] ?>"/> <?= $z['naziv_zanr'] ?>
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
