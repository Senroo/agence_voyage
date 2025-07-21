<?php

/** Racine projet */
define('ROOT_PATH', dirname(__DIR__));
/** Racine projet */

/** Constante pour la connexion PDO */
define('HOST', 'localhost');
define('DBNAME', 'agence_voyage');
define('CHARSET', 'utf8');
define('USER', 'root');
define('PASSWORD', '');
/** Constante pour la connexion PDO */

/** Autoload des classes dans /classes */
spl_autoload_register(function ($class) {
    $file = ROOT_PATH . '/classes/' . $class . '.php';
    if (file_exists($file)) {
        include_once $file;
    } else {
        http_response_code(500);
        echo json_encode(['error' => "Classe introuvable : $class"]);
        exit;
    }
});
/** Autoload des classes dans /classes */