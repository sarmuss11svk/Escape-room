<?php
header('Content-Type: application/json; charset=utf-8');

$host = 'localhost';
$db   = 'escape_room';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

try {
  $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
  echo json_encode(['error' => 'Chyba pripojenia: ' . $e->getMessage()]);
  exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!$input || !isset($input['id'])) {
  echo json_encode(['error' => 'Neplatné ID.']);
  exit;
}

$id = intval($input['id']);

try {
  $stmt = $pdo->prepare("DELETE FROM questions WHERE id = ?");
  $stmt->execute([$id]);
  echo json_encode(['success' => true]);
} catch (PDOException $e) {
  echo json_encode(['error' => 'Chyba pri odstraňovaní: ' . $e->getMessage()]);
}
?>
