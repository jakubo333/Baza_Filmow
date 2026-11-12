<?php
require 'backend/config/config.php';

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login'] ?? '');
    $haslo = $_POST['haslo'] ?? '';

    $stmt = $pdo->prepare('SELECT * FROM uzytkownicy WHERE login = ?');
    $stmt->execute([$login]);
    $user = $stmt->fetch();

    // Weryfikacja hasha
    if ($user && password_verify($haslo, $user['haslo'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['login'] = $user['login'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Nieprawidłowy login lub hasło.";
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head><meta charset="UTF-8"><title>Logowanie</title><link rel="stylesheet" href="frontend/css/style.css"></head>
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
            <h2>Zaloguj się</h2>
            <?php if (isset($_GET['registered'])) echo "<p class='success-msg' style='color:#2ed573; padding:10px;'>Konto założone! Możesz się zalogować.</p>"; ?>
            <?php if (!empty($error)) echo "<p class='error-msg'>$error</p>"; ?>
            
            <form method="post" class="add-movie-form">
                <label>Login</label>
                <input type="text" name="login" required>
                <label>Hasło</label>
                <input type="password" name="haslo" required>
                <button type="submit" class="btn btn-add-submit">Zaloguj</button>
            </form>
            <p style="text-align:center; margin-top:20px;">Nie masz konta? <a href="rejestracja.php" style="color:var(--accent);">Zarejestruj się</a></p>
        </div>
    </main>
</body>
</html>