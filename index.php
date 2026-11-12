<?php
require 'backend/config/config.php';
$search = trim($_GET['search'] ?? '');
if ($search !== '') {
    $stmt = $pdo->prepare('SELECT id, tytul, rok, gatunek FROM filmy WHERE tytul LIKE ? ORDER BY rok DESC');
    $stmt->execute(['%' . $search . '%']);
} else {
    $stmt = $pdo->query('SELECT id, tytul, rok, gatunek FROM filmy ORDER BY rok DESC');
}
$filmy = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Baza Filmów - Twój Portal Filmowy</title>
    <link rel="stylesheet" href="frontend/css/style.css">
</head>
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

    <main>
        <div class="main-header">
            <h2>Katalog filmów <?= $search !== '' ? ' (Wyniki dla "'.htmlspecialchars($search).'")' : '' ?></h2>
        </div>
        <div class="movie-grid">
            <?php foreach ($filmy as $film): ?>
                <a href="film.php?id=<?= $film['id'] ?>" class="movie-card">
                    <div class="movie-poster"><span class="movie-year"><?= $film['rok'] ?></span></div>
                    <div class="movie-info">
                        <h3><?= htmlspecialchars($film['tytul']) ?></h3>
                        <p class="genre"><?= htmlspecialchars($film['gatunek']) ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>