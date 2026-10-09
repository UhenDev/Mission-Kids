/**
 * MISSION KIDS — Modular Interaction Handler
 * Provides interactive gameplay engines for:
 * 1. Simulation (Tanaman Layu, Misteri Bayangan)
 * 2. Match & Sort (Toko Kue, Jembatan Angka, Kota Pola, Perjalanan Air)
 * 3. Sequence & Logic (Robot Pulang, Jalan Rahasia, Robot Mengulang)
 */

class InteractionHandler {
  constructor(missionData) {
    this.data = missionData;
    this.config = missionData.config;
    this.type = missionData.type;
    this.slug = missionData.slug;
    this.state = {};
  }

  mount(canvasEl, controlsEl) {
    canvasEl.innerHTML = '';
    controlsEl.innerHTML = '';

    if (this.slug === 'tanaman-layu') {
      this.mountPlantSimulation(canvasEl, controlsEl);
    } else if (this.slug === 'misteri-bayangan') {
      this.mountShadowSimulation(canvasEl, controlsEl);
    } else if (this.slug === 'perjalanan-air') {
      this.mountWaterCycle(canvasEl, controlsEl);
    } else if (this.slug === 'toko-kue') {
      this.mountBakeryShop(canvasEl, controlsEl);
    } else if (this.slug === 'jembatan-angka') {
      this.mountNumberBridge(canvasEl, controlsEl);
    } else if (this.slug === 'kota-pola') {
      this.mountCrystalPattern(canvasEl, controlsEl);
    } else if (this.slug === 'robot-pulang') {
      this.mountRobotRunner(canvasEl, controlsEl);
    } else if (this.slug === 'jalan-rahasia') {
      this.mountSecretPath(canvasEl, controlsEl);
    } else if (this.slug === 'robot-mengulang') {
      this.mountRobotLoop(canvasEl, controlsEl);
    } else {
      canvasEl.innerHTML = `<div style="padding: 2rem;">Tantangan interaktif untuk misi ${this.data.title} siap dimainkan!</div>`;
    }
  }

