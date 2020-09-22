<div class="form-group mb-md-0">
    <label for="">Reisezeitraum</label>
    <input type="text"
           class="form-control"
           data-type="daterange"
           name="pm-dr"
           autocomplete="off"
           placeholder="egal" value="<?php
    if (empty($_GET['pm-dr']) === false) {
        $dr = BuildSearch::extractDaterange($_GET['pm-dr']);
        echo $dr[0]->format('d.m.') . ' - ' . $dr[1]->format('d.m.Y');
    }
    ?>"/>
</div>