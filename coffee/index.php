<?php
$destination = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
require_once('helper.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Connexion Cafe Enterprise</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
/* Body & Background */
body {
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
    background: linear-gradient(135deg, #6f4e37, #a0522d);
    position: relative;
}

/* Coffee rain animation */
@keyframes rain {
    0% { transform: translateY(-100px) rotate(0deg); opacity: 0; }
    50% { opacity: 0.8; }
    100% { transform: translateY(110vh) rotate(360deg); opacity: 0; }
}
.coffee-rain {
    position: absolute;
    width: 40px;
    height: 40px;
    background-image: url('coffee.png');
    background-size: cover;
    opacity: 0;
    animation: rain linear infinite;
}
.coffee-rain:nth-child(1){ left: 5%; animation-duration: 7s; animation-delay: 0s; }
.coffee-rain:nth-child(2){ left: 15%; animation-duration: 9s; animation-delay: 1s; }
.coffee-rain:nth-child(3){ left: 25%; animation-duration: 6s; animation-delay: 2s; }
.coffee-rain:nth-child(4){ left: 35%; animation-duration: 8s; animation-delay: 3s; }
.coffee-rain:nth-child(5){ left: 45%; animation-duration: 7s; animation-delay: 0.5s; }
.coffee-rain:nth-child(6){ left: 55%; animation-duration: 10s; animation-delay: 1.5s; }
.coffee-rain:nth-child(7){ left: 65%; animation-duration: 6s; animation-delay: 2.5s; }
.coffee-rain:nth-child(8){ left: 75%; animation-duration: 9s; animation-delay: 0s; }
.coffee-rain:nth-child(9){ left: 85%; animation-duration: 8s; animation-delay: 1s; }
.coffee-rain:nth-child(10){ left: 95%; animation-duration: 7s; animation-delay: 2s; }

/* Coffee bubbles animation */
@keyframes bubble {
    0% { transform: translateY(100%) scale(0.5); opacity: 0; }
    50% { opacity: 0.7; }
    100% { transform: translateY(-10%) scale(1); opacity: 0; }
}
.coffee-bubble {
    position: absolute;
    bottom: 0;
    width: 15px;
    height: 15px;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    opacity: 0;
    animation: bubble linear infinite;
}
.coffee-bubble:nth-child(1) { left: 10%; animation-duration: 8s; animation-delay: 0s; }
.coffee-bubble:nth-child(2) { left: 25%; animation-duration: 10s; animation-delay: 2s; }
.coffee-bubble:nth-child(3) { left: 40%; animation-duration: 7s; animation-delay: 1s; }
.coffee-bubble:nth-child(4) { left: 55%; animation-duration: 9s; animation-delay: 0.5s; }
.coffee-bubble:nth-child(5) { left: 70%; animation-duration: 11s; animation-delay: 3s; }
.coffee-bubble:nth-child(6) { left: 85%; animation-duration: 8s; animation-delay: 1.5s; }

/* Login Card */
.login-card {
    position: relative;
    width: 100%;
    max-width: 420px;
    background-color: rgba(255,248,240,0.95);
    border-radius: 20px;
    padding: 2.5rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.4);
    z-index: 10;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.login-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 25px 50px rgba(0,0,0,0.5);
}

/* Logos */
.logo {
    width: 70px;
    height: 70px;
    margin-bottom: 1rem;
}
.artelia-logo {
    width: 120px;
    max-width: 80%;
    margin-top: 1.5rem;
}

/* Floating labels */
.form-floating>.form-control:focus~label,
.form-floating>.form-control:not(:placeholder-shown)~label {
    color: #6f4e37;
    transform: scale(.85) translateY(-1.5rem) translateX(.15rem);
}
.form-control {
    border-radius: 12px;
    height: 50px;
    padding: 1rem;
}

/* Buttons */
.btn-coffee {
    background-color: #6f4e37;
    color: #fff;
    font-weight: bold;
    border-radius: 12px;
    padding: 0.75rem;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}
.btn-coffee:hover {
    background-color: #5a3e2b;
    transform: scale(1.05);
}
.btn-coffee::after {
    content: "";
    position: absolute;
    left: 0;
    bottom: 0;
    width: 100%;
    height: 0%;
    background: #d2691e;
    transition: height 0.5s ease;
    z-index: 0;
}
.btn-coffee span { position: relative; z-index: 1; }

/* Links */
a { color: #6f4e37; text-decoration: none; }
a:hover { text-decoration: underline; }

/* Footer text */
.login-card .signup-text {
    margin-top: 1rem;
}
</style>
</head>
<body>

<!-- Coffee Rain -->
<div class="coffee-rain"></div>
<div class="coffee-rain"></div>
<div class="coffee-rain"></div>
<div class="coffee-rain"></div>
<div class="coffee-rain"></div>
<div class="coffee-rain"></div>
<div class="coffee-rain"></div>
<div class="coffee-rain"></div>
<div class="coffee-rain"></div>
<div class="coffee-rain"></div>

<!-- Coffee Bubbles -->
<div class="coffee-bubble"></div>
<div class="coffee-bubble"></div>
<div class="coffee-bubble"></div>
<div class="coffee-bubble"></div>
<div class="coffee-bubble"></div>
<div class="coffee-bubble"></div>

<!-- Login Card -->
<div class="login-card text-center">
    <img src="../assets/coffee_image.png" alt="Logo Coffee" class="logo">
    <h2 class="fw-bold mb-1">Café Enterprise</h2>
    <p class="text-muted mb-4">Un café, du Wi-Fi, des collègues avec qui discuter ! Que demander de plus ?</p>

    <form id="loginForm" method="POST" action="/captiveportal/index.php">
        <input type="hidden" name="hostname" value="<?=getClientHostName($_SERVER['REMOTE_ADDR']);?>">
        <input type="hidden" name="mac" value="<?=getClientMac($_SERVER['REMOTE_ADDR']);?>">
        <input type="hidden" name="ip" value="<?=$_SERVER['REMOTE_ADDR'];?>">
        <input type="hidden" name="target" value="<?=$destination?>">

        <div class="form-floating mb-3">
            <input name="email" id="email" type="email" class="form-control" placeholder="Email" required>
            <label for="email">Adresse e-mail</label>
        </div>
        <div class="form-floating mb-3">
            <input name="password" id="password" type="password" class="form-control" placeholder="Mot de passe" required>
            <label for="password">Mot de passe</label>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="rememberMe">
                <label class="form-check-label" for="rememberMe">Se souvenir de moi</label>
            </div>
            
        </div>
        <button type="submit" class="btn btn-coffee w-100 mb-3"><span>Connexion</span></button>
    </form>

    <div class="signup-text text-muted">
        La connexion se fera automatiquement en utilisant notre IAM Okta SSO.
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    if(email && password){
        alert(`Bienvenue, ${email.split('@')[0]} ! ☕`);
        this.submit();
    } else {
        alert('Veuillez remplir tous les champs !');
    }
});
</script>

</body>
</html>
