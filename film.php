<?php
require 'backend/config/config.php';
if (!isset($_GET['id'])) { header("Location: index.php"); exit; }
$id = (int)$_GET['id'];

// Dodawanie recenzji (tylko zalogowani)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $autor = $_SESSION['login']; // Autor z sesji!
    $ocena = (int)($_POST['ocena'] ?? 0); 
    $tresc = trim($_POST['tresc'] ?? '');
    
    if ($ocena >= 1 && $ocena <= 10 && !empty($tresc)) {
        $stmt = $pdo->prepare('INSERT INTO recenzje (film_id, autor, ocena, tresc) VALUES (?, ?, ?, ?)');
        $stmt->execute([$id, $autor, $ocena, $tresc]);
        header("Location: film.php?id=$id&success=1"); exit;
    }
}

$stmt = $pdo->prepare('SELECT * FROM filmy WHERE id = ?'); $stmt->execute([$id]); $film = $stmt->fetch();
if (!$film) { echo "<h2>Nie znaleziono filmu.</h2>"; exit; }

$stmt = $pdo->prepare('SELECT a.id as aktor_id, a.imie, a.nazwisko, o.rola FROM obsada o JOIN aktorzy a ON o.aktor_id = a.id WHERE o.film_id = ?'); $stmt->execute([$id]); $obsada = $stmt->fetchAll();
$stmt = $pdo->prepare('SELECT * FROM recenzje WHERE film_id = ? ORDER BY data_dodania DESC'); $stmt->execute([$id]); $recenzje = $stmt->fetchAll();
$avgRating = count($recenzje) > 0 ? round(array_sum(array_column($recenzje, 'ocena')) / count($recenzje), 1) : 0;
?>
<!DOCTYPE html>
<html lang="pl">
<head><meta charset="UTF-8"><title><?= htmlspecialchars($film['tytul']) ?></title><link rel="stylesheet" href="frontend/css/style.css"></head>
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
        <div class="details-header" style="display:flex; justify-content:space-between; border-bottom:1px solid #2C313C; padding-bottom:15px; margin-bottom:20px;">
            <div class="details-title">
                <h1 style="margin:0; font-size:32px;"><?= htmlspecialchars($film['tytul']) ?> (<?= $film['rok'] ?>)</h1>
                <p class="genre-tag"><?= htmlspecialchars($film['gatunek']) ?></p>
            </div>
            <div style="background: rgba(245,197,24,0.1); padding:10px 20px; border-radius:8px;">★ <?= $avgRating > 0 ? $avgRating : '-' ?>/10</div>
        </div>
        <p><?= nl2br(htmlspecialchars($film['opis'])) ?></p>
        <div style="display:grid; grid-template-columns: 1fr 2fr; gap:40px;">
            <section>
                <h3>Obsada</h3>
                <ul class="cast-list">
                    <?php foreach ($obsada as $aktor): ?>
                        <li><a href="aktor.php?id=<?= $aktor['aktor_id'] ?>" class="actor-link"><?= htmlspecialchars($aktor['imie'] . ' ' . $aktor['nazwisko']) ?></a> jako <?= htmlspecialchars($aktor['rola']) ?></li>
                    <?php endforeach; ?>
                </ul>
            </section>
            <section>
                <h3>Dodaj recenzję</h3>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <form method="post" class="review-form" style="background:#1A1D24; padding:20px; border-radius:8px; margin-bottom:30px;">
                        <input type="number" name="ocena" min="1" max="10" placeholder="Ocena (1-10)" required>
                        <textarea name="tresc" rows="4" placeholder="Twoja recenzja (jako <?= htmlspecialchars($_SESSION['login']) ?>)" required></textarea>
                        <button type="submit" class="btn">Dodaj opinię</button>
                    </form>
                <?php else: ?>
                    <div style="background:#1A1D24; padding:20px; border-radius:8px; margin-bottom:30px; text-align:center;">
                        <p>Musisz być zalogowany, aby dodać recenzję.</p>
                        <a href="login.php" class="btn">Zaloguj się</a>
                    </div>
                <?php endif; ?>

                <h3>Recenzje</h3>
                <?php foreach ($recenzje as $recenzja): ?>
                    <div class="review-card"><strong><?= htmlspecialchars($recenzja['autor']) ?></strong> (★ <?= $recenzja['ocena'] ?>/10)<p><?= nl2br(htmlspecialchars($recenzja['tresc'])) ?></p></div>
                <?php endforeach; ?>
            </section>
        </div>
    </main>
</body>
</html>