<?php
require('_config.php');

try {
    $cnx = new PDO(
        'mysql:host=' . HOST . ';dbname=' . DBNAME . ';charset=' . CHARSET,
        USER,
        PASSWORD,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        "error" => "Erreur de connexion à la base de données.",
        "detail" => $e->getMessage() // ⚠️ À désactiver en prod
    ]);
    exit;
}
