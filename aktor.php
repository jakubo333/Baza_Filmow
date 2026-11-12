<?php
require 'backend/config/config.php';
if (!isset($_GET['id'])) { header("Location: index.php"); exit; }
$id = (int)$_GET['id'];
$stmt = $pdo->prepare('SELECT * FROM aktorzy WHERE id = ?'); $stmt->execute([$id]); $aktor = $stmt->fetch();
$stmt = $pdo->prepare('SELECT f.id as film_id, f.tytul, f.rok, f.gatunek, o.rola FROM obsada o JOIN filmy f ON o.film_id = f.id WHERE o.aktor_id = ? ORDER BY f.rok DESC'); $stmt->execute([$id]); $filmy = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pl">
<head><meta charset="UTF-8"><title><?= htmlspecialchars($aktor['imie'] . ' ' . $aktor['nazwisko']) ?></title><link rel="stylesheet" href="frontend/css/style.css"></head>
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
        <h1><?= htmlspecialchars($aktor['imie'] . ' ' . $aktor['nazwisko']) ?></h1>
        <p><?= nl2br(htmlspecialchars($aktor['biografia'])) ?></p>
        <h3>Filmografia</h3>
        <table style="width:100%; border-collapse:collapse; margin-top:20px;">
            <thead><tr><th style="text-align:left;">Rok</th><th style="text-align:left;">Tytuł</th><th style="text-align:left;">Rola</th></tr></thead>
            <tbody>
                <?php foreach ($filmy as $film): ?>
                    <tr>
                        <td style="padding:10px 0; border-bottom:1px solid #2C313C;"><?= $film['rok'] ?></td>
                        <td style="padding:10px 0; border-bottom:1px solid #2C313C;"><a href="film.php?id=<?= $film['film_id'] ?>" class="actor-link"><?= htmlspecialchars($film['tytul']) ?></a></td>
                        <td style="padding:10px 0; border-bottom:1px solid #2C313C; font-style:italic;"><?= htmlspecialchars($film['rola']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>