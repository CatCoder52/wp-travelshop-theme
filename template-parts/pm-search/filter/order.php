<div class="list-filter-box list-filter-box-checkboxes list-filter-box-sorting">
    <div class="list-filter-box-title">
        <strong>Sortieren nach</strong>
    </div>

    <div class="list-filter-box-body">
        <select class="form-control mb-0" name="pm-o">
            <option value="">Sortieren nach</option>
            <option value="date_departure-asc"<?php echo (!empty($_GET['pm-o']) && $_GET['pm-o'] == 'date_departure-asc') ? ' selected' : '';?>>Datum aufsteigend</option>
            <option value="date_departure-desc"<?php echo (!empty($_GET['pm-o']) && $_GET['pm-o'] == 'date_departure-desc') ? ' selected' : '';?>>Datum absteigend</option>
            <option value="price-asc"<?php echo (!empty($_GET['pm-o']) && $_GET['pm-o'] == 'price-asc') ? ' selected' : '';?>>Preis aufsteigend</option>
            <option value="price-desc"<?php echo (!empty($_GET['pm-o']) && $_GET['pm-o'] == 'price-desc') ? ' selected' : '';?>>Preis absteigend</option>
        </select>
    </div>

</div>