  // =========================================================================
  // 1. HERO VERTICAL SLICE: Tanaman Layu (Discovery Lab)
  // =========================================================================
  mountPlantSimulation(canvasEl, controlsEl) {
    this.state = {
      water: 15,
      sunlight: 20,
      health: 20
    };

    // Render Live SVG Plant
    canvasEl.innerHTML = `
      <div style="position: relative; display: flex; flex-direction: column; align-items: center;">
        <div id="plant-weather-badge" style="position: absolute; top: 0; left: 0; font-size: 1.8rem;">
          ⛅
        </div>
        <svg class="plant-svg-container" id="plant-svg" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
          <!-- Animated Sun Aura & Rotating Rays -->
          <g id="plant-sun-aura" transform="translate(170, 32)" style="opacity: 0.25; transition: opacity 0.3s ease;">
            <circle cx="0" cy="0" r="16" fill="#FBBF24" style="animation: pulseGold 2.5s infinite;"/>
            <g style="animation: sunSpinSlow 12s linear infinite; transform-origin: 0 0;">
              <line x1="0" y1="-24" x2="0" y2="-18" stroke="#F59E0B" stroke-width="3" stroke-linecap="round"/>
              <line x1="0" y1="24" x2="0" y2="18" stroke="#F59E0B" stroke-width="3" stroke-linecap="round"/>
              <line x1="-24" y1="0" x2="-18" y2="0" stroke="#F59E0B" stroke-width="3" stroke-linecap="round"/>
              <line x1="24" y1="0" x2="18" y2="0" stroke="#F59E0B" stroke-width="3" stroke-linecap="round"/>
              <line x1="-16" y1="-16" x2="-12" y2="-12" stroke="#F59E0B" stroke-width="3" stroke-linecap="round"/>
              <line x1="16" y1="16" x2="12" y2="12" stroke="#F59E0B" stroke-width="3" stroke-linecap="round"/>
              <line x1="16" y1="-16" x2="12" y2="-12" stroke="#F59E0B" stroke-width="3" stroke-linecap="round"/>
              <line x1="-16" y1="16" x2="-12" y2="12" stroke="#F59E0B" stroke-width="3" stroke-linecap="round"/>
            </g>
          </g>

          <!-- Soil & Pot -->
          <ellipse cx="100" cy="175" rx="55" ry="12" fill="#78350F"/>
          <path d="M55 175 L65 125 L135 125 L145 175 Z" fill="#B45309" stroke="#78350F" stroke-width="3"/>
          <ellipse cx="100" cy="125" rx="35" ry="8" fill="#5A2807"/>

          <!-- Animated Water Drops -->
          <g id="plant-water-drops" style="opacity: 0; transition: opacity 0.3s ease;">
            <circle cx="92" cy="115" r="3" fill="#38BDF8" style="animation: waterDripDrop 1.2s infinite;"/>
            <circle cx="106" cy="110" r="3.5" fill="#0284C7" style="animation: waterDripDrop 1.2s infinite 0.4s;"/>
            <circle cx="100" cy="122" r="2.8" fill="#38BDF8" style="animation: waterDripDrop 1.2s infinite 0.8s;"/>
          </g>
          
          <!-- Stem with dynamic bend -->
          <path id="plant-stem" d="M 100 125 Q 125 95 130 65" stroke="#84CC16" stroke-width="7" stroke-linecap="round" fill="none" style="transition: all 0.4s ease;"/>
          
          <!-- Leaves -->
          <path id="leaf-left" d="M 110 105 Q 85 95 78 108 Q 95 115 110 105" fill="#EAB308" stroke="#713F12" stroke-width="1.5" style="transition: all 0.4s ease;"/>
          <path id="leaf-right" d="M 120 85 Q 145 75 150 90 Q 135 98 120 85" fill="#EAB308" stroke="#713F12" stroke-width="1.5" style="transition: all 0.4s ease;"/>
          
          <!-- Flower Head -->
          <g id="flower-head" transform="translate(130, 65)" style="transition: all 0.4s ease;">
            <!-- Petals -->
            <circle cx="0" cy="-14" r="9" fill="#FBBF24" opacity="0.8"/>
            <circle cx="14" cy="0" r="9" fill="#FBBF24" opacity="0.8"/>
            <circle cx="0" cy="14" r="9" fill="#FBBF24" opacity="0.8"/>
            <circle cx="-14" cy="0" r="9" fill="#FBBF24" opacity="0.8"/>
            <circle cx="10" cy="-10" r="8" fill="#FDE047"/>
            <circle cx="-10" cy="-10" r="8" fill="#FDE047"/>
            <circle cx="10" cy="10" r="8" fill="#FDE047"/>
            <circle cx="-10" cy="10" r="8" fill="#FDE047"/>
            <!-- Flower Center -->
            <circle cx="0" cy="0" r="11" fill="#78350F"/>
            <!-- Smile -->
            <path id="flower-mouth" d="M -5 3 Q 0 0 5 3" stroke="#FEF08A" stroke-width="2" fill="none" stroke-linecap="round"/>

            <!-- Bloom Sparkles (shown when healthy) -->
            <g id="flower-sparkles" style="opacity: 0; transition: opacity 0.5s ease;">
              <text x="-26" y="-18" font-size="13" style="animation: sparkleTwinkle 1.8s infinite;">✨</text>
              <text x="18" y="-18" font-size="13" style="animation: sparkleTwinkle 2s infinite 0.5s;">⭐</text>
              <text x="-22" y="24" font-size="13" style="animation: sparkleTwinkle 1.6s infinite 0.9s;">✨</text>
            </g>
          </g>
        </svg>

        <div id="plant-status-text" style="font-family: var(--font-heading); font-size: var(--fs-md); font-weight: 700; color: #DC2626; margin-top: var(--space-2); transition: color 0.3s ease;">
          Bunga Sedang Layu 🥀
        </div>

        <div class="plant-gauges-row">
          <div class="gauge-item">
            <div class="gauge-title">💧 Air Tanah</div>
            <div class="gauge-value" id="val-water" style="color: #2563EB;">15%</div>
          </div>
          <div class="gauge-item">
            <div class="gauge-title">☀️ Sinar Matahari</div>
            <div class="gauge-value" id="val-sun" style="color: #D97706;">20%</div>
          </div>
          <div class="gauge-item">
            <div class="gauge-title">🌿 Kesehatan</div>
            <div class="gauge-value" id="val-health" style="color: #DC2626;">20%</div>
          </div>
        </div>
      </div>
    `;

    // Render Controls
    controlsEl.innerHTML = `
      <div class="tool-control-item">
        <label class="tool-label">
          <span>💧 Siram Air Tanah</span>
          <span id="label-slider-water">15%</span>
        </label>
        <input type="range" min="0" max="100" value="15" class="kid-slider" id="slider-water">
        <span style="font-size: var(--fs-xs); color: var(--text-light);">
          Target ideal tanaman: 60% – 85%
        </span>
      </div>

      <div class="tool-control-item">
        <label class="tool-label">
          <span>☀️ Buka Tirai Sinar Matahari</span>
          <span id="label-slider-sun">20%</span>
        </label>
        <input type="range" min="0" max="100" value="20" class="kid-slider" id="slider-sun" style="accent-color: #F59E0B;">
        <span style="font-size: var(--fs-xs); color: var(--text-light);">
          Target ideal cahaya: 65% – 90%
        </span>
      </div>
    `;

    // Bind event listeners
    const sliderWater = document.getElementById('slider-water');
    const sliderSun = document.getElementById('slider-sun');

    const updateSimulation = () => {
      this.state.water = parseInt(sliderWater.value);
      this.state.sunlight = parseInt(sliderSun.value);

      document.getElementById('label-slider-water').textContent = `${this.state.water}%`;
      document.getElementById('label-slider-sun').textContent = `${this.state.sunlight}%`;
      document.getElementById('val-water').textContent = `${this.state.water}%`;
      document.getElementById('val-sun').textContent = `${this.state.sunlight}%`;

      // Calculate health: optimal zone water 60-85, sun 65-90
      let waterScore = 0;
      if (this.state.water >= 60 && this.state.water <= 85) waterScore = 50;
      else if (this.state.water > 85) waterScore = Math.max(10, 50 - (this.state.water - 85) * 2);
      else waterScore = Math.max(5, (this.state.water / 60) * 50);

      let sunScore = 0;
      if (this.state.sunlight >= 65 && this.state.sunlight <= 90) sunScore = 50;
      else if (this.state.sunlight > 90) sunScore = Math.max(10, 50 - (this.state.sunlight - 90) * 2);
      else sunScore = Math.max(5, (this.state.sunlight / 65) * 50);

      this.state.health = Math.round(waterScore + sunScore);
      document.getElementById('val-health').textContent = `${this.state.health}%`;

      // Morph SVG Plant elements
      const stem = document.getElementById('plant-stem');
      const head = document.getElementById('flower-head');
      const leafL = document.getElementById('leaf-left');
      const leafR = document.getElementById('leaf-right');
      const mouth = document.getElementById('flower-mouth');
      const statusText = document.getElementById('plant-status-text');

      // Dynamic Sun & Water Animation Feedback
      const sunAura = document.getElementById('plant-sun-aura');
      const waterDrops = document.getElementById('plant-water-drops');
      const sparkles = document.getElementById('flower-sparkles');

      if (sunAura) {
        sunAura.style.opacity = this.state.sunlight > 30 ? Math.min(1, this.state.sunlight / 75) : '0.15';
      }
      if (waterDrops) {
        waterDrops.style.opacity = this.state.water > 35 ? Math.min(1, this.state.water / 70) : '0';
      }

      if (this.state.health >= 85) {
        // Erect, green, blooming, big smile!
        stem.setAttribute('d', 'M 100 125 Q 100 95 100 65');
        stem.setAttribute('stroke', '#16A34A');
        head.setAttribute('transform', 'translate(100, 65)');
        leafL.setAttribute('fill', '#22C55E');
        leafR.setAttribute('fill', '#22C55E');
        mouth.setAttribute('d', 'M -5 0 Q 0 5 5 0'); // Big happy smile
        statusText.textContent = "Bunga Sehat & Mekar Sempurna! 🌻✨";
        statusText.style.color = "#16A34A";
        document.getElementById('val-health').style.color = "#16A34A";
        if (sparkles) sparkles.style.opacity = '1';

        if (!this.wasBlooming) {
          this.wasBlooming = true;
          if (window.SoundFX) window.SoundFX.playSuccess();
        }
      } else if (this.state.health >= 55) {
        this.wasBlooming = false;
        if (sparkles) sparkles.style.opacity = '0';
        // Moderate recovery
        stem.setAttribute('d', 'M 100 125 Q 115 95 115 65');
        stem.setAttribute('stroke', '#84CC16');
        head.setAttribute('transform', 'translate(115, 65)');
        leafL.setAttribute('fill', '#84CC16');
        leafR.setAttribute('fill', '#84CC16');
        mouth.setAttribute('d', 'M -4 2 L 4 2'); // Neutral mouth
        statusText.textContent = "Bunga Mulai Segar... Lanjutkan! 🌱";
        statusText.style.color = "#D97706";
        document.getElementById('val-health').style.color = "#D97706";
      } else {
        this.wasBlooming = false;
        if (sparkles) sparkles.style.opacity = '0';
        // Wilted
        stem.setAttribute('d', 'M 100 125 Q 125 95 130 65');
        stem.setAttribute('stroke', '#CA8A04');
        head.setAttribute('transform', 'translate(130, 65)');
        leafL.setAttribute('fill', '#EAB308');
        leafR.setAttribute('fill', '#EAB308');
        mouth.setAttribute('d', 'M -5 3 Q 0 0 5 3'); // Frown
        statusText.textContent = "Bunga Masih Layu 🥀";
        statusText.style.color = "#DC2626";
        document.getElementById('val-health').style.color = "#DC2626";
      }
    };

    sliderWater.addEventListener('input', updateSimulation);
    sliderSun.addEventListener('input', updateSimulation);
  }

