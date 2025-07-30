<?php

// ✅ Autoload Composer (si tu utilises des libs via composer.json)
require_once __DIR__ . '/vendor/autoload.php';

// ✅ Charger manuellement les métadonnées Swagger si nécessaire
require_once __DIR__ . '/api/swagger/swagger-info.php';

// ✅ Dossiers à scanner
$dirs = [
    __DIR__ . '/api',
    __DIR__ . '/classes',
];

// ✅ Charger récursivement tous les fichiers PHP dans les dossiers
foreach ($dirs as $directory) {
    if (!is_dir($directory)) continue;

    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS)
    );

    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            require_once $file->getPathname();
            // ✅ Affichage lisible même sous Windows
            echo 'Chargement : ' . str_replace('\\', '/', $file->getPathname()) . PHP_EOL;
        }
    }
}
