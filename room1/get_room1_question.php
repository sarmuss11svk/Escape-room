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

$room = 1; // číslo miestnosti
$stmt = $pdo->prepare("SELECT description, code_snippet, answer FROM questions WHERE room = ? ORDER BY RAND() LIMIT 1");
$stmt->execute([$room]);

$question = $stmt->fetch();

if ($question) {
  echo json_encode($question);
} else {
  echo json_encode(['error' => 'Žiadna otázka nebola nájdená.']);
}
?>