  // =========================================================================
  // 2. Misteri Bayangan (Discovery Lab)
  // =========================================================================
  mountShadowSimulation(canvasEl, controlsEl) {
    this.state = { torch_dist: 80, shadow_scale: 45 };

    canvasEl.innerHTML = `
      <div style="display: flex; flex-direction: column; align-items: center; width: 100%;">
        <div style="position: relative; width: 300px; height: 200px; background: #0F172A; border-radius: var(--radius-xl); display: flex; align-items: center; justify-content: center; overflow: hidden; border: 3px solid #334155;">
          <!-- Target outline silhouette -->
          <div style="position: absolute; width: 120px; height: 120px; border: 3px dashed #FBBF24; border-radius: 50%; opacity: 0.6; display: flex; align-items: center; justify-content: center; color: #FBBF24; font-size: var(--fs-xs); font-weight: 700;">
            Target Ukuran
          </div>
          <!-- Casted Shadow -->
          <div id="bunny-shadow" style="font-size: 45px; filter: blur(3px) drop-shadow(0 0 10px #38BDF8); transition: font-size 100ms ease;">
            🐰
          </div>
        </div>
        <div id="shadow-status" style="font-weight: 700; margin-top: var(--space-3); color: var(--text-muted);">
          Bayangan masih terlalu kecil!
        </div>
      </div>
    `;

    controlsEl.innerHTML = `
      <div class="tool-control-item">
        <label class="tool-label">
          <span>🔦 Jarak Senter ke Boneka</span>
          <span id="label-torch-dist">80 cm</span>
        </label>
        <input type="range" min="15" max="100" value="80" class="kid-slider" id="slider-torch">
        <span style="font-size: var(--fs-xs); color: var(--text-light);">
          Geser senter mendekat atau menjauh agar bayangan pas dengan garis target!
        </span>
      </div>
    `;

    const slider = document.getElementById('slider-torch');
    slider.addEventListener('input', () => {
      this.state.torch_dist = parseInt(slider.value);
      document.getElementById('label-torch-dist').textContent = `${this.state.torch_dist} cm`;

      // Closer distance = bigger shadow!
      const shadowSize = Math.round(130 - (this.state.torch_dist * 0.9));
      this.state.shadow_scale = shadowSize;
      const shadowEl = document.getElementById('bunny-shadow');
      shadowEl.style.fontSize = `${shadowSize}px`;

      const statusEl = document.getElementById('shadow-status');
      if (shadowSize >= 75 && shadowSize <= 85) {
        statusEl.textContent = "Bayangan PAS dengan panggung pentas! 🎭✨";
        statusEl.style.color = "#16A34A";
      } else if (shadowSize > 85) {
        statusEl.textContent = "Bayangan terlalu besar melewati layar!";
        statusEl.style.color = "#DC2626";
      } else {
        statusEl.textContent = "Bayangan masih terlalu kecil, dekatkan senter!";
        statusEl.style.color = "#D97706";
      }
    });
  }

