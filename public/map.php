<?php
require_once __DIR__ . '/config/app.php';

$bins = $conn->query('SELECT bin_id, location_name, latitude, longitude, current_fill_level, status, last_updated FROM bins ORDER BY location_name')->fetch_all(MYSQLI_ASSOC);

$pageTitle = 'Bin Map - SWMS';
include __DIR__ . '/includes/header.php';
?>

<div class="app-shell">
    <h2 class="page-heading">Bin Locations</h2>
    <p class="page-subheading">Live fill status for every bin in the network. Green = OK, Yellow = Warning, Red = Critical.</p>

    <?php include __DIR__ . '/includes/bin_map.php'; ?>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
