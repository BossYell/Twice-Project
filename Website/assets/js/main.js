// Simple confetti particle system for "Cheer" buttons
(() => {
  const canvas = document.getElementById('confetti-canvas');
  const ctx = canvas.getContext && canvas.getContext('2d');
  if(!ctx) return;

  let W, H, particles = [], lastUpdate=Date.now();
  const COLORS = ['#FF6FA3','#FFD28B','#7BE0D6','#CFA8FF','#FFB4E6'];

  function resize(){
    W = canvas.width = window.innerWidth;
    H = canvas.height = window.innerHeight;
  }
  window.addEventListener('resize', resize);
  resize();

  function rand(min,max){return Math.random()*(max-min)+min}
  function make(x,y,amount=20){
    for(let i=0;i<amount;i++){
      particles.push({
        x: x + rand(-12,12),
        y: y + rand(-12,12),
        vx: rand(-2.5,2.5),
        vy: rand(-6,-2),
        size: rand(6,14),
        color: COLORS[Math.floor(rand(0,COLORS.length))],
        life: rand(900,1600)
      });
    }
  }

  function update(dt){
    for(let i=particles.length-1;i>=0;i--){
      const p = particles[i];
      p.vy += 0.035 * dt; // gravity-ish
      p.x += p.vx * dt;
      p.y += p.vy * dt;
      p.life -= dt*16;
      p.size *= 0.997;
      if(p.life <= 0 || p.y > H + 40) particles.splice(i,1);
    }
  }

  function draw(){
    ctx.clearRect(0,0,W,H);
    particles.forEach(p => {
      ctx.fillStyle = p.color;
      ctx.beginPath();
      ctx.ellipse(p.x, p.y, p.size, p.size*0.7, Math.PI/6, 0, Math.PI*2);
      ctx.fill();
    });
  }

  function loop(){
    const now = Date.now();
    const dt = Math.min(60,(now - lastUpdate)/16.6667);
    lastUpdate = now;
    update(dt);
    draw();
    requestAnimationFrame(loop);
  }
  loop();

  // Attach to buttons and add richer UI animations
  document.addEventListener('DOMContentLoaded', ()=>{
    const light = document.getElementById('lightstick');
    const header = document.querySelector('.title');

    function starBurst(x,y){
      const root = document.createElement('div');
      root.className = 'star-burst';
      for(let i=0;i<6;i++){
        const s = document.createElement('div');
        s.className = 'star';
        s.style.setProperty('--i', i);
        root.appendChild(s);
      }
      root.style.left = (x - 18) + 'px';
      root.style.top = (y - 18) + 'px';
      document.body.appendChild(root);
      setTimeout(()=> root.remove(), 900);
    }

    document.querySelectorAll('.cheer').forEach(btn=>{
      btn.addEventListener('click', (e)=>{
        const r = btn.getBoundingClientRect();
        const x = r.left + r.width/2 + window.scrollX;
        const y = r.top + r.height/2 + window.scrollY;
        make(x,y,36);
        // lightstick pulse
        if(light) {
          light.classList.add('on');
          setTimeout(()=> light.classList.remove('on'), 1200);
        }
        // pop the card
        const card = btn.closest('.card');
        if(card){
          card.classList.add('pop');
          setTimeout(()=> card.classList.remove('pop'), 600);
        }
        // star burst
        starBurst(x,y);
        // header pulse
        if(header){
          header.classList.add('pulse');
          setTimeout(()=> header.classList.remove('pulse'), 900);
        }
        // tiny UI feedback
        const name = btn.dataset.name || 'TWICE';
        btn.textContent = 'CHEERED!';
        setTimeout(()=> btn.textContent = 'Cheer', 900);
      });
    });

    // small welcome burst
    const firstButton = document.querySelector('.cheer');
    if(firstButton){
      const r = firstButton.getBoundingClientRect();
      make(r.left + r.width/2 + window.scrollX, r.top + r.height/2 + window.scrollY, 16);
    }
  });
})();