  // =========================================================================
  // 3. Perjalanan Air (Discovery Lab)
  // =========================================================================
  mountWaterCycle(canvasEl, controlsEl) {
    this.state = { slots: [null, null, null] };

    canvasEl.innerHTML = `
      <div style="width: 100%; text-align: center;">
        <h4 style="margin-bottom: var(--space-3); font-size: var(--fs-md);">Alur Siklus Air Alam:</h4>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: var(--space-3); width: 100%;">
          <div class="tray-drop-zone" id="water-slot-0" data-slot="0">
            <span style="color: var(--text-light); font-size: var(--fs-xs);">1. Penguapan (Matahari)</span>
          </div>
          <div class="tray-drop-zone" id="water-slot-1" data-slot="1">
            <span style="color: var(--text-light); font-size: var(--fs-xs);">2. Pembentukan Awan</span>
          </div>
          <div class="tray-drop-zone" id="water-slot-2" data-slot="2">
            <span style="color: var(--text-light); font-size: var(--fs-xs);">3. Hujan Turun</span>
          </div>
        </div>
      </div>
    `;

    controlsEl.innerHTML = `
      <div style="font-weight: 700; font-size: var(--fs-sm); margin-bottom: var(--space-2);">
        Ketuk kartu untuk memasukkannya ke kotak siklus:
      </div>
      <div class="shopping-shelf" id="water-cards-tray">
        <button type="button" class="btn-command-card water-card-btn" data-stage="3">
          🌧️ Tetes Hujan Turun ke Danau
        </button>
        <button type="button" class="btn-command-card water-card-btn" data-stage="1">
          ☀️ Air Danau Menguap ke Langit
        </button>
        <button type="button" class="btn-command-card water-card-btn" data-stage="2">
          ☁️ Uap Air Berkumpul Menjadi Awan
        </button>
      </div>
      <button type="button" class="btn-kid btn-kid-ghost" id="btn-reset-water" style="padding: 0.4rem 1rem; font-size: var(--fs-xs);">
        Kosongkan Kotak 🔄
      </button>
    `;

    const buttons = controlsEl.querySelectorAll('.water-card-btn');
    buttons.forEach(btn => {
      btn.addEventListener('click', () => {
        const stage = parseInt(btn.dataset.stage);
        // Find first empty slot
        const emptyIdx = this.state.slots.indexOf(null);
        if (emptyIdx !== -1) {
          this.state.slots[emptyIdx] = stage;
          const slotEl = document.getElementById(`water-slot-${emptyIdx}`);
          slotEl.innerHTML = `<strong style="color: #2563EB;">${btn.textContent}</strong>`;
          btn.style.opacity = '0.4';
          btn.disabled = true;
        }
      });
    });

    document.getElementById('btn-reset-water').addEventListener('click', () => {
      this.state.slots = [null, null, null];
      for (let i = 0; i < 3; i++) {
        document.getElementById(`water-slot-${i}`).innerHTML = `<span style="color: var(--text-light); font-size: var(--fs-xs);">${i+1}. Kotak Siklus</span>`;
      }
      buttons.forEach(b => {
        b.style.opacity = '1';
        b.disabled = false;
      });
    });
  }

