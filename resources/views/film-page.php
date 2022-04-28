<?php
$id_film_input = FilmVM::ID_FILMA_INPUT;
$id_film = '';

$naziv_filma_input = FilmVM::NAZIV_FILMA_INPUT;
$naziv_filma = '';

$opis_filma_input = FilmVM::OPIS_FILMA_INPUT;
$opis_filma = '';

$datum_prikazivanja_input = FilmVM::DATUM_FILMA_INPUT;
$datum_prikazivanja = '';

$duzina_trajanja_input = FilmVM::DUZINA_FILMA_INPUT;
$duzina_trajanja = '';

$uzrast_input = FilmVM::UZRAST_FILM_INPUT;
$uzrast = '';

$zanr_input = FilmVM::ZANR_FILMA_INPUT;
$zanrovi = '';
$zanr = '';
?>

<div class="wrap">

    <div class="sadrzaj-strane">

        <h1>Dodaj novi film</h1>

        <form class="forma">
            <input type="hidden" name='<?= $id_film_input ?>' value="<?= $id_film ?>">

            <div class="forma-left-side">
                <div class="input-div-wrapper">
                    <label>Naziv filma: </label>
                    <input type="text" name="<?= $naziv_filma_input ?>" placeholder="Naziv filma"
                           value="<?= $naziv_filma ?>">
                </div>

                <div class="input-div-wrapper div-opis">
                    <textarea name="<?= $opis_filma_input ?>" placeholder="Opis"><?= $opis_filma ?></textarea>
                </div>
            </div>

            <div class="forma-right-side">
                <div class="input-div-wrapper">
                    <label>Datum prikazivanja: </label>
                    <input type="date" name="<?= $datum_prikazivanja_input ?>" value="<?= $datum_prikazivanja ?>">
                </div>

                <div class="input-div-wrapper">
                    <label>Duzina trajanja filma: </label>
                    <input type="number" name="<? $duzina_trajanja_input ?>" placeholder="Duzina trajanja filma"
                           value="<?= $duzina_trajanja ?>">
                </div>

                <div class="input-div-wrapper">
                    <label>Predvidjeni uzrast za film:</label>
                    <input type="number" name="<?= $uzrast_input ?>" value="<?= $uzrast ?>" placeholder="uzrast">
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
                                if ($z['slug'] === $zanr['slug'])
                                    echo 'checked';
                                ?>
                                   value="<?= $z['slug'] ?>"><?= $z['naziv_zanr'] ?>
                        </div>
                        <?php
                    }
                    ?>

                </div>
            </div>

            <div class="forma-bottom-div">
                <div class="forma-button-wrapper">
                    <button class="button-cancel" type="button">Otkazi</button>
                    <button class="button-primary" type="submit">Sacuvaj</button>
                </div>
            </div>

        </form>
    </div>

</div>
