<div class="wrap">
    <?php
    foreach ($zanrovi as $zanr) { ?>
        <input type="radio" name="film_zanr" value="<?= $zanr->slug ?>"
        <?php
        if ($zanr->slug === $zanrMeta) {
            echo "checked";
        }
        ?>
        ><?= $zanr->naziv_zanr ?>
    <?php } ?>
</div>
