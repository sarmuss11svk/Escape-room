<?php
// admin-panel.php
?>
<!DOCTYPE html>
<html lang="sk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>[translate: Správca úloh]</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background: radial-gradient(circle at top, #000 0%, #03030a 100%);
      font-family: 'Segoe UI', sans-serif;
      color: #e0e0e0;
      display: flex;
      flex-direction: column;
      align-items: center;
      min-height: 100vh;
    }
    h1 {
      margin-top: 40px;
      text-shadow: 0 0 12px #ffffff55;
    }
    form, table {
      background: rgba(0,0,0,0.6);
      border: 1px solid rgba(255,255,255,0.3);
      border-radius: 14px;
      padding: 25px 30px;
      margin-top: 30px;
      box-shadow: 0 0 20px #ffffff22;
      width: 90%;
      max-width: 900px;
    }
    input, textarea {
      width: 100%;
      margin: 6px 0 12px;
      padding: 8px 12px;
      border-radius: 8px;
      border: 1px solid #555;
      background: #111;
      color: #eee;
      font-size: 1rem;
    }
    button {
      background: #fff;
      color: #000;
      padding: 10px 30px;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.2s ease;
      font-size: 1rem;
    }
    button:hover {
      background: #ccc;
    }
    .status {
      margin-top: 10px;
      font-weight: bold;
      min-height: 24px;
    }
    table {
      border-collapse: collapse;
      width: 100%;
      color: #ddd;
      margin-bottom: 40px;
    }
    th, td {
      padding: 10px;
      border-bottom: 1px solid #353a45;
      text-align: left;
      vertical-align: middle;
    }
    th {
      background: rgba(20,30,50,0.35);
      color: #fff;
    }
    td code {
      background: #252e44;
      padding: 2px 6px;
      border-radius: 6px;
      font-family: monospace;
      white-space: pre-wrap;
    }
    .delete-btn {
      background:#ee3333;
      color:#fff;
      border-radius:8px;
      border:none;
      padding:6px 14px;
      cursor:pointer;
      font-size: 1.1rem;
      line-height: 1;
      height: 30px;
      width: 30px;
      text-align: center;
      font-weight: bold;
    }
    .delete-btn:hover {
      background:#b80000;
    }
  </style>
</head>
<body>
<h1>[translate: Správa úloh]</h1>

<form id="addForm" autocomplete="off">
  <label for="room">[translate: Miestnosť]:</label>
  <input type="number" id="room" name="room" min="1" value="1" required>
  
  <label for="description">[translate: Popis úlohy]:</label>
  <textarea id="description" name="description" rows="2" required></textarea>
  
  <label for="code_snippet">[translate: Kód úlohy (so {{1}}, {{2}}...)]:</label>
  <textarea id="code_snippet" name="code_snippet" rows="4" required></textarea>
  
  <label for="answer">[translate: Správne odpovede (oddelené čiarkou)]:</label>
  <input type="text" id="answer" name="answer" required>
  
  <button type="submit">[translate: 💾 Uložiť úlohu]</button>
  <div id="status" class="status"></div>
</form>

<h2>[translate: Zoznam uložených úloh]</h2>
<table>
  <thead>
    <tr>
      <th>[translate: Miestnosť]</th>
      <th>[translate: Popis]</th>
      <th>[translate: Kód]</th>
      <th>[translate: Odpoveď]</th>
      <th></th>
    </tr>
  </thead>
  <tbody id="tableBody"></tbody>
</table>

<!-- Dôležitý je tento skript v tele -->
<script>
const tableBody = document.getElementById('tableBody');
const statusEl = document.getElementById('status');

// Načíta všetky úlohy a zobrazí ich do tabuľky s "x" pre mazanie
function loadTasks() {
  fetch('get_all_tasks.php')
    .then(r => r.json())
    .then(data => {
      tableBody.innerHTML = '';
      data.forEach(t => {
        const tr = document.createElement('tr');
        tr.innerHTML =
          `<td>${t.room}</td>
           <td>${t.description}</td>
           <td><code>${t.code_snippet}</code></td>
           <td>${Array.isArray(t.answer) ? t.answer.join(', ') : t.answer}</td>
           <td>
             <button class="delete-btn" onclick="deleteTask(${t.id})">x</button>
           </td>`;
        tableBody.appendChild(tr);
      });
    });
}

// Funkcia mazania úlohy podľa ID
function deleteTask(id) {
  if (!confirm('Naozaj chceš úlohu vymazať?')) return;
  fetch('delete_task.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ id })
  })
  .then(r => r.json())
  .then(resp => {
    if (resp.success) {
      loadTasks();
      statusEl.textContent = 'Úloha odstránená ✔️';
      statusEl.style.color = '#66ee99';
    } else {
      alert(resp.error || 'Chyba pri odstraňovaní!');
    }
  });
}

// Pri odoslaní formulára na pridanie úlohy
document.getElementById('addForm').onsubmit = function (e) {
  e.preventDefault();
  const room = document.getElementById('room').value;
  const description = document.getElementById('description').value;
  const code_snippet = document.getElementById('code_snippet').value;
  const answer = document.getElementById('answer').value.split(',').map(x => x.trim()).filter(Boolean);

  fetch('save_task.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ room, description, code_snippet, answer })
  })
  .then(r => r.json())
  .then(resp => {
    if (resp.success) {
      loadTasks();
      statusEl.textContent = 'Úloha uložená ✔️';
      statusEl.style.color = '#66ee99';
      this.reset();
    } else {
      statusEl.textContent = resp.error || 'Chyba pri ukladaní!';
      statusEl.style.color = '#ff6666';
    }
  });
}

// Inicialne načítanie úloh
loadTasks();
</script>

</body>
</html>
