<?php
header("Content-Type: application/json; charset=UTF-8");

// 1️⃣ Spojenie s databázou
$conn = new mysqli("localhost", "root", "", "escape_room");

// 2️⃣ Kontrola pripojenia
if ($conn->connect_error) {
    die(json_encode(["error" => "Nepodarilo sa pripojiť k databáze."]));
}

// 3️⃣ Vyber náhodnú otázku z tabuľky 'otazky'
$result = $conn->query("SELECT * FROM otazky ORDER BY RAND() LIMIT 1");

if ($result && $result->num_rows > 0) {
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["error" => "Žiadne otázky v databáze."]);
}

$conn->close();
?>
