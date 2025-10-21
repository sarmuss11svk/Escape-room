<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json; charset=utf-8');

$host = 'localhost';
$db   = 'escape_room';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES => false,
  PDO::ATTR_STRINGIFY_FETCHES => false
];

// TEMY – musia sedieť s ENUM
$allowed = ['prog','net','db','web','kyb'];
$theme = isset($_GET['theme']) ? strtolower(trim($_GET['theme'])) : '';

try {
  $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
  echo json_encode(['ok'=>false,'error'=>'Chyba pripojenia: '.$e->getMessage()]);
  exit;
}

if (!in_array($theme, $allowed, true)) {
  echo json_encode(['ok'=>false,'error'=>'Nesprávna alebo chýbajúca téma (prog|net|db|web|kyb)']);
  exit;
}

try {
  $stmt = $pdo->prepare("
    SELECT id,theme,text,is_good
    FROM room3_items
    WHERE theme=:t
    ORDER BY RAND()
    LIMIT 1
  ");
  $stmt->execute([':t'=>$theme]);
  $item = $stmt->fetch();

  if (!$item) {
    echo json_encode(['ok'=>false,'error'=>'Žiadny záznam pre túto tému.']);
    exit;
  }

  echo json_encode(['ok'=>true,'item'=>$item], JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
  echo json_encode(['ok'=>false,'error'=>'SQL chyba: '.$e->getMessage()]);
  exit;
}
?>