  // =========================================================================
  // 4. Toko Kue Donat (Number City)
  // =========================================================================
  mountBakeryShop(canvasEl, controlsEl) {
    this.state = { donutsInTray: 0, coinsInTray: 0 };

    canvasEl.innerHTML = `
      <div style="width: 100%; display: flex; flex-direction: column; align-items: center;">
        <div style="background: #FEF3C7; border: 2px solid #FCD34D; border-radius: var(--radius-xl); padding: var(--space-4); margin-bottom: var(--space-4); width: 100%; text-align: center;">
          <div style="font-size: var(--fs-sm); font-weight: 700; color: #92400E;">
            Pesanan: 2 Donat (Rp 2.000 / donat) • Pembeli bayar: Rp 5.000
          </div>
          <div style="font-size: var(--fs-xs); color: #B45309; margin-top: 4px;">
            Letakkan 2 Donat dan Uang Kembalian yang tepat di nampan!
          </div>
        </div>

        <!-- Order Tray -->
        <div class="tray-drop-zone" id="bakery-tray" style="border-color: #F59E0B; background: #FFFBEB;">
          <span id="tray-empty-hint" style="color: var(--text-muted); font-size: var(--fs-sm);">
            Nampan masih kosong. Ketuk donat dan koin kembalian di sebelah kanan!
          </span>
        </div>
      </div>
    `;

    controlsEl.innerHTML = `
      <div style="font-weight: 700; font-size: var(--fs-sm); margin-bottom: var(--space-2);">
        Pilih barang dan koin:
      </div>
      <div style="display: flex; gap: var(--space-2); flex-wrap: wrap;">
        <button type="button" class="btn-command-card" id="btn-add-donut">
          🍩 +1 Donat (Rp 2.000)
        </button>
        <button type="button" class="btn-command-card" id="btn-add-coin-500">
          🪙 +Rp 500
        </button>
        <button type="button" class="btn-command-card" id="btn-add-coin-1000">
          🪙 +Rp 1.000
        </button>
        <button type="button" class="btn-command-card" id="btn-add-coin-2000">
          🪙 +Rp 2.000
        </button>
      </div>

      <div style="display: flex; justify-content: space-between; align-items: center; margin-top: var(--space-4); font-size: var(--fs-sm); font-weight: 700;">
        <span>Donat di Nampan: <strong id="count-donuts" style="color: #D97706;">0</strong></span>
        <span>Kembalian: <strong id="count-coins" style="color: #2563EB;">Rp 0</strong></span>
      </div>

      <button type="button" class="btn-kid btn-kid-ghost" id="btn-clear-tray" style="margin-top: var(--space-3); padding: 0.4rem 1rem; font-size: var(--fs-xs);">
        Bersihkan Nampan 🔄
      </button>
    `;

    const tray = document.getElementById('bakery-tray');
    const emptyHint = document.getElementById('tray-empty-hint');
    const countD = document.getElementById('count-donuts');
    const countC = document.getElementById('count-coins');

    const updateTrayDisplay = () => {
      emptyHint.style.display = (this.state.donutsInTray === 0 && this.state.coinsInTray === 0) ? 'block' : 'none';
      countD.textContent = this.state.donutsInTray;
      countC.textContent = `Rp ${this.state.coinsInTray.toLocaleString('id-ID')}`;
    };

    document.getElementById('btn-add-donut').addEventListener('click', () => {
      this.state.donutsInTray++;
      const item = document.createElement('span');
      item.textContent = '🍩';
      item.style.fontSize = '2rem';
      tray.appendChild(item);
      updateTrayDisplay();
    });

    const addCoin = (val) => {
      this.state.coinsInTray += val;
      const item = document.createElement('span');
      item.textContent = `🪙 ${val}`;
      item.className = 'queued-card';
      item.style.background = '#F59E0B';
      tray.appendChild(item);
      updateTrayDisplay();
    };

    document.getElementById('btn-add-coin-500').addEventListener('click', () => addCoin(500));
    document.getElementById('btn-add-coin-1000').addEventListener('click', () => addCoin(1000));
    document.getElementById('btn-add-coin-2000').addEventListener('click', () => addCoin(2000));

    document.getElementById('btn-clear-tray').addEventListener('click', () => {
      this.state.donutsInTray = 0;
      this.state.coinsInTray = 0;
      tray.innerHTML = '';
      tray.appendChild(emptyHint);
      updateTrayDisplay();
    });
  }

  // =========================================================================
  // 5. Jembatan Angka (Number City)
  // =========================================================================
  mountNumberBridge(canvasEl, controlsEl) {
    this.state = { selectedValue: null };

    canvasEl.innerHTML = `
      <div style="width: 100%; text-align: center;">
        <h4 style="margin-bottom: var(--space-4);">Pola Balok Jembatan:</h4>
        <div style="display: flex; align-items: center; justify-content: center; gap: var(--space-3); flex-wrap: wrap;">
          <div class="node-number-circle" style="background: #F59E0B; color: #FFF;">3</div>
          <span style="font-size: 1.5rem; color: var(--text-light);">&rarr;</span>
          <div class="node-number-circle" style="background: #F59E0B; color: #FFF;">7</div>
          <span style="font-size: 1.5rem; color: var(--text-light);">&rarr;</span>
          <div class="node-number-circle" style="background: #F59E0B; color: #FFF;">11</div>
          <span style="font-size: 1.5rem; color: var(--text-light);">&rarr;</span>
          <div class="node-number-circle" id="bridge-missing-slot" style="background: #FFFFFF; border: 3px dashed #F59E0B; color: #F59E0B; width: 56px; height: 56px;">?</div>
          <span style="font-size: 1.5rem; color: var(--text-light);">&rarr;</span>
          <div class="node-number-circle" style="background: #F59E0B; color: #FFF;">19</div>
        </div>
      </div>
    `;

    controlsEl.innerHTML = `
      <div style="font-weight: 700; font-size: var(--fs-sm); margin-bottom: var(--space-3);">
        Pilih balok angka yang tepat untuk slot [ ? ]:
      </div>
      <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: var(--space-3);">
        <button type="button" class="btn-command-card bridge-choice-btn" data-val="13">Balok 13</button>
        <button type="button" class="btn-command-card bridge-choice-btn" data-val="14">Balok 14</button>
        <button type="button" class="btn-command-card bridge-choice-btn" data-val="15">Balok 15</button>
        <button type="button" class="btn-command-card bridge-choice-btn" data-val="16">Balok 16</button>
      </div>
    `;

    const btns = controlsEl.querySelectorAll('.bridge-choice-btn');
    btns.forEach(btn => {
      btn.addEventListener('click', () => {
        btns.forEach(b => b.style.borderColor = 'var(--border-interactive)');
        btn.style.borderColor = 'var(--color-primary)';
        this.state.selectedValue = parseInt(btn.dataset.val);
        const slot = document.getElementById('bridge-missing-slot');
        slot.textContent = this.state.selectedValue;
        slot.style.background = '#FEF3C7';
      });
    });
  }

