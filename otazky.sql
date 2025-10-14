CREATE DATABASE IF NOT EXISTS escape_room CHARACTER SET utf8mb4 COLLATE utf8mb4_slovak_ci;
USE escape_room;

CREATE TABLE IF NOT EXISTS otazky (
    id INT AUTO_INCREMENT PRIMARY KEY,
    predmet VARCHAR(100) NOT NULL,
    otazka TEXT NOT NULL,
    odpoved_a VARCHAR(255) NOT NULL,
    odpoved_b VARCHAR(255) NOT NULL,
    odpoved_c VARCHAR(255) NOT NULL,
    spravna_odpoved CHAR(1) NOT NULL
);

INSERT INTO otazky (predmet, otazka, odpoved_a, odpoved_b, odpoved_c, spravna_odpoved) VALUES
('Matematika', 'Koľko je 8 × 7?', '54', '56', '64', 'B'),
('Fyzika', 'Ktorá veličina sa meria v jednotkách "N"?', 'Sila', 'Tlak', 'Výkon', 'A'),
('Informatika', 'Čo znamená skratka HTML?', 'HyperText Markup Language', 'HighTech Machine Logic', 'Hyper Transfer Mail Link', 'A');
