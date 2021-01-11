<!doctype html>

<html lang="en">

<head>
  <meta charset="utf-8">

  <title>Gry.mimuw</title>
  <meta name="description" content="gierki">
  <meta name="author" content="SitePoint">

  <link rel="stylesheet" href="styles.css">
  <link rel="shortcut icon" href="https://www.mimuw.edu.pl/sites/default/files/mim_mini.png" type="image/png">
</head>

<body>

  <?php if (isset($_COOKIE['active_username'])) : ?>
    <div class="center"><a href="profile.php">PROFIL</a></div>
    <div class="center"><a href="logout.php">WYLOGUJ</a></div>
  <?php else : ?>
    <div class="center">
      <a href="login_page.php">LOGOWANIE</a><br><br>
      <a href="registration_page.php">REJESTRACJA</a>
    </div>
  <?php endif; ?>

  <a href="szachy.php">Szachy</a><br><br>
  <a href="bierki.php">Bierki</a><br><br>
  <a href="warcaby.php">Warcaby</a><br><br>
  <a href="poker.php">Poker</a><br><br>
  <a href="pilka.php">Piłka</a><br><br>
  <a href="leaderboards.php">Rankingi</a><br><br>

</body>

</html>