  // =========================================================================
  // 6. Kota Pola (Number City)
  // =========================================================================
  mountCrystalPattern(canvasEl, controlsEl) {
    this.state = { selectedColor: null };

    canvasEl.innerHTML = `
      <div style="width: 100%; text-align: center;">
        <h4 style="margin-bottom: var(--space-4);">Deret Kristal Lampu Taman:</h4>
        <div style="display: flex; align-items: center; justify-content: center; gap: var(--space-2); flex-wrap: wrap;">
          <span style="font-size: 2.2rem;">🔴</span>
          <span style="font-size: 2.2rem;">🟡</span>
          <span style="font-size: 2.2rem;">🔵</span>
          <span style="font-size: 2.2rem;">🔴</span>
          <span style="font-size: 2.2rem;">🟡</span>
          <div id="crystal-slot" style="width: 50px; height: 50px; border: 3px dashed #CBD5E1; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem;">
            ?
          </div>
        </div>
      </div>
    `;

    controlsEl.innerHTML = `
      <div style="font-weight: 700; font-size: var(--fs-sm); margin-bottom: var(--space-3);">
        Pilih kristal warna berikutnya:
      </div>
      <div style="display: flex; gap: var(--space-3); flex-wrap: wrap;">
        <button type="button" class="btn-command-card crystal-choice-btn" data-color="blue">
          🔵 Kristal Biru
        </button>
        <button type="button" class="btn-command-card crystal-choice-btn" data-color="green">
          🟢 Kristal Hijau
        </button>
        <button type="button" class="btn-command-card crystal-choice-btn" data-color="purple">
          🟣 Kristal Ungu
        </button>
      </div>
    `;

    const btns = controlsEl.querySelectorAll('.crystal-choice-btn');
    btns.forEach(btn => {
      btn.addEventListener('click', () => {
        btns.forEach(b => b.style.borderColor = 'var(--border-interactive)');
        btn.style.borderColor = 'var(--color-primary)';
        this.state.selectedColor = btn.dataset.color;

        const slot = document.getElementById('crystal-slot');
        slot.textContent = btn.dataset.color === 'blue' ? '🔵' : (btn.dataset.color === 'green' ? '🟢' : '🟣');
      });
    });
  }

  // =========================================================================
  // 7. Robot Pulang (Thinking Lab)
  // =========================================================================
  mountRobotRunner(canvasEl, controlsEl) {
    this.state = {
      bot: { x: 0, y: 0, dir: 'right' },
      queue: [],
      target: { x: 2, y: 2 },
      obstacles: [{ x: 1, y: 1 }, { x: 0, y: 2 }]
    };

    canvasEl.innerHTML = `
      <div style="display: flex; flex-direction: column; align-items: center;">
        <div class="robot-grid" id="robot-grid-board"></div>
        <div style="font-size: var(--fs-xs); color: var(--text-muted); margin-top: var(--space-2);">
          🤖 Botty • ⚡ Stasiun Pengisian Daya • 🪨 Rintangan Batu
        </div>
      </div>
    `;

    controlsEl.innerHTML = `
      <div style="font-weight: 700; font-size: var(--fs-sm); margin-bottom: var(--space-2);">
        Pilih Kartu Langkah:
      </div>
      <div class="command-palette">
        <button type="button" class="btn-command-card" id="cmd-forward">⬆️ Maju</button>
        <button type="button" class="btn-command-card" id="cmd-turn-right">↪️ Belok Kanan</button>
        <button type="button" class="btn-command-card" id="cmd-turn-left">↩️ Belok Kiri</button>
      </div>

      <div style="margin-top: var(--space-4);">
        <div style="display: flex; justify-content: space-between; font-size: var(--fs-xs); font-weight: 700; margin-bottom: 4px;">
          <span>Antrean Instruksi Robot:</span>
          <button type="button" id="btn-clear-robot" style="background: none; border: none; color: #DC2626; cursor: pointer;">Hapus Semua ✕</button>
        </div>
        <div class="command-queue-tray" id="robot-queue-tray">
          <span style="color: var(--text-light); font-size: var(--fs-xs);">Belum ada kartu langkah...</span>
        </div>
      </div>
    `;

    this.renderRobotGrid();

    // Command Queue handlers
    document.getElementById('cmd-forward').addEventListener('click', () => this.addRobotCommand('FORWARD', '⬆️ Maju'));
    document.getElementById('cmd-turn-right').addEventListener('click', () => this.addRobotCommand('TURN_RIGHT', '↪️ Belok Kanan'));
    document.getElementById('cmd-turn-left').addEventListener('click', () => this.addRobotCommand('TURN_LEFT', '↩️ Belok Kiri'));
    document.getElementById('btn-clear-robot').addEventListener('click', () => {
      this.state.queue = [];
      this.state.bot = { x: 0, y: 0, dir: 'right' };
      this.renderRobotQueue();
      this.renderRobotGrid();
    });
  }

  addRobotCommand(type, label) {
    this.state.queue.push({ type, label });
    this.renderRobotQueue();
  }

  renderRobotQueue() {
    const tray = document.getElementById('robot-queue-tray');
    if (this.state.queue.length === 0) {
      tray.innerHTML = `<span style="color: var(--text-light); font-size: var(--fs-xs);">Belum ada kartu langkah...</span>`;
      return;
    }
    tray.innerHTML = '';
    this.state.queue.forEach((item, idx) => {
      const card = document.createElement('span');
      card.className = 'queued-card';
      card.id = `q-card-${idx}`;
      card.textContent = `${idx + 1}. ${item.label}`;
      tray.appendChild(card);
    });
  }

  renderRobotGrid() {
    const board = document.getElementById('robot-grid-board');
    if (!board) return;
    board.innerHTML = '';

    for (let y = 0; y < 4; y++) {
      for (let x = 0; x < 4; x++) {
        const cell = document.createElement('div');
        cell.className = 'robot-cell';
        cell.id = `cell-${x}-${y}`;

        // Check target
        if (x === this.state.target.x && y === this.state.target.y) {
          cell.classList.add('target');
          cell.textContent = '⚡';
        }
        // Check obstacles
        if (this.state.obstacles.some(ob => ob.x === x && ob.y === y)) {
          cell.classList.add('obstacle');
          cell.textContent = '🪨';
        }
        // Check bot
        if (x === this.state.bot.x && y === this.state.bot.y) {
          cell.classList.add('botty');
          cell.textContent = '🤖';
        }

        board.appendChild(cell);
      }
    }
  }

