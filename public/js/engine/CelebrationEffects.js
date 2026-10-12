/**
 * MISSION KIDS — Celebration Effects Engine
 * Pure HTML5 Canvas confetti bursts, celestial falling stars (bintang jatuh), and animated counters.
 */

class CelebrationEffects {
  constructor() {
    this.canvas = null;
    this.ctx = null;
    this.particles = [];
    this.animationFrame = null;
    this.initCanvas();
  }

  initCanvas() {
    let el = document.getElementById('mk-confetti-canvas');
    if (!el) {
      el = document.createElement('canvas');
      el.id = 'mk-confetti-canvas';
      el.style.position = 'fixed';
      el.style.top = '0';
      el.style.left = '0';
      el.style.width = '100vw';
      el.style.height = '100vh';
      el.style.pointerEvents = 'none';
      el.style.zIndex = '10001';
      document.body.appendChild(el);
    }
    this.canvas = el;
    this.ctx = el.getContext('2d');
    this.resize();
    window.addEventListener('resize', () => this.resize());
  }

  resize() {
    if (!this.canvas) return;
    this.canvas.width = window.innerWidth;
    this.canvas.height = window.innerHeight;
  }

  // Helper: Draw 5-Point Star Polygon with optional radiant glow
  drawStar(ctx, cx, cy, spikes, outerRadius, innerRadius, color, glow = 0) {
    let rot = (Math.PI / 2) * 3;
    let x = cx;
    let y = cy;
    const step = Math.PI / spikes;

    ctx.save();
    ctx.beginPath();
    ctx.moveTo(cx, cy - outerRadius);
    for (let i = 0; i < spikes; i++) {
      x = cx + Math.cos(rot) * outerRadius;
      y = cy + Math.sin(rot) * outerRadius;
      ctx.lineTo(x, y);
      rot += step;

      x = cx + Math.cos(rot) * innerRadius;
      y = cy + Math.sin(rot) * innerRadius;
      ctx.lineTo(x, y);
      rot += step;
    }
    ctx.lineTo(cx, cy - outerRadius);
    ctx.closePath();
    if (glow > 0) {
      ctx.shadowColor = color;
      ctx.shadowBlur = glow;
    }
    ctx.fillStyle = color;
    ctx.fill();
    ctx.restore();
  }

  // 1. Confetti Burst
  burst(options = {}) {
    this.resize();
    const colors = ['#2563EB', '#F59E0B', '#10B981', '#EC4899', '#8B5CF6', '#38BDF8'];
    const count = options.count || 120;
    const originX = options.x !== undefined ? options.x : window.innerWidth / 2;
    const originY = options.y !== undefined ? options.y : window.innerHeight / 2.5;

    for (let i = 0; i < count; i++) {
      const angle = Math.random() * Math.PI * 2;
      const speed = Math.random() * 12 + 6;
      this.particles.push({
        type: 'confetti',
        x: originX,
        y: originY,
        vx: Math.cos(angle) * speed,
        vy: Math.sin(angle) * speed - 4,
        size: Math.random() * 8 + 4,
        color: colors[Math.floor(Math.random() * colors.length)],
        shape: Math.random() > 0.4 ? 'rect' : 'circle',
        rotation: Math.random() * 360,
        rotationSpeed: (Math.random() - 0.5) * 12,
        opacity: 1,
        life: 1,
        decay: Math.random() * 0.015 + 0.008
      });
    }

    if (!this.animationFrame) {
      this.animate();
    }
  }

  // 2. Celestial Falling & Shooting Stars Shower (Bintang Jatuh Saat Berhasil)
  starShower(options = {}) {
    this.resize();
    const fallingCount = options.count || 45;
    const shootingCount = options.shootingStars || 6;
    const starColors = ['#FBBF24', '#F59E0B', '#FDE047', '#FEF08A', '#FFFBEB', '#60A5FA', '#F43F5E', '#A78BFA'];

    // 2a. Diagonal Shooting Stars (Bintang Jatuh Berekor Cahaya Komet)
    for (let i = 0; i < shootingCount; i++) {
      const delay = i * 200;
      setTimeout(() => {
        if (!this.canvas) return;
        const startX = Math.random() * (this.canvas.width * 0.6) - 50;
        const startY = Math.random() * (this.canvas.height * 0.25) - 30;
        const angle = (Math.PI / 180) * (34 + Math.random() * 16); // ~34 - 50 deg diagonal
        const speed = Math.random() * 8 + 16;

        this.particles.push({
          type: 'shooting_star',
          x: startX,
          y: startY,
          vx: Math.cos(angle) * speed,
          vy: Math.sin(angle) * speed,
          size: Math.random() * 4 + 5,
          trail: [],
          maxTrail: 16,
          color: '#FFFBEB',
          glowColor: '#FDE047',
          opacity: 1,
          life: 1,
          decay: Math.random() * 0.012 + 0.008
        });

        if (!this.animationFrame) {
          this.animate();
        }
      }, delay);
    }

    // 2b. Cascading Twinkling 5-pointed Golden Stars (Hujan Bintang Berkelip)
    for (let i = 0; i < fallingCount; i++) {
      const startX = Math.random() * this.canvas.width;
      const startY = -Math.random() * 160 - 20;
      this.particles.push({
        type: 'falling_star',
        x: startX,
        y: startY,
        vx: (Math.random() - 0.5) * 2.4,
        vy: Math.random() * 2.8 + 2.2,
        outerRadius: Math.random() * 9 + 6,
        innerRadius: Math.random() * 4.5 + 3,
        spikes: 5,
        color: starColors[Math.floor(Math.random() * starColors.length)],
        rotation: Math.random() * 360,
        rotationSpeed: (Math.random() - 0.5) * 7,
        wobble: Math.random() * Math.PI * 2,
        wobbleSpeed: Math.random() * 0.05 + 0.02,
        twinklePhase: Math.random() * Math.PI * 2,
        twinkleSpeed: Math.random() * 0.09 + 0.04,
        opacity: 1,
        life: 1,
        decay: Math.random() * 0.006 + 0.004
      });
    }

    if (!this.animationFrame) {
      this.animate();
    }
  }

