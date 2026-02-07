<?php
// Database config
$DB_HOST    = "localhost";
$DB_NAME    = "atjnuaqu_opay";
$DB_USER    = "atjnuaqu_opay";
$DB_PASS    = "Maxwell198$";
$DB_CHARSET = "utf8mb4";

// Initialize all variables
$pdo    = null;
$mysqli = null;
$conn   = null;
$DB_DRIVER = null;

// 1. Try PDO (recommended)
try {
    $dsn  = "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=$DB_CHARSET";
    $pdo  = new PDO($dsn, $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
    $conn = $pdo;
    $DB_DRIVER = "pdo";
} catch (Exception $e) {
    $pdo = null;
}

// 2. Fallback to MySQLi if PDO failed
if (!$pdo) {
    $mysqli = @new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);
    if ($mysqli->connect_errno) {
        echo json_encode([
            "status"  => false,
            "message" => "Database connection failed: " . $mysqli->connect_error
        ]);
        exit;
    }
    $mysqli->set_charset($DB_CHARSET);
    $conn = $mysqli;
    $DB_DRIVER = "mysqli";
}
?>