  // =========================================================================
  // 8. Jalan Rahasia (Thinking Lab)
  // =========================================================================
  mountSecretPath(canvasEl, controlsEl) {
    this.state = { chosenPath: null };

    canvasEl.innerHTML = `
      <div style="width: 100%; text-align: center;">
        <h4 style="margin-bottom: var(--space-3);">Pintu Sensor Jembatan:</h4>
        <div style="display: flex; flex-direction: column; gap: var(--space-4); max-width: 400px; margin: 0 auto;">
          <div style="background: #FEE2E2; border: 2px solid #FCA5A5; border-radius: var(--radius-lg); padding: var(--space-4);">
            🔴 <strong>Jembatan Atas: Lampu Sensor Merah (Terkunci Minyak Licin!)</strong>
          </div>
          <div style="background: #DCFCE7; border: 2px solid #86EFAC; border-radius: var(--radius-lg); padding: var(--space-4);">
            🟢 <strong>Jembatan Bawah: Lampu Sensor Hijau (Jalur Bersih Aman!)</strong>
          </div>
        </div>
      </div>
    `;

    controlsEl.innerHTML = `
      <div style="font-weight: 700; font-size: var(--fs-sm); margin-bottom: var(--space-3);">
        Pilih Jalur Aman Sesuai Aturan Logika Sensor:
      </div>
      <div style="display: flex; flex-direction: column; gap: var(--space-3);">
        <button type="button" class="btn-command-card path-btn" data-choice="atas">
          ❌ Lewat Jembatan Atas (Lampu Merah)
        </button>
        <button type="button" class="btn-command-card path-btn" data-choice="bawah">
          ✅ Lewat Jembatan Bawah (Lampu Hijau)
        </button>
      </div>
    `;

    const btns = controlsEl.querySelectorAll('.path-btn');
    btns.forEach(btn => {
      btn.addEventListener('click', () => {
        btns.forEach(b => b.style.borderColor = 'var(--border-interactive)');
        btn.style.borderColor = 'var(--color-primary)';
        this.state.chosenPath = btn.dataset.choice;
      });
    });
  }

  // =========================================================================
  // 9. Robot Mengulang / Loop (Thinking Lab)
  // =========================================================================
  mountRobotLoop(canvasEl, controlsEl) {
    this.state = { loopCount: 1, actions: [] };

    canvasEl.innerHTML = `
      <div style="width: 100%; text-align: center;">
        <h4 style="margin-bottom: var(--space-3);">Tangga 4 Anak Tangga:</h4>
        <div style="display: flex; align-items: flex-end; justify-content: center; gap: 8px; height: 160px; padding-bottom: 12px;">
          <div style="width: 50px; height: 40px; background: #93C5FD; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-weight: 700;">1</div>
          <div style="width: 50px; height: 75px; background: #60A5FA; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-weight: 700;">2</div>
          <div style="width: 50px; height: 110px; background: #3B82F6; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-weight: 700;">3</div>
          <div style="width: 50px; height: 145px; background: #1D4ED8; border-radius: 6px; display: flex; align-items: center; justify-content: center; font-weight: 700; color: #FFF;">🏆 4</div>
        </div>
      </div>
    `;

    controlsEl.innerHTML = `
      <div class="tool-control-item">
        <label class="tool-label">
          <span>🔁 Atur Kartu Pengulang (Loop)</span>
          <span id="label-loop-times">Ulangi 1x</span>
        </label>
        <input type="range" min="1" max="6" value="1" class="kid-slider" id="slider-loop">
      </div>

      <div style="margin-top: var(--space-4);">
        <span style="font-size: var(--fs-sm); font-weight: 700;">Pilih Aksi di Dalam Loop:</span>
        <div style="display: flex; gap: var(--space-2); margin-top: var(--space-2);">
          <button type="button" class="btn-command-card loop-act-btn" data-act="JUMP">Lompat ⬆️</button>
          <button type="button" class="btn-command-card loop-act-btn" data-act="FORWARD">Maju ➡️</button>
        </div>
        <div id="loop-box-display" style="background: #EEF2FF; border: 2px dashed #818CF8; border-radius: var(--radius-lg); padding: var(--space-3); margin-top: var(--space-3); font-size: var(--fs-sm); font-weight: 700; color: #3730A3;">
          Ulangi 1 Kali: (Belum ada aksi)
        </div>
      </div>
    `;

    const slider = document.getElementById('slider-loop');
    const updateLoopDisplay = () => {
      this.state.loopCount = parseInt(slider.value);
      document.getElementById('label-loop-times').textContent = `Ulangi ${this.state.loopCount}x`;
      document.getElementById('loop-box-display').textContent = 
        `Ulangi ${this.state.loopCount} Kali: (${this.state.actions.join(', ') || 'Belum ada aksi'})`;
    };

    slider.addEventListener('input', updateLoopDisplay);

    controlsEl.querySelectorAll('.loop-act-btn').forEach(b => {
      b.addEventListener('click', () => {
        const act = b.dataset.act === 'JUMP' ? 'Lompat' : 'Maju';
        if (!this.state.actions.includes(act)) {
          this.state.actions.push(act);
          updateLoopDisplay();
        }
      });
    });
  }

