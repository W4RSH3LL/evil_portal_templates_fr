<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title>Portail Captif SFR Premium</title>
<style>
  /* === GLOBAL === */
  * { box-sizing:border-box; -webkit-tap-highlight-color: transparent; }
  body {
    margin:0; font-family:sans-serif; color:#fff; overflow:hidden;
    background:#1e1e1e;
    display:flex; justify-content:center; align-items:center;
    height:100vh;
    overscroll-behavior:contain;
    touch-action:manipulation;
  }

  /* === CARD === */
  .card {
    background: rgba(42,42,42,0.85);
    border-radius:1rem;
    padding:2rem;
    max-width:380px;
    width:90%;
    text-align:center;
    position:relative;
    backdrop-filter: blur(10px);
    transition: transform 0.2s ease-out;
    z-index:10;
  }

  /* === LOGO HALO === */
  .logo-container { position:relative; display:inline-block; margin-bottom:1rem; }
  .logo-halo {
    position:absolute; inset:0;
    border-radius:50%;
    background: radial-gradient(circle,#e60028 0%,transparent 70%);
    filter:blur(20px);
    animation: pulse 2s infinite alternate;
    z-index:-1;
  }
  @keyframes pulse { 0%{transform:scale(1);} 100%{transform:scale(1.2);} }

  /* === TEXT === */
  h1 { color:#e60028; margin-bottom:0.5rem; font-size:1.8rem; }
  p { color:#ccc; margin-bottom:1.5rem; font-size:0.9rem; }

  /* === INPUTS === */
  input {
    width:100%;
    padding:0.75rem 1rem;
    margin-bottom:1rem;
    border-radius:0.5rem;
    border:1px solid #555;
    background: rgba(50,50,50,0.8);
    color:#fff;
    font-size:1rem;
  }
  input:focus { outline:2px solid #e60028; }

  /* === BUTTONS === */
  button {
    padding:0.8rem 1rem;
    width:100%;
    border:none;
    border-radius:0.5rem;
    font-weight:bold;
    cursor:pointer;
    margin-bottom:0.5rem;
    font-size:1rem;
    transition:background 0.2s ease;
  }
  .btn-login { background:#e60028; color:#fff; }
  .btn-login:hover, .btn-login:active { background:#ff2c48; }
  .btn-guest { background:transparent; border:1px solid #aaa; color:#ccc; }
  .btn-guest:hover, .btn-guest:active { color:#fff; border-color:#e60028; }

  /* === SUCCESS ANIM === */
  #success {
    position:absolute; inset:0;
    display:flex; justify-content:center; align-items:center;
    background:rgba(0,0,0,0.6);
    font-size:3rem;
    border-radius:1rem;
    opacity:0;
    pointer-events:none;
    transition: opacity 0.3s ease;
    z-index:20;
  }
  #success.show { opacity:1; }

  /* === PARTICLE === */
  .particle {
    position:absolute;
    width:6px; height:6px;
    border-radius:50%;
    background: radial-gradient(circle,#ff3b50 0%,#ff6b6b 80%);
    pointer-events:none;
    opacity:0.8;
    filter:blur(2px);
    animation:fadeOut 0.6s forwards;
    z-index:5;
  }
  @keyframes fadeOut {
    0% { transform:scale(1); opacity:0.8; }
    100% { transform:scale(0); opacity:0; }
  }

  /* === ORBS === */
  .orb {
    position:absolute;
    width:15px; height:15px;
    border-radius:50%;
    background: radial-gradient(circle,#ff3b50 0%,#ff6b6b 80%);
    box-shadow:0 0 15px rgba(255,59,80,0.6);
    pointer-events:none;
    z-index:5;
    opacity:0.8;
  }

  /* === MOBILE === */
  @media (max-width:480px) {
    .card { padding:1.5rem; }
    h1 { font-size:1.6rem; }
    p { font-size:0.85rem; }
    input, button { font-size:0.95rem; }
  }
</style>
</head>
<body>

<!-- Orbs -->
<div id="orbsContainer"></div>

<!-- Card -->
<div class="card" id="card">
  <div class="logo-container">
    <div class="logo-halo"></div>
    <img src="assets/sfr_logo.jpg" alt="SFR Logo" style="width:120px;">
  </div>
  <h1>Accès Wi-Fi SFR</h1>
  <p>Connectez-vous pour profiter d’Internet en toute sécurité.</p>

  <form id="form">
    <input type="email" placeholder="Adresse e-mail" required>
    <input type="password" placeholder="Mot de passe" required>
    <button type="submit" class="btn-login">Se connecter</button>
  </form>
  <button id="guestBtn" class="btn-guest">Connexion invitée</button>
</div>

<div id="success">✓</div>

<script>
const form = document.getElementById('form');
const guestBtn = document.getElementById('guestBtn');
const success = document.getElementById('success');
const card = document.getElementById('card');
const orbsContainer = document.getElementById('orbsContainer');

// === LOGIN / INVITÉ ===
function showSuccess() {
  success.classList.add('show');
  setTimeout(()=> success.classList.remove('show'), 900);
}
form.addEventListener('submit', e => {
  e.preventDefault();
  showSuccess();
});
guestBtn.addEventListener('click', showSuccess);

// === PARTICLES ===
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

// === CARD 3D EFFECT ===
function updateTilt(x,y){
  card.style.transform=`rotateX(${x}deg) rotateY(${y}deg)`;
}
window.addEventListener('mousemove', e=>{
  const cx = window.innerWidth/2;
  const cy = window.innerHeight/2;
  const dx = (e.clientX - cx)/cx * 10;
  const dy = (e.clientY - cy)/cy * 10;
  updateTilt(dy, dx);
});
window.addEventListener('deviceorientation', e=>{
  const x = e.beta ? (e.beta - 45)/45*10 : 0;
  const y = e.gamma ? e.gamma/45*10 : 0;
  updateTilt(x, y);
});

// === ORBS ===
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
  orbs.forEach((orb,i)=>{
    const offset=5+i*2;
    orb.style.transform=`translate(${y*offset}px,${x*offset}px)`;
  });
}
window.addEventListener('mousemove', e=>{
  const cx=window.innerWidth/2, cy=window.innerHeight/2;
  const dx=(e.clientX-cx)/cx*10, dy=(e.clientY-cy)/cy*10;
  moveOrbs(dy, dx);
});
window.addEventListener('deviceorientation', e=>{
  const x=e.beta?(e.beta-45)/45*10:0;
  const y=e.gamma?e.gamma/45*10:0;
  moveOrbs(x,y);
});
</script>

</body>
</html>
