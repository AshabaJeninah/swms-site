<?php

require_once __DIR__ . '/database.php';

$googleMapsApiKey = getenv('GOOGLE_MAPS_API_KEY') ?: '';