  // =========================================================================
  // Validation Logic for All 9 Missions
  // =========================================================================
  async validateSolution() {
    if (this.slug === 'tanaman-layu') {
      const isHealthy = (this.state.health >= 85);
      return {
        success: isHealthy,
        message: isHealthy 
          ? "Luar biasa! Bunga matahari mekar sempurna dengan air dan sinar matahari yang cukup!" 
          : "Bunga masih belum segar. Pastikan air di sekitar 70% dan buka tirai sinar matahari!"
      };
    }

    if (this.slug === 'misteri-bayangan') {
      const isMatch = (this.state.shadow_scale >= 75 && this.state.shadow_scale <= 85);
      return {
        success: isMatch,
        message: isMatch
          ? "Sempurna! Ukuran bayangan kelinci pas menutupi garis layar target!"
          : "Ukuran bayangan belum pas dengan target pentas. Geser senter lebih dekat!"
      };
    }

    if (this.slug === 'perjalanan-air') {
      const isCorrect = (JSON.stringify(this.state.slots) === JSON.stringify([1, 2, 3]));
      return {
        success: isCorrect,
        message: isCorrect
          ? "Hebat! Urutan siklus air tepat: Menguap -> Membentuk Awan -> Hujan Turun!"
          : "Urutan siklus air belum tepat. Ingat: air harus menguap dulu sebelum menjadi awan!"
      };
    }

    if (this.slug === 'toko-kue') {
      const isCorrect = (this.state.donutsInTray === 2 && this.state.coinsInTray === 1000);
      return {
        success: isCorrect,
        message: isCorrect
          ? "Tepat sekali! 2 donat seharga Rp 4.000 dengan uang Rp 5.000 mendapatkan kembalian Rp 1.000!"
          : "Hitungan kasir belum pas. Ingat: 2 donat = Rp 4.000, uang pembeli Rp 5.000, berapa kembaliannya?"
      };
    }

    if (this.slug === 'jembatan-angka') {
      const isCorrect = (this.state.selectedValue === 15);
      return {
        success: isCorrect,
        message: isCorrect
          ? "Benar! Pola deret melompat 4 (+4). 11 + 4 = 15! Jembatan tersambung!"
          : "Angka tersebut belum pas. Amati selisih lompatan angka dari 3 ke 7 (+4)!"
      };
    }

    if (this.slug === 'kota-pola') {
      const isCorrect = (this.state.selectedColor === 'blue');
      return {
        success: isCorrect,
        message: isCorrect
          ? "Sempurna! Pola kristal berulang: Merah - Kuning - Biru! Lampu taman bersinar indah!"
          : "Warna kristal belum tepat. Lihat 3 kristal pertama: Merah, Kuning, lalu apa?"
      };
    }

    if (this.slug === 'robot-pulang') {
      // Simulate playback
      let curX = 0, curY = 0, curDir = 'right';
      const dirMap = {
        'right': { dx: 1, dy: 0, right: 'down', left: 'up' },
        'down': { dx: 0, dy: 1, right: 'left', left: 'right' },
        'left': { dx: -1, dy: 0, right: 'up', left: 'down' },
        'up': { dx: 0, dy: -1, right: 'right', left: 'left' }
      };

      for (let i = 0; i < this.state.queue.length; i++) {
        const cmd = this.state.queue[i].type;
        if (cmd === 'FORWARD') {
          curX += dirMap[curDir].dx;
          curY += dirMap[curDir].dy;
        } else if (cmd === 'TURN_RIGHT') {
          curDir = dirMap[curDir].right;
        } else if (cmd === 'TURN_LEFT') {
          curDir = dirMap[curDir].left;
        }

        // Boundary check
        if (curX < 0 || curX > 3 || curY < 0 || curY > 3) {
          return { success: false, message: "Botty keluar dari arena! Kurangi langkah majunya ya!" };
        }
        // Obstacle check
        if (this.state.obstacles.some(ob => ob.x === curX && ob.y === curY)) {
          return { success: false, message: "Aduh! Botty menabrak batu rintangan. Coba belokkan arah Botty!" };
        }
      }

      this.state.bot.x = curX;
      this.state.bot.y = curY;
      this.renderRobotGrid();

      const reached = (curX === 2 && curY === 2);
      return {
        success: reached,
        message: reached
          ? "Horeee! Botty berhasil sampai ke stasiun daya baterai tepat waktu!"
          : "Botty belum sampai ke stasiun daya (⚡). Tambahkan langkah maju atau belokan!"
      };
    }

    if (this.slug === 'jalan-rahasia') {
      const isCorrect = (this.state.chosenPath === 'bawah');
      return {
        success: isCorrect,
        message: isCorrect
          ? "Pilihan cerdas! Sensor hijau membuka jalan aman melewati jembatan bawah!"
          : "Hati-hati! Jembatan atas menyala merah karena ada minyak licin!"
      };
    }

    if (this.slug === 'robot-mengulang') {
      const isCorrect = (this.state.loopCount === 4 && this.state.actions.includes('Lompat') && this.state.actions.includes('Maju'));
      return {
        success: isCorrect,
        message: isCorrect
          ? "Luar biasa! Kartu [Ulangi 4x: (Lompat, Maju)] berhasil mengantar robot ke puncak tangga!"
          : "Atur jumlah perulangan menjadi 4x dan masukkan aksi 'Lompat' serta 'Maju'!"
      };
    }

    return { success: true, message: "Tantangan selesai!" };
  }
}

window.InteractionHandler = InteractionHandler;
