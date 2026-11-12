<?php
require 'backend/config/config.php';

// Zabezpieczenie strony przed niezalogowanymi użytkownikami
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tytul = trim($_POST['tytul'] ?? ''); $rok = (int)($_POST['rok'] ?? 0);
    $gatunek = trim($_POST['gatunek'] ?? ''); $opis = trim($_POST['opis'] ?? '');
    if (!empty($tytul) && $rok > 1800 && !empty($gatunek)) {
        $stmt = $pdo->prepare('INSERT INTO filmy (tytul, rok, gatunek, opis) VALUES (?, ?, ?, ?)');
        $stmt->execute([$tytul, $rok, $gatunek, $opis]);
        header("Location: index.php"); exit;
    } else { $error = "Wypełnij poprawnie wszystkie pola."; }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head><meta charset="UTF-8"><title>Dodaj nowy film</title><link rel="stylesheet" href="frontend/css/style.css"></head>
<body>

    <header>
        <div class="header-container">
            <a href="index.php" class="logo">Baza<span>Filmów</span></a>
            <form class="search-form" method="GET" action="index.php">
                <input type="text" name="search" placeholder="Szukaj po tytule..." value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                <button type="submit">Szukaj</button>
            </form>
            <div class="user-panel">
                <?php if(isset($_SESSION['user_id'])): ?>
                    <span style="color:#FFF; margin-right:15px; font-weight:bold;">Witaj, <?= htmlspecialchars($_SESSION['login']) ?>!</span>
                    <a href="dodaj_film.php" class="btn btn-add">+ Dodaj film</a>
                    <a href="login.php?logout=1" class="btn" style="background:#444; color:#fff;">Wyloguj</a>
                <?php else: ?>
                    <a href="login.php" class="btn">Zaloguj</a>
                    <a href="rejestracja.php" class="btn btn-add">Zarejestruj</a>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="single-view">
        <div class="form-container">
            <h2>Dodaj nowy film do bazy</h2>
            <?php if (!empty($error)) echo "<p class='error-msg'>$error</p>"; ?>
            <form method="post" class="add-movie-form">
                <label>Tytuł filmu *</label><input type="text" name="tytul" required>
                <div class="form-row">
                    <div style="flex:1;"><label>Rok produkcji *</label><input type="number" name="rok" min="1800" max="2100" required></div>
                    <div style="flex:1;"><label>Gatunek *</label><input type="text" name="gatunek" required></div>
                </div>
                <label>Opis / Zarys fabuły</label><textarea name="opis" rows="6"></textarea>
                <button type="submit" class="btn btn-add-submit">Dodaj film do bazy</button>
            </form>
        </div>
    </main>
</body>
</html>