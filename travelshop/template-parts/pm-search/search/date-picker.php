<div class="form-group mb-md-0">
    <label for="">Reisezeitraum</label>
    <div>
        <input type="text"
            class="form-control travelshop-datepicker-input"
            data-type="daterange"
            name="pm-dr"
            autocomplete="off"
            readonly
            placeholder="egal" value="<?php
        if (empty($_GET['pm-dr']) === false) {
            $dr = BuildSearch::extractDaterange($_GET['pm-dr']);
            echo $dr[0]->format('d.m.') . ' - ' . $dr[1]->format('d.m.Y');
        }
        ?>"/>
    </div>
    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x datepicker-clear" width="30" height="30" viewBox="0 0 24 24" stroke-width="1.5" stroke="#2c3e50" fill="none" stroke-linecap="round" stroke-linejoin="round">
        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
        <line x1="18" y1="6" x2="6" y2="18" />
        <line x1="6" y1="6" x2="18" y2="18" />
    </svg>
</div>