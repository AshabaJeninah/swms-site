<?php
/**
 * Expects $bins (array of assoc rows: bin_id, location_name, latitude,
 * longitude, current_fill_level, status, last_updated) and $googleMapsApiKey
 * to already be set by the including page.
 */
$mappableBins = array_values(array_filter($bins, static fn ($b) => $b['latitude'] !== null && $b['longitude'] !== null));
$unlocatedBins = array_values(array_filter($bins, static fn ($b) => $b['latitude'] === null || $b['longitude'] === null));

$markerData = array_map(static function ($b) {
    return [
        'id' => (int) $b['bin_id'],
        'name' => $b['location_name'],
        'lat' => (float) $b['latitude'],
        'lng' => (float) $b['longitude'],
        'fill' => (int) $b['current_fill_level'],
        'status' => $b['status'],
        'updated' => $b['last_updated'],
    ];
}, $mappableBins);
?>

<?php if ($googleMapsApiKey === ''): ?>
    <div class="error-message">Map unavailable: no Google Maps API key configured.</div>
<?php elseif (empty($markerData)): ?>
    <div class="error-message">No bins have a location set yet.</div>
<?php else: ?>
    <div id="bin-map" style="height: 480px; border-radius: var(--radius-md); box-shadow: var(--shadow-sm);"></div>
    <script>
        const swmsBins = <?= json_encode($markerData) ?>;

        function initSwmsMap() {
            const center = swmsBins.length
                ? { lat: swmsBins[0].lat, lng: swmsBins[0].lng }
                : { lat: 0.3476, lng: 32.5825 };

            const map = new google.maps.Map(document.getElementById('bin-map'), {
                zoom: 13,
                center,
            });

            const infoWindow = new google.maps.InfoWindow();

            swmsBins.forEach(function (bin) {
                const marker = new google.maps.Marker({
                    position: { lat: bin.lat, lng: bin.lng },
                    map,
                    title: bin.name,
                    icon: {
                        url: 'assets/images/recycle-bin.png',
                        scaledSize: new google.maps.Size(36, 36),
                        anchor: new google.maps.Point(18, 36),
                    },
                });

                marker.addListener('click', function () {
                    infoWindow.setContent(
                        '<strong>' + bin.name + '</strong><br>' +
                        'Status: ' + bin.status + '<br>' +
                        'Fill level: ' + bin.fill + '%<br>' +
                        'Updated: ' + bin.updated
                    );
                    infoWindow.open(map, marker);
                });
            });
        }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=<?= urlencode($googleMapsApiKey) ?>&callback=initSwmsMap" async defer></script>
<?php endif; ?>

<?php if (!empty($unlocatedBins)): ?>
    <p style="margin-top: var(--space-4); color: var(--color-text-muted); font-size: var(--text-sm);">
        <?= count($unlocatedBins) ?> bin(s) have no map location set yet:
        <?= htmlspecialchars(implode(', ', array_column($unlocatedBins, 'location_name'))) ?>
    </p>
<?php endif; ?>
