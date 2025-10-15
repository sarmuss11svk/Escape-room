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
if (!$input) {
  echo json_encode(['error' => 'Neplatný JSON.']);
  exit;
}

$room = intval($input['room']);
$desc = trim($input['description']);
$code = trim($input['code_snippet']);
$answer = json_encode($input['answer']); // uložíme ako JSON string

if (!$room || !$desc || !$code || !$answer) {
  echo json_encode(['error' => 'Vyplň všetky polia.']);
  exit;
}

try {
  $stmt = $pdo->prepare("INSERT INTO questions (room, description, code_snippet, answer) VALUES (?, ?, ?, ?)");
  $stmt->execute([$room, $desc, $code, $answer]);
  echo json_encode(['success' => true]);
} catch (PDOException $e) {
  echo json_encode(['error' => 'Chyba pri ukladaní: ' . $e->getMessage()]);
}
?>
