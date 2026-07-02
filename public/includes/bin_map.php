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
    <div id="bin-map" style="height: 480px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1);"></div>
    <script>
        const swmsBins = <?= json_encode($markerData) ?>;

        function swmsBinColor(status) {
            if (status === 'Critical') return '#e74c3c';
            if (status === 'Warning') return '#f1c40f';
            return '#2ecc71';
        }

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
                        path: google.maps.SymbolPath.CIRCLE,
                        fillColor: swmsBinColor(bin.status),
                        fillOpacity: 1,
                        strokeColor: '#ffffff',
                        strokeWeight: 2,
                        scale: 10,
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
    <p style="margin-top: 15px; color: #7f8c8d; font-size: 0.9em;">
        <?= count($unlocatedBins) ?> bin(s) have no map location set yet:
        <?= htmlspecialchars(implode(', ', array_column($unlocatedBins, 'location_name'))) ?>
    </p>
<?php endif; ?>
