<?php
require 'backend/config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $haslo = $_POST['haslo'] ?? '';

    if (!empty($login) && !empty($haslo)) {
        // HASHOWANIE HASŁA!
        $hash = password_hash($haslo, PASSWORD_DEFAULT);
        try {
            $stmt = $pdo->prepare('INSERT INTO uzytkownicy (login, haslo) VALUES (?, ?)');
            $stmt->execute([$login, $hash]);
            header("Location: login.php?registered=1");
            exit;
        } catch (PDOException $e) {
            $error = "Ten login jest już zajęty!";
        }
    } else {
        $error = "Wypełnij wszystkie pola.";
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head><meta charset="UTF-8"><title>Rejestracja</title><link rel="stylesheet" href="frontend/css/style.css"></head>
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
            <h2>Utwórz konto</h2>
            <?php if (!empty($error)) echo "<p class='error-msg'>$error</p>"; ?>
            
            <form method="post" class="add-movie-form">
                <label>Wybierz Login</label>
                <input type="text" name="login" required>
                <label>Wybierz Hasło</label>
                <input type="password" name="haslo" required>
                <button type="submit" class="btn btn-add-submit" style="background:#007bff;">Zarejestruj się</button>
            </form>
        </div>
    </main>
</body>
</html>