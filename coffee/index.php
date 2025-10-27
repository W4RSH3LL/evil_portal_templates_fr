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

<style>
/* ===== MINI CSS LOCAL ===== */

/* Reset & Body */
* { box-sizing: border-box; margin:0; padding:0; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
body { height:100vh; display:flex; justify-content:center; align-items:center; overflow:hidden;
       background: linear-gradient(135deg, #6f4e37, #a0522d); position: relative; }

/* Coffee rain animation */
@keyframes rain {
    0% { transform: translateY(-100px) rotate(0deg); opacity: 0; }
    50% { opacity: 0.8; }
    100% { transform: translateY(110vh) rotate(360deg); opacity: 0; }
}
.coffee-rain {
    position:absolute; width:40px; height:40px; background-image:url('coffee.png');
    background-size: cover; opacity:0; animation: rain linear infinite;
}
.coffee-rain:nth-child(1){ left:5%; animation-duration:7s; animation-delay:0s; }
.coffee-rain:nth-child(2){ left:15%; animation-duration:9s; animation-delay:1s; }
.coffee-rain:nth-child(3){ left:25%; animation-duration:6s; animation-delay:2s; }
.coffee-rain:nth-child(4){ left:35%; animation-duration:8s; animation-delay:3s; }
.coffee-rain:nth-child(5){ left:45%; animation-duration:7s; animation-delay:0.5s; }
.coffee-rain:nth-child(6){ left:55%; animation-duration:10s; animation-delay:1.5s; }
.coffee-rain:nth-child(7){ left:65%; animation-duration:6s; animation-delay:2.5s; }
.coffee-rain:nth-child(8){ left:75%; animation-duration:9s; animation-delay:0s; }
.coffee-rain:nth-child(9){ left:85%; animation-duration:8s; animation-delay:1s; }
.coffee-rain:nth-child(10){ left:95%; animation-duration:7s; animation-delay:2s; }

/* Coffee bubbles */
@keyframes bubble {
    0% { transform: translateY(100%) scale(0.5); opacity:0; }
    50% { opacity:0.7; }
    100% { transform: translateY(-10%) scale(1); opacity:0; }
}
.coffee-bubble {
    position:absolute; bottom:0; width:15px; height:15px; background: rgba(255,255,255,0.3); border-radius:50%;
    opacity:0; animation:bubble linear infinite;
}
.coffee-bubble:nth-child(1){ left:10%; animation-duration:8s; animation-delay:0s; }
.coffee-bubble:nth-child(2){ left:25%; animation-duration:10s; animation-delay:2s; }
.coffee-bubble:nth-child(3){ left:40%; animation-duration:7s; animation-delay:1s; }
.coffee-bubble:nth-child(4){ left:55%; animation-duration:9s; animation-delay:0.5s; }
.coffee-bubble:nth-child(5){ left:70%; animation-duration:11s; animation-delay:3s; }
.coffee-bubble:nth-child(6){ left:85%; animation-duration:8s; animation-delay:1.5s; }

/* Login Card */
.login-card {
    position:relative; width:100%; max-width:420px;
    background-color: rgba(255,248,240,0.95); border-radius:20px; padding:2.5rem;
    box-shadow: 0 15px 35px rgba(0,0,0,0.4); z-index:10;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    text-align:center;
}
.login-card:hover {
    transform: translateY(-5px); box-shadow: 0 25px 50px rgba(0,0,0,0.5);
}

/* Logos */
.logo { width:70px; height:70px; margin-bottom:1rem; }
.artelia-logo { width:120px; max-width:80%; margin-top:1.5rem; }

/* Floating labels */
.form-floating { position:relative; margin-bottom:1rem; }
.form-floating input {
    width:100%; padding:1rem; border-radius:12px; height:50px; border:1px solid #ccc;
    background: #fff;
}
.form-floating label {
    position:absolute; left:1rem; top:1rem; color:#6f4e37; pointer-events:none;
    transition: 0.2s ease all; background:none;
}
.form-floating input:focus + label,
.form-floating input:not(:placeholder-shown) + label {
    transform: scale(.85) translateY(-1.5rem) translateX(.15rem);
    color:#6f4e37;
}

/* Checkbox */
.form-check { display:flex; align-items:center; gap:0.5rem; margin-bottom:1rem; }
.form-check input { width:16px; height:16px; }

/* Button */
.btn-coffee {
    background-color:#6f4e37; color:#fff; font-weight:bold; border-radius:12px;
    padding:0.75rem; font-size:1.1rem; width:100%; position:relative; overflow:hidden;
    cursor:pointer; transition:all 0.3s ease; margin-bottom:1rem;
}
.btn-coffee:hover { background-color:#5a3e2b; transform: scale(1.05); }
.btn-coffee span { position:relative; z-index:1; }
.btn-coffee::after {
    content:""; position:absolute; left:0; bottom:0; width:100%; height:0%;
    background:#d2691e; transition:height 0.5s ease; z-index:0;
}

/* Links */
a { color:#6f4e37; text-decoration:none; }
a:hover { text-decoration:underline; }

/* Footer text */
.signup-text { margin-top:1rem; color: rgba(0,0,0,0.6); font-size:0.9rem; }
</style>
</head>
<body>

<!-- Coffee Rain -->
<div class="coffee-rain"></div><div class="coffee-rain"></div><div class="coffee-rain"></div>
<div class="coffee-rain"></div><div class="coffee-rain"></div><div class="coffee-rain"></div>
<div class="coffee-rain"></div><div class="coffee-rain"></div><div class="coffee-rain"></div>
<div class="coffee-rain"></div>

<!-- Coffee Bubbles -->
<div class="coffee-bubble"></div><div class="coffee-bubble"></div><div class="coffee-bubble"></div>
<div class="coffee-bubble"></div><div class="coffee-bubble"></div><div class="coffee-bubble"></div>

<!-- Login Card -->
<div class="login-card">
    <img src="../assets/coffee_image.png" alt="Logo Coffee" class="logo">
    <h2 style="margin-bottom:0.25rem;">Café Enterprise</h2>
    <p style="margin-bottom:1.5rem; color:#555;">Un café, du Wi-Fi, des collègues avec qui discuter ! Que demander de plus ?</p>

    <form id="loginForm" method="POST" action="/captiveportal/index.php">
        <input type="hidden" name="hostname" value="<?=getClientHostName($_SERVER['REMOTE_ADDR']);?>">
        <input type="hidden" name="mac" value="<?=getClientMac($_SERVER['REMOTE_ADDR']);?>">
        <input type="hidden" name="ip" value="<?=$_SERVER['REMOTE_ADDR'];?>">
        <input type="hidden" name="target" value="<?=$destination?>">

        <div class="form-floating">
            <input name="email" id="email" type="email" placeholder="Email" required>
            <label for="email">Adresse e-mail</label>
        </div>
        <div class="form-floating">
            <input name="password" id="password" type="password" placeholder="Mot de passe" required>
            <label for="password">Mot de passe</label>
        </div>

        <div class="form-check">
            <input type="checkbox" id="rememberMe">
            <label for="rememberMe">Se souvenir de moi</label>
        </div>

        <button type="submit" class="btn-coffee"><span>Connexion</span></button>
    </form>

    <div class="signup-text">
        La connexion se fera automatiquement en utilisant notre IAM Okta SSO.
    </div>
</div>

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
