CREATE DATABASE IF NOT EXISTS escape_room CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE escape_room;

CREATE TABLE IF NOT EXISTS questions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  room INT NOT NULL,
  description TEXT NOT NULL,
  code_snippet TEXT NOT NULL,
  answer TEXT NOT NULL
);

INSERT INTO questions (room, description, code_snippet, answer) VALUES 
(1,
 'Doplň kód, aby sa vypísalo: "Elektrobicykel jazdí do vzdialenosti 60 km!"',
 'class Bicykel {
    void jazdit() {
      System.out.println("Bicykel jazdí!");
    }
  }
  class Elektrobicykel extends Bicykel {
    void jazdit() {
      System.out.println("Elektrobicykel jazdí do vzdialenosti 60 km!");
    }
  }
  public static void main(String args[]) {
    {{1}} bicykel = new {{2}}();
    bicykel.{{3}}();
  }',
 '["Bicykel","Elektrobicykel","jazdit"]'),

(1,
 'Doplň kód, aby sa vypísalo: "Loď Voyager dosiahla planétu Mars!"',
 'class VesmirnaLod {
    void pristat() {
      System.out.println("Loď Voyager dosiahla planétu Mars!");
    }
  }
  public static void main(String[] args) {
    {{1}} lod = new {{2}}();
    lod.{{3}}();
  }',
 '["VesmirnaLod","VesmirnaLod","pristat"]'
);
