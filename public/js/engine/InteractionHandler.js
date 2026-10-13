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
    } else if (this.slug === 'roket-angkasa') {
      this.mountRocketLaunch(canvasEl, controlsEl);
    } else if (this.slug === 'rasi-bintang') {
      this.mountStarConstellation(canvasEl, controlsEl);
    } else if (this.slug === 'rover-mars') {
      this.mountMarsRover(canvasEl, controlsEl);
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
        <div class="stepper-slider-row">
          <button type="button" class="btn-stepper" id="btn-water-minus" aria-label="Kurangi air tanah 5%" title="Kurangi 5%">
            −
          </button>
          <input type="range" min="0" max="100" step="5" value="15" class="kid-slider" id="slider-water" aria-label="Penggeser air tanah">
          <button type="button" class="btn-stepper" id="btn-water-plus" aria-label="Tambah air tanah 5%" title="Tambah 5%">
            +
          </button>
        </div>
        <span style="font-size: var(--fs-xs); color: var(--text-light);">
          Target ideal tanaman: 60% – 85% (Geser atau tekan tombol − / +)
        </span>
      </div>

      <div class="tool-control-item">
        <label class="tool-label">
          <span>☀️ Buka Tirai Sinar Matahari</span>
          <span id="label-slider-sun">20%</span>
        </label>
        <div class="stepper-slider-row">
          <button type="button" class="btn-stepper" id="btn-sun-minus" aria-label="Kurangi sinar matahari 5%" title="Kurangi 5%">
            −
          </button>
          <input type="range" min="0" max="100" step="5" value="20" class="kid-slider" id="slider-sun" style="accent-color: #F59E0B;" aria-label="Penggeser sinar matahari">
          <button type="button" class="btn-stepper" id="btn-sun-plus" aria-label="Tambah sinar matahari 5%" title="Tambah 5%">
            +
          </button>
        </div>
        <span style="font-size: var(--fs-xs); color: var(--text-light);">
          Target ideal cahaya: 65% – 90% (Geser atau tekan tombol − / +)
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

    document.getElementById('btn-water-minus').addEventListener('click', () => {
      sliderWater.value = Math.max(0, parseInt(sliderWater.value) - 5);
      updateSimulation();
    });
    document.getElementById('btn-water-plus').addEventListener('click', () => {
      sliderWater.value = Math.min(100, parseInt(sliderWater.value) + 5);
      updateSimulation();
    });
    document.getElementById('btn-sun-minus').addEventListener('click', () => {
      sliderSun.value = Math.max(0, parseInt(sliderSun.value) - 5);
      updateSimulation();
    });
    document.getElementById('btn-sun-plus').addEventListener('click', () => {
      sliderSun.value = Math.min(100, parseInt(sliderSun.value) + 5);
      updateSimulation();
    });
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
    const coinHistory = [];

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
        <div style="font-size: var(--fs-xs); color: var(--text-muted); margin-top: var(--space-2); text-align: center;">
          💡 <em>Tips: Ketuk langsung donat atau koin di nampan untuk membatalkan/mengambilnya kembali.</em>
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

      <div style="display: flex; justify-content: space-between; align-items: center; margin-top: var(--space-4); font-size: var(--fs-sm); font-weight: 700; flex-wrap: wrap; gap: var(--space-2);">
        <span>Donat di Nampan: <strong id="count-donuts" style="color: #D97706;">0</strong></span>
        <span>Kembalian: <strong id="count-coins" style="color: #2563EB;">Rp 0</strong></span>
      </div>

      <!-- Dedicated Subtraction / Undo Controls -->
      <div style="display: flex; gap: var(--space-2); margin-top: var(--space-3); flex-wrap: wrap;">
        <button type="button" class="btn-undo-step" id="btn-sub-donut" disabled aria-label="Ambil satu donat dari nampan">
          − Ambil 1 Donat
        </button>
        <button type="button" class="btn-undo-step" id="btn-sub-coin" disabled aria-label="Batalkan koin terakhir dari nampan">
          − Batalkan Koin Terakhir
        </button>
      </div>

      <button type="button" class="btn-kid btn-kid-ghost" id="btn-clear-tray" style="margin-top: var(--space-3); padding: 0.45rem 1rem; font-size: var(--fs-xs);">
        Bersihkan Seluruh Nampan 🔄
      </button>
    `;

    const tray = document.getElementById('bakery-tray');
    const emptyHint = document.getElementById('tray-empty-hint');
    const countD = document.getElementById('count-donuts');
    const countC = document.getElementById('count-coins');
    const btnSubDonut = document.getElementById('btn-sub-donut');
    const btnSubCoin = document.getElementById('btn-sub-coin');

    const updateTrayDisplay = () => {
      const isEmpty = (this.state.donutsInTray === 0 && this.state.coinsInTray === 0);
      emptyHint.style.display = isEmpty ? 'block' : 'none';
      countD.textContent = this.state.donutsInTray;
      countC.textContent = `Rp ${this.state.coinsInTray.toLocaleString('id-ID')}`;
      btnSubDonut.disabled = (this.state.donutsInTray <= 0);
      btnSubCoin.disabled = (this.state.coinsInTray <= 0 || coinHistory.length === 0);
    };

    document.getElementById('btn-add-donut').addEventListener('click', () => {
      this.state.donutsInTray++;
      const item = document.createElement('button');
      item.type = 'button';
      item.className = 'tray-item-clickable';
      item.dataset.type = 'donut';
      item.title = 'Ketuk donat ini untuk mengambilnya kembali';
      item.setAttribute('aria-label', 'Donat di nampan. Ketuk untuk membatalkan.');
      item.innerHTML = '🍩<span class="remove-badge" aria-hidden="true">&times;</span>';
      item.addEventListener('click', () => {
        this.state.donutsInTray = Math.max(0, this.state.donutsInTray - 1);
        item.remove();
        updateTrayDisplay();
      });
      tray.appendChild(item);
      updateTrayDisplay();
    });

    const addCoin = (val) => {
      this.state.coinsInTray += val;
      const item = document.createElement('button');
      item.type = 'button';
      item.className = 'tray-item-clickable tray-coin-clickable';
      item.dataset.type = 'coin';
      item.dataset.val = String(val);
      item.title = `Ketuk koin Rp ${val.toLocaleString('id-ID')} ini untuk mengambilnya kembali`;
      item.setAttribute('aria-label', `Koin Rp ${val}. Ketuk untuk membatalkan.`);
      item.innerHTML = `🪙 ${val}<span class="remove-badge" aria-hidden="true">&times;</span>`;
      item.addEventListener('click', () => {
        this.state.coinsInTray = Math.max(0, this.state.coinsInTray - val);
        const idx = coinHistory.lastIndexOf(item);
        if (idx !== -1) coinHistory.splice(idx, 1);
        item.remove();
        updateTrayDisplay();
      });
      tray.appendChild(item);
      coinHistory.push(item);
      updateTrayDisplay();
    };

    document.getElementById('btn-add-coin-500').addEventListener('click', () => addCoin(500));
    document.getElementById('btn-add-coin-1000').addEventListener('click', () => addCoin(1000));
    document.getElementById('btn-add-coin-2000').addEventListener('click', () => addCoin(2000));

    btnSubDonut.addEventListener('click', () => {
      if (this.state.donutsInTray > 0) {
        const donuts = tray.querySelectorAll('[data-type="donut"]');
        if (donuts.length > 0) {
          donuts[donuts.length - 1].remove();
        }
        this.state.donutsInTray = Math.max(0, this.state.donutsInTray - 1);
        updateTrayDisplay();
      }
    });

    btnSubCoin.addEventListener('click', () => {
      if (coinHistory.length > 0) {
        const lastCoin = coinHistory.pop();
        const val = parseInt(lastCoin.dataset.val || '0');
        this.state.coinsInTray = Math.max(0, this.state.coinsInTray - val);
        lastCoin.remove();
        updateTrayDisplay();
      }
    });

    document.getElementById('btn-clear-tray').addEventListener('click', () => {
      this.state.donutsInTray = 0;
      this.state.coinsInTray = 0;
      coinHistory.length = 0;
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
        <div style="display: flex; justify-content: space-between; align-items: center; font-size: var(--fs-xs); font-weight: 700; margin-bottom: 6px; flex-wrap: wrap; gap: 6px;">
          <span>Antrean Instruksi Robot:</span>
          <div style="display: flex; align-items: center; gap: var(--space-2);">
            <button type="button" class="btn-undo-step" id="btn-undo-robot" disabled title="Hapus perintah langkah paling terakhir" aria-label="Hapus langkah terakhir">
              ⌫ Hapus Langkah Terakhir
            </button>
            <button type="button" id="btn-clear-robot" style="background: none; border: none; color: #DC2626; cursor: pointer; padding: 4px 6px; font-size: 12px; font-weight: 700;" title="Kosongkan seluruh antrean">
              Hapus Semua ✕
            </button>
          </div>
        </div>
        <div class="command-queue-tray" id="robot-queue-tray">
          <span style="color: var(--text-light); font-size: var(--fs-xs);">Belum ada kartu langkah...</span>
        </div>
        <div style="font-size: 11px; color: var(--text-muted); margin-top: 4px;">
          💡 <em>Tips: Ketuk kartu langkah mana saja di antrean atau tombol "Hapus Langkah Terakhir" untuk membatalkannya.</em>
        </div>
      </div>
    `;

    this.renderRobotGrid();

    // Command Queue handlers
    document.getElementById('cmd-forward').addEventListener('click', () => this.addRobotCommand('FORWARD', '⬆️ Maju'));
    document.getElementById('cmd-turn-right').addEventListener('click', () => this.addRobotCommand('TURN_RIGHT', '↪️ Belok Kanan'));
    document.getElementById('cmd-turn-left').addEventListener('click', () => this.addRobotCommand('TURN_LEFT', '↩️ Belok Kiri'));

    document.getElementById('btn-undo-robot').addEventListener('click', () => {
      if (this.state.queue.length > 0) {
        this.state.queue.pop();
        this.state.bot = { x: 0, y: 0, dir: 'right' };
        this.renderRobotQueue();
        this.renderRobotGrid();
      }
    });

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
    const btnUndo = document.getElementById('btn-undo-robot');
    const btnClear = document.getElementById('btn-clear-robot');

    if (!tray) return;

    if (this.state.queue.length === 0) {
      tray.innerHTML = `<span style="color: var(--text-light); font-size: var(--fs-xs);">Belum ada kartu langkah...</span>`;
      if (btnUndo) btnUndo.disabled = true;
      if (btnClear) btnClear.style.opacity = '0.5';
      return;
    }

    if (btnUndo) btnUndo.disabled = false;
    if (btnClear) btnClear.style.opacity = '1';

    tray.innerHTML = '';
    this.state.queue.forEach((item, idx) => {
      const card = document.createElement('button');
      card.type = 'button';
      card.className = 'queued-card';
      card.id = `q-card-${idx}`;
      card.title = `Ketuk untuk membatalkan langkah #${idx + 1}`;
      card.setAttribute('aria-label', `Langkah #${idx + 1}: ${item.label}. Ketuk untuk menghapus.`);
      card.style.cursor = 'pointer';
      card.style.border = 'none';
      card.innerHTML = `${idx + 1}. ${item.label} <span class="remove-badge" aria-hidden="true">&times;</span>`;

      card.addEventListener('click', () => {
        this.state.queue.splice(idx, 1);
        this.state.bot = { x: 0, y: 0, dir: 'right' };
        this.renderRobotQueue();
        this.renderRobotGrid();
      });

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
  // 10. World 4: Peluncuran Roket Antariksa (Simulation)
  // =========================================================================
  mountRocketLaunch(canvasEl, controlsEl) {
    this.state = {
      fuel: 30,
      angle: 20
    };

    canvasEl.innerHTML = `
      <div style="width: 100%; max-width: 480px; position: relative; background: radial-gradient(circle at 50% 30%, #1e1b4b, #0f172a); border-radius: var(--radius-xl); padding: 1.5rem; box-shadow: inset 0 0 30px rgba(0,0,0,0.6); overflow: hidden; display: flex; flex-direction: column; align-items: center;">
        <!-- Stars Background -->
        <div style="position: absolute; inset: 0; pointer-events: none; opacity: 0.7;">
          <div style="position: absolute; top: 15%; left: 20%; font-size: 10px; color: #fff;">✦</div>
          <div style="position: absolute; top: 25%; right: 25%; font-size: 14px; color: #fbbf24;">★</div>
          <div style="position: absolute; top: 40%; left: 80%; font-size: 10px; color: #a78bfa;">✦</div>
          <div style="position: absolute; top: 10%; right: 10%; font-size: 8px; color: #fff;">✦</div>
        </div>

        <!-- Space Orbit Station Target -->
        <div style="width: 100%; display: flex; justify-content: flex-end; padding-right: 0.5rem; z-index: 2;">
          <div id="orbit-target" style="background: rgba(139, 92, 246, 0.25); border: 2px dashed #a78bfa; border-radius: 999px; padding: 6px 14px; font-size: 12px; font-weight: 700; color: #e0e7ff; display: flex; align-items: center; gap: 6px;">
            🛰️ Stasiun Orbit (45°-60° | 70-85% Bahan Bakar)
          </div>
        </div>

        <!-- Canvas Launch Stage -->
        <div style="position: relative; width: 100%; height: 210px; display: flex; align-items: flex-end; justify-content: center; margin-top: 10px;">
          <!-- Launch Platform / Ground -->
          <div style="position: absolute; bottom: 0; width: 100%; height: 24px; background: #334155; border-radius: 6px; border-top: 3px solid #64748b; display: flex; justify-content: center; align-items: center;">
            <div style="font-size: 11px; font-weight: 800; color: #94a3b8; letter-spacing: 2px;">LAUNCH PAD 04</div>
          </div>

          <!-- Rocket SVG Container (Rotates by angle) -->
          <div id="rocket-holder" style="position: relative; width: 80px; height: 160px; transform-origin: 50% 90%; transform: rotate(-20deg); transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);">
            <svg viewBox="0 0 80 160" width="80" height="160" fill="none" xmlns="http://www.w3.org/2000/svg">
              <!-- Booster flames (conditional) -->
              <g id="rocket-flames" style="opacity: 0.6; transition: opacity 0.3s ease;">
                <path d="M30 135 Q40 160 40 155 Q40 160 50 135 Z" fill="#f97316" />
                <path d="M35 135 Q40 152 40 148 Q40 152 45 135 Z" fill="#facc15" />
              </g>
              <!-- Rocket Body -->
              <path d="M40 15 C28 45 25 90 25 130 L55 130 C55 90 52 45 40 15 Z" fill="#f8fafc" stroke="#cbd5e1" stroke-width="2"/>
              <!-- Nosecone -->
              <path d="M40 15 C33 35 30 50 30 55 L50 55 C50 50 47 35 40 15 Z" fill="#ef4444" />
              <!-- Cockpit Window -->
              <circle cx="40" cy="70" r="9" fill="#38bdf8" stroke="#0284c7" stroke-width="2.5"/>
              <circle cx="38" cy="67" r="3" fill="#ffffff" opacity="0.8"/>
              <!-- Wings / Fins -->
              <path d="M25 105 L10 132 L25 130 Z" fill="#8b5cf6" />
              <path d="M55 105 L70 132 L55 130 Z" fill="#8b5cf6" />
              <!-- Engine Nozzle -->
              <rect x="33" y="130" width="14" height="6" rx="2" fill="#475569" />
            </svg>
          </div>
        </div>

        <!-- Live Metrics Readout -->
        <div style="display: flex; gap: 12px; width: 100%; justify-content: space-around; margin-top: 14px; background: rgba(15,23,42,0.8); border: 1px solid rgba(148,163,184,0.2); border-radius: var(--radius-lg); padding: 8px 12px;">
          <div style="text-align: center;">
            <div style="font-size: 11px; color: #94a3b8; font-weight: 700;">⛽ BAHAN BAKAR</div>
            <div id="readout-fuel" style="font-size: 16px; font-weight: 800; color: #facc15;">30%</div>
          </div>
          <div style="border-right: 1px solid rgba(148,163,184,0.3);"></div>
          <div style="text-align: center;">
            <div style="font-size: 11px; color: #94a3b8; font-weight: 700;">📐 SUDUT ELEVASI</div>
            <div id="readout-angle" style="font-size: 16px; font-weight: 800; color: #a78bfa;">20°</div>
          </div>
        </div>
      </div>
    `;

    controlsEl.innerHTML = `
      <div style="display: flex; flex-direction: column; gap: 1.25rem;">
        <!-- Slider 1: Fuel -->
        <div>
          <div style="display: flex; justify-content: space-between; font-weight: 700; font-size: 14px; margin-bottom: 6px;">
            <span>⛽ Level Bahan Bakar Tangki</span>
            <span id="slider-fuel-val" style="color: #d97706;">30% (Kurang)</span>
          </div>
          <input type="range" id="input-fuel" min="0" max="100" value="30" style="width: 100%; accent-color: #f59e0b; cursor: pointer;">
          <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">Target aman: 70% s/d 85% untuk menembus atmosfer</div>
        </div>

        <!-- Slider 2: Angle -->
        <div>
          <div style="display: flex; justify-content: space-between; font-weight: 700; font-size: 14px; margin-bottom: 6px;">
            <span>📐 Sudut Elevasi Luncur</span>
            <span id="slider-angle-val" style="color: #7c3aed;">20° (Terlalu Rendah)</span>
          </div>
          <input type="range" id="input-angle" min="0" max="90" value="20" style="width: 100%; accent-color: #8b5cf6; cursor: pointer;">
          <div style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">Target lintasan orbit: 45° s/d 60°</div>
        </div>
      </div>
    `;

    const rocketHolder = document.getElementById('rocket-holder');
    const rocketFlames = document.getElementById('rocket-flames');
    const readoutFuel = document.getElementById('readout-fuel');
    const readoutAngle = document.getElementById('readout-angle');
    const sliderFuelVal = document.getElementById('slider-fuel-val');
    const sliderAngleVal = document.getElementById('slider-angle-val');
    const inputFuel = document.getElementById('input-fuel');
    const inputAngle = document.getElementById('input-angle');

    const updateControls = () => {
      const f = parseInt(inputFuel.value, 10);
      const a = parseInt(inputAngle.value, 10);
      this.state.fuel = f;
      this.state.angle = a;

      readoutFuel.textContent = `${f}%`;
      readoutAngle.textContent = `${a}°`;

      const fuelOk = (f >= 70 && f <= 85);
      const angleOk = (a >= 45 && a <= 60);

      sliderFuelVal.textContent = `${f}% ${fuelOk ? '✅ (Ideal)' : (f < 70 ? '⚠️ (Kurang)' : '⚠️ (Berlebih)')}`;
      sliderFuelVal.style.color = fuelOk ? '#16a34a' : '#d97706';

      sliderAngleVal.textContent = `${a}° ${angleOk ? '✅ (Ideal)' : (a < 45 ? '⚠️ (Terlalu Rendah)' : '⚠️ (Terlalu Tegak)')}`;
      sliderAngleVal.style.color = angleOk ? '#16a34a' : '#7c3aed';

      if (rocketHolder) {
        rocketHolder.style.transform = `rotate(-${a}deg)`;
      }
      if (rocketFlames) {
        rocketFlames.style.opacity = f > 20 ? '1' : '0.2';
      }
    };

    inputFuel.addEventListener('input', updateControls);
    inputAngle.addEventListener('input', updateControls);
    updateControls();
  }

  // =========================================================================
  // 11. World 4: Peta Koordinat Rasi Bintang (Match & Sort)
  // =========================================================================
  mountStarConstellation(canvasEl, controlsEl) {
    this.state = {
      selectedValue: null
    };

    canvasEl.innerHTML = `
      <div style="width: 100%; max-width: 480px; background: #090d16; border-radius: var(--radius-xl); padding: 1.25rem; box-shadow: 0 10px 25px rgba(0,0,0,0.4); display: flex; flex-direction: column; align-items: center; border: 2px solid #1e293b;">
        <div style="font-weight: 800; font-size: 14px; color: #94a3b8; letter-spacing: 1px; margin-bottom: 8px;">
          🔭 RADAR TELESKOP ANTARIKSA (GRID X - Y)
        </div>

        <svg viewBox="0 0 320 280" width="100%" height="250" style="background: radial-gradient(circle, #131d33, #090d16); border-radius: var(--radius-lg);">
          <defs>
            <pattern id="radar-grid" width="35" height="30" patternUnits="userSpaceOnUse">
              <path d="M 35 0 L 0 0 0 30" fill="none" stroke="#1e293b" stroke-width="1"/>
            </pattern>
          </defs>
          <rect x="35" y="10" width="280" height="240" fill="url(#radar-grid)" />

          <line x1="35" y1="250" x2="315" y2="250" stroke="#38bdf8" stroke-width="2"/>
          <line x1="35" y1="250" x2="35" y2="10" stroke="#38bdf8" stroke-width="2"/>

          ${[0, 1, 2, 3, 4, 5, 6, 7, 8].map(i => `
            <text x="${35 + i * 35}" y="268" font-size="11" fill="${i === 4 ? '#f59e0b' : '#64748b'}" font-weight="${i === 4 ? 'bold' : 'normal'}" text-anchor="middle">${i}</text>
          `).join('')}

          ${[0, 1, 2, 3, 4, 5, 6, 7, 8].map(j => `
            <text x="24" y="${254 - j * 30}" font-size="11" fill="${j === 6 ? '#f59e0b' : '#64748b'}" font-weight="${j === 6 ? 'bold' : 'normal'}" text-anchor="middle">${j}</text>
          `).join('')}

          <line x1="175" y1="70" x2="175" y2="250" stroke="#f59e0b" stroke-width="1.5" stroke-dasharray="4,4" opacity="0.85"/>
          <line x1="175" y1="70" x2="35" y2="70" stroke="#f59e0b" stroke-width="1.5" stroke-dasharray="4,4" opacity="0.85"/>

          <g id="star-polaris" transform="translate(175, 70)">
            <circle cx="0" cy="0" r="14" fill="#fbbf24" opacity="0.3" style="animation: pulseGold 2s infinite;"/>
            <circle cx="0" cy="0" r="6" fill="#fef08a" stroke="#d97706" stroke-width="1.5"/>
            <text x="14" y="4" font-size="12" font-weight="800" fill="#fef08a">🌟 Polaris</text>
          </g>

          <circle cx="105" cy="130" r="3" fill="#94a3b8" opacity="0.6"/>
          <circle cx="245" cy="190" r="3" fill="#94a3b8" opacity="0.6"/>
          <circle cx="70" cy="40" r="2.5" fill="#94a3b8" opacity="0.5"/>
        </svg>

        <div style="font-size: 13px; color: #cbd5e1; margin-top: 8px; text-align: center;">
          Garis putus-putus emas mengarah dari <strong>Polaris</strong> ke Sumbu X mendatar dan Sumbu Y tegak.
        </div>
      </div>
    `;

    const choices = [
      { val: '4,6', label: 'Koordinat (X: 4, Y: 6)' },
      { val: '6,4', label: 'Koordinat (X: 6, Y: 4)' },
      { val: '2,5', label: 'Koordinat (X: 2, Y: 5)' },
      { val: '5,3', label: 'Koordinat (X: 5, Y: 3)' }
    ];

    controlsEl.innerHTML = `
      <div>
        <label style="display: block; font-weight: 700; font-size: 14px; margin-bottom: 10px;">
          Pilih Koordinat Titik Bintang Polaris:
        </label>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 10px;" id="star-choices-grid">
          ${choices.map(c => `
            <button type="button" class="btn-kid btn-kid-ghost star-choice-btn" data-val="${c.val}" style="padding: 0.8rem 0.6rem; font-size: 13px; font-weight: 700; text-align: center; border-radius: var(--radius-lg);">
              ${c.label}
            </button>
          `).join('')}
        </div>
      </div>
    `;

    const btns = controlsEl.querySelectorAll('.star-choice-btn');
    btns.forEach(btn => {
      btn.addEventListener('click', () => {
        btns.forEach(b => {
          b.classList.remove('btn-kid-primary');
          b.classList.add('btn-kid-ghost');
        });
        btn.classList.remove('btn-kid-ghost');
        btn.classList.add('btn-kid-primary');
        this.state.selectedValue = btn.dataset.val;
      });
    });
  }

  // =========================================================================
  // 12. World 4: Petualangan Rover Penjelajah Mars (Sequence & Logic)
  // =========================================================================
  mountMarsRover(canvasEl, controlsEl) {
    this.state = {
      commands: [],
      rover: { x: 0, y: 0 }
    };

    const renderMarsGrid = () => {
      canvasEl.innerHTML = `
        <div style="width: 100%; max-width: 480px; background: #451a03; border: 3px solid #78350f; border-radius: var(--radius-xl); padding: 1.25rem; box-shadow: 0 10px 25px rgba(0,0,0,0.5); display: flex; flex-direction: column; align-items: center;">
          <div style="font-weight: 800; font-size: 14px; color: #fdba74; letter-spacing: 1px; margin-bottom: 10px;">
            🪐 PERMUKAAN MARS (GRID 3 x 2)
          </div>

          <div style="display: grid; grid-template-columns: repeat(3, 110px); grid-template-rows: repeat(2, 95px); gap: 10px; background: #7c2d12; padding: 10px; border-radius: var(--radius-lg);">
            <!-- Cell [0,0] -->
            <div id="mars-cell-0-0" style="background: #9a3412; border: 2px solid #ea580c; border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative;">
              <span style="font-size: 10px; color: #fed7aa; position: absolute; top: 4px; left: 6px;">[0, 0]</span>
              ${this.state.rover.x === 0 && this.state.rover.y === 0 ? '<div style="font-size: 2.2rem; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.4));">🤖</div><span style="font-size: 10px; font-weight: 800; color: #fff;">ROVER</span>' : '<span style="font-size: 11px; color: #fed7aa;">Mulai</span>'}
            </div>

            <!-- Cell [1,0]: Hazard Meteor Crater! -->
            <div id="mars-cell-1-0" style="background: #450a0a; border: 2px dashed #ef4444; border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative;">
              <span style="font-size: 10px; color: #fca5a5; position: absolute; top: 4px; left: 6px;">[1, 0]</span>
              ${this.state.rover.x === 1 && this.state.rover.y === 0 ? '<div style="font-size: 2.2rem;">💥</div>' : '<div style="font-size: 1.8rem;">🌋</div><span style="font-size: 10px; font-weight: 800; color: #f87171;">KAWAH BAHAYA</span>'}
            </div>

            <!-- Cell [2,0] -->
            <div id="mars-cell-2-0" style="background: #9a3412; border: 2px solid #c2410c; border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative;">
              <span style="font-size: 10px; color: #fed7aa; position: absolute; top: 4px; left: 6px;">[2, 0]</span>
              ${this.state.rover.x === 2 && this.state.rover.y === 0 ? '<div style="font-size: 2.2rem;">🤖</div>' : '<span style="font-size: 11px; color: #fdba74;">Batu Pasir</span>'}
            </div>

            <!-- Cell [0,1] -->
            <div id="mars-cell-0-1" style="background: #9a3412; border: 2px solid #ea580c; border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative;">
              <span style="font-size: 10px; color: #fed7aa; position: absolute; top: 4px; left: 6px;">[0, 1]</span>
              ${this.state.rover.x === 0 && this.state.rover.y === 1 ? '<div style="font-size: 2.2rem;">🤖</div>' : '<span style="font-size: 11px; color: #fed7aa;">Jalur Aman</span>'}
            </div>

            <!-- Cell [1,1] -->
            <div id="mars-cell-1-1" style="background: #9a3412; border: 2px solid #ea580c; border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative;">
              <span style="font-size: 10px; color: #fed7aa; position: absolute; top: 4px; left: 6px;">[1, 1]</span>
              ${this.state.rover.x === 1 && this.state.rover.y === 1 ? '<div style="font-size: 2.2rem;">🤖</div>' : '<span style="font-size: 11px; color: #fed7aa;">Jalur Aman</span>'}
            </div>

            <!-- Cell [2,1]: Target Research Base! -->
            <div id="mars-cell-2-1" style="background: #064e3b; border: 2px solid #10b981; border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative;">
              <span style="font-size: 10px; color: #a7f3d0; position: absolute; top: 4px; left: 6px;">[2, 1]</span>
              ${this.state.rover.x === 2 && this.state.rover.y === 1 ? '<div style="font-size: 2.2rem;">🎉🤖</div><span style="font-size: 10px; font-weight: 800; color: #6ee7b7;">SAMPAI!</span>' : '<div style="font-size: 1.8rem;">🏛️</div><span style="font-size: 10px; font-weight: 800; color: #34d399;">STASIUN RISET</span>'}
            </div>
          </div>
        </div>
      `;
    };

    const updateControlsUI = () => {
      const queueList = document.getElementById('rover-cmd-queue');
      if (queueList) {
        if (this.state.commands.length === 0) {
          queueList.innerHTML = '<span style="color: var(--text-muted); font-size: 13px;">Belum ada instruksi. Klik tombol arah di bawah!</span>';
        } else {
          queueList.innerHTML = this.state.commands.map((cmd, idx) => `
            <span class="badge-pill badge-pill-primary" style="font-size: 12px; padding: 4px 8px;">
              ${idx + 1}. ${cmd === 'DOWN' ? '⬇️ Bawah' : cmd === 'RIGHT' ? '➡️ Kanan' : cmd === 'UP' ? '⬆️ Atas' : '⬅️ Kiri'}
            </span>
          `).join(' ');
        }
      }
    };

    this.renderMarsGrid = renderMarsGrid;
    renderMarsGrid();

    controlsEl.innerHTML = `
      <div style="display: flex; flex-direction: column; gap: 12px;">
        <div>
          <label style="display: block; font-weight: 700; font-size: 14px; margin-bottom: 6px;">
            Antrean Instruksi Navigasi Rover:
          </label>
          <div id="rover-cmd-queue" style="min-height: 44px; background: #fff; border: 2px dashed var(--border-subtle); border-radius: var(--radius-lg); padding: 8px 12px; display: flex; flex-wrap: wrap; gap: 6px; align-items: center;">
          </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 8px;">
          <button type="button" class="btn-kid btn-kid-ghost rover-btn-action" data-dir="DOWN" style="font-weight: 700; font-size: 14px; padding: 0.7rem;">
            ⬇️ Turun ke Bawah
          </button>
          <button type="button" class="btn-kid btn-kid-ghost rover-btn-action" data-dir="RIGHT" style="font-weight: 700; font-size: 14px; padding: 0.7rem;">
            ➡️ Belok ke Kanan
          </button>
          <button type="button" class="btn-kid btn-kid-ghost rover-btn-action" data-dir="UP" style="font-weight: 700; font-size: 14px; padding: 0.7rem;">
            ⬆️ Naik ke Atas
          </button>
          <button type="button" class="btn-kid btn-kid-ghost rover-btn-action" data-dir="LEFT" style="font-weight: 700; font-size: 14px; padding: 0.7rem;">
            ⬅️ Geser ke Kiri
          </button>
        </div>

        <button type="button" class="btn-kid btn-kid-ghost" id="btn-rover-reset" style="font-size: 13px; color: #dc2626; border-color: #fca5a5;">
          🔄 Hapus / Ulangi Langkah
        </button>
      </div>
    `;

    controlsEl.querySelectorAll('.rover-btn-action').forEach(b => {
      b.addEventListener('click', () => {
        if (this.state.commands.length < 8) {
          this.state.commands.push(b.dataset.dir);
          updateControlsUI();
        }
      });
    });

    document.getElementById('btn-rover-reset').addEventListener('click', () => {
      this.state.commands = [];
      this.state.rover = { x: 0, y: 0 };
      renderMarsGrid();
      updateControlsUI();
    });

    updateControlsUI();
  }

  // =========================================================================
  // Validation Logic for All Missions
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

    if (this.slug === 'roket-angkasa') {
      const fuelOk = (this.state.fuel >= 70 && this.state.fuel <= 85);
      const angleOk = (this.state.angle >= 45 && this.state.angle <= 60);
      const isCorrect = (fuelOk && angleOk);
      return {
        success: isCorrect,
        message: isCorrect
          ? "Luar biasa! Roket melesat sempurna menembus atmosfer dan berlabuh di stasiun orbit! 🚀"
          : (!fuelOk && !angleOk 
              ? "Bahan bakar dan sudut luncur belum pas. Sesuaikan bahan bakar (70-85%) dan sudut (45-60°)."
              : (!fuelOk ? "Bahan bakar belum pas! Pastikan tangki roket terisi antara 70% sampai 85%." : "Sudut luncur belum pas! Arahkan moncong roket antara 45° sampai 60°."))
      };
    }

    if (this.slug === 'rasi-bintang') {
      const isCorrect = (this.state.selectedValue === '4,6');
      return {
        success: isCorrect,
        message: isCorrect
          ? "Tepat sekali! Bintang Polaris berada pada koordinat X: 4 dan Y: 6 di radar teleskop! ✨"
          : "Koordinat belum tepat. Tarik garis ke sumbu mendatar X lalu ke sumbu tegak Y!"
      };
    }

    if (this.slug === 'rover-mars') {
      let curX = 0, curY = 0;
      for (const cmd of this.state.commands) {
        if (cmd === 'DOWN') curY++;
        else if (cmd === 'RIGHT') curX++;
        else if (cmd === 'UP') curY--;
        else if (cmd === 'LEFT') curX--;

        if (curX === 1 && curY === 0) {
          this.state.rover = { x: 1, y: 0 };
          if (this.renderMarsGrid) this.renderMarsGrid();
          return { success: false, message: "Awas! Rover terperosok ke dalam kawah meteor di posisi (1,0)! Pilih jalur bawah yang aman." };
        }
        if (curX < 0 || curX > 2 || curY < 0 || curY > 1) {
          return { success: false, message: "Rover keluar dari zona aman peta penjelajahan!" };
        }
      }
      this.state.rover = { x: curX, y: curY };
      if (this.renderMarsGrid) this.renderMarsGrid();
      const reached = (curX === 2 && curY === 1);
      return {
        success: reached,
        message: reached
          ? "Hebat! Rover penjelajah Mars berhasil sampai ke Stasiun Riset tanpa hambatan! 🤖"
          : "Rover belum sampai di Stasiun Riset (2,1). Rencanakan rute: Bawah -> Kanan -> Kanan!"
      };
    }

    return { success: true, message: "Tantangan selesai!" };
  }

  getSolutionPayload() {
    if (this.slug === 'tanaman-layu') {
      return {
        water: this.state.water ?? 0,
        sunlight: this.state.sunlight ?? 0
      };
    }
    if (this.slug === 'misteri-bayangan') {
      return {
        torch_distance: this.state.torch_dist ?? 80
      };
    }
    if (this.slug === 'perjalanan-air') {
      return {
        sequence: Array.isArray(this.state.slots) ? this.state.slots : []
      };
    }
    if (this.slug === 'toko-kue') {
      return {
        donuts: this.state.donutsInTray ?? 0,
        change: this.state.coinsInTray ?? 0
      };
    }
    if (this.slug === 'jembatan-angka') {
      return {
        selected_value: this.state.selectedValue ?? null
      };
    }
    if (this.slug === 'kota-pola') {
      return {
        selected_color: this.state.selectedColor ?? null
      };
    }
    if (this.slug === 'robot-pulang') {
      return {
        command_queue: Array.isArray(this.state.queue) 
          ? this.state.queue.map(cmd => typeof cmd === 'string' ? cmd : (cmd.type || ''))
          : []
      };
    }
    if (this.slug === 'jalan-rahasia') {
      return {
        chosen_path: this.state.chosenPath ?? null
      };
    }
    if (this.slug === 'robot-mengulang') {
      return {
        loop_count: this.state.loopCount ?? 1,
        actions: Array.isArray(this.state.actions) ? this.state.actions : []
      };
    }
    if (this.slug === 'roket-angkasa') {
      return {
        fuel: this.state.fuel ?? 0,
        angle: this.state.angle ?? 0
      };
    }
    if (this.slug === 'rasi-bintang') {
      return {
        selected_value: this.state.selectedValue ?? null
      };
    }
    if (this.slug === 'rover-mars') {
      return {
        commands: Array.isArray(this.state.commands) ? this.state.commands : []
      };
    }
    return {};
  }
}

window.InteractionHandler = InteractionHandler;