  animate() {
    if (this.particles.length === 0) {
      if (this.ctx && this.canvas) {
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
      }
      this.animationFrame = null;
      return;
    }

    this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);

    for (let i = this.particles.length - 1; i >= 0; i--) {
      const p = this.particles[i];

      // A. Shooting Star (Bintang Jatuh Berekor)
      if (p.type === 'shooting_star') {
        p.trail.unshift({ x: p.x, y: p.y });
        if (p.trail.length > p.maxTrail) p.trail.pop();

        p.x += p.vx;
        p.y += p.vy;
        p.life -= p.decay;
        p.opacity = Math.max(0, p.life);

        if (p.opacity <= 0 || p.x > this.canvas.width + 120 || p.y > this.canvas.height + 120) {
          this.particles.splice(i, 1);
          continue;
        }

        // Draw glowing luminous comet tail
        if (p.trail.length > 1) {
          for (let t = 0; t < p.trail.length - 1; t++) {
            const t1 = p.trail[t];
            const t2 = p.trail[t + 1];
            const ratio = (1 - t / p.trail.length) * p.opacity;
            this.ctx.save();
            this.ctx.beginPath();
            this.ctx.moveTo(t1.x, t1.y);
            this.ctx.lineTo(t2.x, t2.y);
            this.ctx.strokeStyle = `rgba(253, 224, 71, ${ratio * 0.9})`;
            this.ctx.lineWidth = ratio * (p.size * 1.5);
            this.ctx.lineCap = 'round';
            this.ctx.shadowColor = p.glowColor || '#FDE047';
            this.ctx.shadowBlur = 12 * ratio;
            this.ctx.stroke();
            this.ctx.restore();
          }
        }

        // Star core with bright nucleus
        this.drawStar(this.ctx, p.x, p.y, 5, p.size * 2, p.size * 0.9, '#FFFFFF', 18);
        continue;
      }

      // B. Falling Twinkling 5-pointed Star (Hujan Bintang Berkelip)
      if (p.type === 'falling_star') {
        p.wobble += p.wobbleSpeed;
        p.x += p.vx + Math.sin(p.wobble) * 1.3;
        p.y += p.vy;
        p.rotation += p.rotationSpeed;
        p.twinklePhase += p.twinkleSpeed;
        p.life -= p.decay;
        const twinkle = 0.65 + 0.35 * Math.sin(p.twinklePhase);
        p.opacity = Math.max(0, p.life * twinkle);

        if (p.opacity <= 0 || p.y > this.canvas.height + 40) {
          this.particles.splice(i, 1);
          continue;
        }

        this.ctx.save();
        this.ctx.globalAlpha = p.opacity;
        this.ctx.translate(p.x, p.y);
        this.ctx.rotate((p.rotation * Math.PI) / 180);
        this.drawStar(this.ctx, 0, 0, p.spikes || 5, p.outerRadius, p.innerRadius, p.color, 10);
        this.ctx.restore();
        continue;
      }

      // C. Standard Confetti Particle
      p.x += p.vx;
      p.y += p.vy;
      p.vy += 0.35; // gravity
      p.vx *= 0.98; // air drag
      p.rotation += p.rotationSpeed;
      p.life -= p.decay;
      p.opacity = Math.max(0, p.life);

      if (p.opacity <= 0 || p.y > this.canvas.height + 20) {
        this.particles.splice(i, 1);
        continue;
      }

      this.ctx.save();
      this.ctx.globalAlpha = p.opacity;
      this.ctx.translate(p.x, p.y);
      this.ctx.rotate((p.rotation * Math.PI) / 180);
      this.ctx.fillStyle = p.color;

      if (p.shape === 'rect') {
        this.ctx.fillRect(-p.size / 2, -p.size / 2, p.size, p.size * 1.5);
      } else {
        this.ctx.beginPath();
        this.ctx.arc(0, 0, p.size / 2, 0, Math.PI * 2);
        this.ctx.fill();
      }
      this.ctx.restore();
    }

    this.animationFrame = requestAnimationFrame(() => this.animate());
  }

  // Smooth number counting animation for XP or Stars
  animateCountUp(element, start, end, duration = 1200, prefix = '+', suffix = ' XP') {
    if (!element) return;
    const startTime = performance.now();

    const update = (now) => {
      const elapsed = now - startTime;
      const progress = Math.min(1, elapsed / duration);
      const ease = 1 - Math.pow(1 - progress, 3);
      const current = Math.round(start + (end - start) * ease);

      element.textContent = `${prefix}${current}${suffix}`;

      if (progress < 1) {
        requestAnimationFrame(update);
      } else {
        element.textContent = `${prefix}${end}${suffix}`;
        element.style.transform = 'scale(1.2)';
        setTimeout(() => { element.style.transform = 'scale(1)'; }, 200);
      }
    };

    requestAnimationFrame(update);
  }
}

// Global Singleton
window.Celebration = new CelebrationEffects();
