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

try {
  $stmt = $pdo->query("SELECT * FROM questions ORDER BY room ASC, id ASC");
  $tasks = $stmt->fetchAll();

  foreach ($tasks as &$t) {
    if (isset($t['answer'])) {
      $t['answer'] = json_decode($t['answer']);
    }
  }

  echo json_encode($tasks);
} catch (PDOException $e) {
  echo json_encode(['error' => 'Chyba pri načítaní úloh: '.$e->getMessage()]);
}
?>
