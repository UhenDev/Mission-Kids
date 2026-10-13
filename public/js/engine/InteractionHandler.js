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

    // 1. Interactive Bakery Storefront Canvas
    canvasEl.innerHTML = `
      <div style="width: 100%; max-width: 480px; position: relative; background: linear-gradient(180deg, #FFF7ED 0%, #FED7AA 100%); border: 3px solid #F97316; border-radius: var(--radius-2xl); box-shadow: 0 10px 25px rgba(249, 115, 22, 0.15); overflow: hidden; display: flex; flex-direction: column; align-items: center;">
        
        <!-- Bakery Awning Canopy -->
        <div style="width: 100%; height: 26px; background: repeating-linear-gradient(90deg, #EF4444, #EF4444 24px, #FFFFFF 24px, #FFFFFF 48px); border-bottom: 3px solid #B91C1C; box-shadow: 0 4px 6px rgba(0,0,0,0.06); position: relative;">
          <div style="position: absolute; bottom: -8px; left: 0; width: 100%; height: 8px; background: repeating-linear-gradient(90deg, #DC2626, #DC2626 24px, #F1F5F9 24px, #F1F5F9 48px); border-radius: 0 0 8px 8px;"></div>
        </div>

        <!-- Store Header & Customer Bella -->
        <div style="width: 100%; padding: 12px 16px 6px; display: flex; align-items: center; justify-content: space-between; gap: 12px;">
          <!-- Bella Character SVG -->
          <div style="display: flex; align-items: center; gap: 10px;">
            <div id="bella-avatar" style="width: 60px; height: 60px; min-width: 60px; background: #FEF08A; border: 3px solid #CA8A04; border-radius: 50%; display: flex; align-items: center; justify-content: center; position: relative; box-shadow: 0 4px 10px rgba(0,0,0,0.08); transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);">
              <svg viewBox="0 0 60 60" width="50" height="50" fill="none" xmlns="http://www.w3.org/2000/svg">
                <!-- Chef Hat -->
                <path d="M22 14 C18 6 32 6 30 14 C38 6 44 14 38 18 L22 18 Z" fill="#FFFFFF" stroke="#CBD5E1" stroke-width="1.5"/>
                <!-- Bunny Ears -->
                <ellipse cx="20" cy="18" rx="4" ry="12" fill="#FFFFFF" stroke="#CA8A04" stroke-width="1.5" transform="rotate(-15 20 18)"/>
                <ellipse cx="20" cy="18" rx="2" ry="8" fill="#F472B6"/>
                <ellipse cx="40" cy="18" rx="4" ry="12" fill="#FFFFFF" stroke="#CA8A04" stroke-width="1.5" transform="rotate(15 40 18)"/>
                <ellipse cx="40" cy="18" rx="2" ry="8" fill="#F472B6"/>
                <!-- Bunny Face -->
                <circle cx="30" cy="35" r="16" fill="#FFFFFF" stroke="#CA8A04" stroke-width="2"/>
                <!-- Cheeks -->
                <ellipse cx="20" cy="38" rx="3" ry="1.8" fill="#F472B6" opacity="0.6"/>
                <ellipse cx="40" cy="38" rx="3" ry="1.8" fill="#F472B6" opacity="0.6"/>
                <!-- Eyes & Mouth -->
                <circle cx="24" cy="32" r="2.2" fill="#1E293B"/>
                <circle cx="36" cy="32" r="2.2" fill="#1E293B"/>
                <path d="M28 36 Q30 38 32 36" stroke="#CA8A04" stroke-width="2" stroke-linecap="round"/>
              </svg>
              <!-- Money Note in Paw -->
              <div style="position: absolute; bottom: -2px; right: -4px; background: #22C55E; color: #FFFFFF; font-size: 9px; font-weight: 800; padding: 2px 5px; border-radius: 4px; border: 1.5px solid #15803D; box-shadow: 0 2px 4px rgba(0,0,0,0.15);">
                💵 5.000
              </div>
            </div>

            <!-- Dynamic Customer Speech Bubble -->
            <div id="bella-bubble" style="background: #FFFFFF; border: 2px solid #F59E0B; border-radius: 14px; padding: 8px 12px; font-size: 13px; font-weight: 700; color: #78350F; position: relative; box-shadow: 0 2px 8px rgba(245, 158, 11, 0.15); line-height: 1.35; max-width: 250px;">
              "Halo Kak Kasir! 🐰 Aku mau beli 2 donat ya. Ini uang Rp 5.000!"
              <div style="position: absolute; left: -8px; top: 20px; width: 0; height: 0; border-top: 6px solid transparent; border-bottom: 6px solid transparent; border-right: 8px solid #F59E0B;"></div>
            </div>
          </div>
        </div>

        <!-- Live Cash Register POS Display -->
        <div style="width: calc(100% - 24px); margin: 6px 12px 10px; background: #0F172A; border: 2px solid #334155; border-radius: var(--radius-lg); padding: 8px 14px; display: flex; align-items: center; justify-content: space-between; box-shadow: inset 0 2px 6px rgba(0,0,0,0.5);">
          <div>
            <div style="font-size: 10px; font-weight: 800; color: #94A3B8; letter-spacing: 0.5px;">MESIN KASIR DIGITAL</div>
            <div style="font-size: 13px; font-weight: 700; color: #F8FAFC;">
              Total: <span id="reg-total-price" style="color: #FBBF24;">0 Donat (Rp 0)</span>
            </div>
          </div>
          <div style="text-align: right;">
            <div style="font-size: 10px; font-weight: 800; color: #94A3B8;">KEMBALIAN DI NAMPAN</div>
            <div style="display: flex; align-items: center; gap: 6px; justify-content: flex-end;">
              <span id="reg-change-status" style="width: 8px; height: 8px; border-radius: 50%; background: #EF4444; display: inline-block;"></span>
              <span id="reg-change-display" style="font-size: 14px; font-weight: 800; color: #38BDF8;">Rp 0</span>
            </div>
          </div>
        </div>

        <!-- Serving Plate & Counter Tray -->
        <div style="width: calc(100% - 24px); min-height: 140px; margin-bottom: 14px; background: #FFFFFF; border: 3px dashed #F59E0B; border-radius: var(--radius-xl); padding: 12px; display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative; box-shadow: inset 0 2px 8px rgba(0,0,0,0.04);">
          
          <div id="tray-empty-hint" style="color: #94A3B8; font-size: 13px; font-weight: 600; text-align: center;">
            🍽️ Nampan Saji Kosong<br>
            <span style="font-size: 11px; color: #64748B;">Ketuk Donat & Koin di bawah untuk menaruhnya ke nampan!</span>
          </div>

          <!-- Items in Tray -->
          <div id="bakery-tray-items" style="width: 100%; display: flex; flex-wrap: wrap; gap: 10px; align-items: center; justify-content: center;"></div>

          <div style="position: absolute; bottom: 4px; font-size: 10px; color: #94A3B8; font-weight: 600;">
            💡 Ketuk donat atau koin di nampan untuk mengambilnya kembali
          </div>
        </div>
      </div>
    `;

    // 2. Interactive Action Controls (Bakery Shelf & Cash Drawer)
    controlsEl.innerHTML = `
      <div style="display: flex; flex-direction: column; gap: 12px;">
        
        <!-- Section 1: Fresh Donut Shelf -->
        <div>
          <div style="font-weight: 800; font-size: 13px; color: #92400E; margin-bottom: 6px; display: flex; align-items: center; gap: 6px;">
            <span>🍩 RAK ETALASE DONAT SEGAR</span>
            <span class="badge-pill badge-pill-accent" style="font-size: 10px; padding: 1px 6px;">Rp 2.000 / Donat</span>
          </div>
          
          <button type="button" id="btn-add-donut" class="btn-kid btn-kid-primary" style="width: 100%; padding: 0.8rem 1rem; font-size: 15px; font-weight: 800; background: linear-gradient(135deg, #F97316, #EA580C); border: none; box-shadow: 0 4px 10px rgba(234, 88, 12, 0.3); display: flex; align-items: center; justify-content: center; gap: 8px;">
            <span style="font-size: 20px;">🍩</span>
            <span>+ Ambil 1 Donat Cokelat Meses</span>
          </button>
        </div>

        <!-- Section 2: Cash Register Coin Drawer -->
        <div>
          <div style="font-weight: 800; font-size: 13px; color: #1E40AF; margin-bottom: 6px; display: flex; align-items: center; gap: 6px;">
            <span>🪙 LACI UANG KOIN KEMBALIAN</span>
            <span class="badge-pill badge-pill-primary" style="font-size: 10px; padding: 1px 6px;">Uang Bayar: Rp 5.000</span>
          </div>

          <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px;">
            <button type="button" id="btn-add-coin-500" class="btn-kid btn-kid-ghost" style="padding: 0.7rem 0.4rem; font-weight: 800; font-size: 13px; border-color: #CBD5E1; color: #334155; display: flex; flex-direction: column; align-items: center; gap: 2px;">
              <span style="font-size: 18px;">🪙</span>
              <span>+ Rp 500</span>
            </button>
            <button type="button" id="btn-add-coin-1000" class="btn-kid btn-kid-ghost" style="padding: 0.7rem 0.4rem; font-weight: 800; font-size: 13px; border-color: #38BDF8; color: #0284C7; background: #F0F9FF; display: flex; flex-direction: column; align-items: center; gap: 2px;" title="Koin kembalian Rp 1.000">
              <span style="font-size: 18px;">🪙</span>
              <span>+ Rp 1.000 ⭐</span>
            </button>
            <button type="button" id="btn-add-coin-2000" class="btn-kid btn-kid-ghost" style="padding: 0.7rem 0.4rem; font-weight: 800; font-size: 13px; border-color: #CBD5E1; color: #334155; display: flex; flex-direction: column; align-items: center; gap: 2px;">
              <span style="font-size: 18px;">🪙</span>
              <span>+ Rp 2.000</span>
            </button>
          </div>
        </div>

        <!-- Section 3: Undo & Reset Actions -->
        <div style="display: flex; gap: 8px; margin-top: 4px;">
          <button type="button" class="btn-kid btn-kid-ghost" id="btn-sub-donut" disabled style="flex: 1; font-size: 12px; padding: 0.5rem; color: #DC2626; border-color: #FECACA;">
            − Ambil Donat
          </button>
          <button type="button" class="btn-kid btn-kid-ghost" id="btn-sub-coin" disabled style="flex: 1; font-size: 12px; padding: 0.5rem; color: #DC2626; border-color: #FECACA;">
            − Batalkan Koin
          </button>
          <button type="button" class="btn-kid btn-kid-ghost" id="btn-clear-tray" style="flex: 1; font-size: 12px; padding: 0.5rem; color: #64748B;">
            🔄 Bersihkan
          </button>
        </div>
      </div>
    `;

    const trayItems = document.getElementById('bakery-tray-items');
    const emptyHint = document.getElementById('tray-empty-hint');
    const bellaBubble = document.getElementById('bella-bubble');
    const bellaAvatar = document.getElementById('bella-avatar');
    const regTotalPrice = document.getElementById('reg-total-price');
    const regChangeDisplay = document.getElementById('reg-change-display');
    const regChangeStatus = document.getElementById('reg-change-status');
    const btnSubDonut = document.getElementById('btn-sub-donut');
    const btnSubCoin = document.getElementById('btn-sub-coin');

    const updateDisplay = () => {
      const donuts = this.state.donutsInTray;
      const change = this.state.coinsInTray;
      const isEmpty = (donuts === 0 && change === 0);

      emptyHint.style.display = isEmpty ? 'block' : 'none';
      btnSubDonut.disabled = (donuts <= 0);
      btnSubCoin.disabled = (change <= 0 || coinHistory.length === 0);

      // Update Cash Register Display
      const totalPrice = donuts * 2000;
      regTotalPrice.textContent = `${donuts} Donat (Rp ${totalPrice.toLocaleString('id-ID')})`;
      regChangeDisplay.textContent = `Rp ${change.toLocaleString('id-ID')}`;

      // Register LED indicator
      const isTargetChange = (change === 1000);
      if (isTargetChange) {
        regChangeStatus.style.background = '#22C55E'; // Green
        regChangeDisplay.style.color = '#4ADE80';
      } else if (change > 1000) {
        regChangeStatus.style.background = '#EF4444'; // Red
        regChangeDisplay.style.color = '#F87171';
      } else {
        regChangeStatus.style.background = '#F59E0B'; // Yellow
        regChangeDisplay.style.color = '#FBBF24';
      }

      // Dynamic Character Speech Reaction
      if (donuts === 0 && change === 0) {
        bellaBubble.innerHTML = '"Halo Kak Kasir! 🐰 Aku mau beli 2 donat ya. Ini uang Rp 5.000!"';
      } else if (donuts === 1) {
        bellaBubble.innerHTML = '"Waaah donatnya wangi! 🍩 Satu donat lagi yaa!"';
      } else if (donuts === 2 && change === 0) {
        bellaBubble.innerHTML = '"Donatnya pas 2! Sekarang berapa kembalian uangku? (Uang Rp 5.000, donat Rp 4.000) 🪙"';
      } else if (donuts === 2 && change === 1000) {
        bellaBubble.innerHTML = '"Horeee! Donat 2 dan kembalian Rp 1.000 pas banget! Siap dibungkus! 🛍️✨"';
        if (bellaAvatar) {
          bellaAvatar.style.transform = 'scale(1.15) rotate(5deg)';
          setTimeout(() => { if (bellaAvatar) bellaAvatar.style.transform = 'scale(1)'; }, 350);
        }
      } else if (donuts === 2 && change > 1000) {
        bellaBubble.innerHTML = '"Wah uang kembaliannya kebanyakan, Kak! Hitung lagi yaa hehe 🪙"';
      } else if (donuts === 2 && change < 1000) {
        bellaBubble.innerHTML = '"Donat pas 2, tapi kembaliannya masih kurang nih! 🪙"';
      } else if (donuts > 2) {
        bellaBubble.innerHTML = '"Wah kebanyakan donatnya! Aku cuma pesan 2 donat kok hehe 🍩"';
      }
    };

    // Action: Add Donut with Playful Physics & Sound
    document.getElementById('btn-add-donut').addEventListener('click', () => {
      this.state.donutsInTray++;
      
      if (window.SoundFX && typeof window.SoundFX.playDonut === 'function') {
        window.SoundFX.playDonut();
      }

      const item = document.createElement('button');
      item.type = 'button';
      item.className = 'tray-item-clickable';
      item.dataset.type = 'donut';
      item.title = 'Ketuk donat ini untuk mengambilnya kembali';
      item.style.cssText = 'background: #FEF3C7; border: 2px solid #F59E0B; border-radius: 999px; padding: 6px 12px; font-size: 14px; font-weight: 800; color: #92400E; display: flex; align-items: center; gap: 6px; cursor: pointer; animation: popBounce 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);';
      item.innerHTML = '🍩 Donat Cokelat <span style="color: #EF4444; font-size: 16px;">&times;</span>';
      
      item.addEventListener('click', () => {
        this.state.donutsInTray = Math.max(0, this.state.donutsInTray - 1);
        item.remove();
        if (window.SoundFX) window.SoundFX.playTap();
        updateDisplay();
      });

      trayItems.appendChild(item);
      updateDisplay();
    });

    // Action: Add Coin with Metallic Chime & Sound
    const addCoin = (val) => {
      this.state.coinsInTray += val;

      if (window.SoundFX && typeof window.SoundFX.playCoin === 'function') {
        window.SoundFX.playCoin();
      }

      const item = document.createElement('button');
      item.type = 'button';
      item.className = 'tray-item-clickable';
      item.dataset.type = 'coin';
      item.dataset.val = String(val);
      item.title = `Ketuk koin Rp ${val.toLocaleString('id-ID')} ini untuk mengambilnya kembali`;
      item.style.cssText = 'background: #FEF9C3; border: 2px solid #EAB308; border-radius: 999px; padding: 6px 12px; font-size: 13px; font-weight: 800; color: #854D0E; display: flex; align-items: center; gap: 6px; cursor: pointer; animation: popBounce 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); box-shadow: 0 2px 6px rgba(234, 179, 8, 0.2);';
      item.innerHTML = `🪙 Rp ${val.toLocaleString('id-ID')} <span style="color: #EF4444; font-size: 16px;">&times;</span>`;

      item.addEventListener('click', () => {
        this.state.coinsInTray = Math.max(0, this.state.coinsInTray - val);
        const idx = coinHistory.lastIndexOf(item);
        if (idx !== -1) coinHistory.splice(idx, 1);
        item.remove();
        if (window.SoundFX) window.SoundFX.playTap();
        updateDisplay();
      });

      trayItems.appendChild(item);
      coinHistory.push(item);
      updateDisplay();
    };

    document.getElementById('btn-add-coin-500').addEventListener('click', () => addCoin(500));
    document.getElementById('btn-add-coin-1000').addEventListener('click', () => addCoin(1000));
    document.getElementById('btn-add-coin-2000').addEventListener('click', () => addCoin(2000));

    // Action: Undo Donut
    btnSubDonut.addEventListener('click', () => {
      if (this.state.donutsInTray > 0) {
        const donuts = trayItems.querySelectorAll('[data-type="donut"]');
        if (donuts.length > 0) {
          donuts[donuts.length - 1].remove();
        }
        this.state.donutsInTray = Math.max(0, this.state.donutsInTray - 1);
        if (window.SoundFX) window.SoundFX.playTap();
        updateDisplay();
      }
    });

    // Action: Undo Coin
    btnSubCoin.addEventListener('click', () => {
      if (coinHistory.length > 0) {
        const lastCoin = coinHistory.pop();
        const val = parseInt(lastCoin.dataset.val || '0', 10);
        this.state.coinsInTray = Math.max(0, this.state.coinsInTray - val);
        lastCoin.remove();
        if (window.SoundFX) window.SoundFX.playTap();
        updateDisplay();
      }
    });

    // Action: Clear Tray
    document.getElementById('btn-clear-tray').addEventListener('click', () => {
      this.state.donutsInTray = 0;
      this.state.coinsInTray = 0;
      coinHistory.length = 0;
      trayItems.innerHTML = '';
      if (window.SoundFX) window.SoundFX.playWobble();
      updateDisplay();
    });

    updateDisplay();
  }

  // =========================================================================
  // 5. Jembatan Angka (Number City) — Mini-Game: Petualangan Lembah Angka Botty
  // =========================================================================
  mountNumberBridge(canvasEl, controlsEl) {
    this.state = { selectedValue: null };

    // 1. Interactive Adventure Gorge Canvas
    canvasEl.innerHTML = `
      <div style="width: 100%; max-width: 520px; position: relative; background: linear-gradient(180deg, #E0F2FE 0%, #BAE6FD 55%, #7DD3FC 100%); border: 3px solid #D97706; border-radius: var(--radius-2xl); box-shadow: 0 10px 25px rgba(217, 119, 6, 0.18); overflow: hidden; display: flex; flex-direction: column; align-items: center; user-select: none;">
        
        <!-- Sky & Mountain Background with Moving Clouds -->
        <div style="position: absolute; top: 8px; left: 16px; font-size: 20px; opacity: 0.8; animation: floatGentle 4s ease-in-out infinite;">☁️</div>
        <div style="position: absolute; top: 18px; right: 28px; font-size: 16px; opacity: 0.7; animation: floatGentle 5s ease-in-out infinite 1s;">☁️</div>

        <!-- Top Header & Botty Character Dialog -->
        <div style="width: 100%; padding: 12px 14px 4px; display: flex; align-items: center; justify-content: space-between; z-index: 2;">
          <div style="display: flex; align-items: center; gap: 10px;">
            <div id="bridge-bot-badge" style="width: 50px; height: 50px; min-width: 50px; background: #FEF3C7; border: 2.5px solid #D97706; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 8px rgba(0,0,0,0.1); font-size: 26px;">
              🤖
            </div>
            <div id="bridge-bot-bubble" style="background: #FFFFFF; border: 2px solid #F59E0B; border-radius: 12px; padding: 7px 11px; font-size: 12px; font-weight: 700; color: #78350F; line-height: 1.35; max-width: 280px; box-shadow: 0 2px 6px rgba(245, 158, 11, 0.15); position: relative;">
              "Halo Penjelajah Cilik! 🎒 Jembatannya putus 1 balok. Pasangkan balok yang pas agar aku bisa menyeberang ke peti harta!"
              <div style="position: absolute; left: -7px; top: 16px; width: 0; height: 0; border-top: 5px solid transparent; border-bottom: 5px solid transparent; border-right: 7px solid #F59E0B;"></div>
            </div>
          </div>
          <button type="button" id="btn-hint-bridge" class="btn-kid btn-kid-ghost" style="padding: 4px 8px; font-size: 11px; font-weight: 800; border-color: #F59E0B; color: #B45309; background: #FFFBEB;" title="Tampilkan petunjuk pola lompatan angka">
            💡 Petunjuk Pola
          </button>
        </div>

        <!-- Main Bridge Adventure Scene -->
        <div style="width: 100%; height: 210px; position: relative; margin-top: 6px; overflow: hidden; display: flex; align-items: flex-end;">
          
          <!-- Animated River Water at Gorge Bottom -->
          <div style="position: absolute; bottom: 0; left: 0; width: 100%; height: 48px; background: linear-gradient(180deg, #0284C7 0%, #0369A1 100%); overflow: hidden; border-top: 2px solid #38BDF8;">
            <svg viewBox="0 0 500 48" preserveAspectRatio="none" style="width: 100%; height: 100%; opacity: 0.5;">
              <path d="M0,20 C125,5 175,35 250,20 C325,5 375,35 500,20 L500,48 L0,48 Z" fill="#38BDF8" style="animation: floatReverse 3s infinite alternate ease-in-out;"></path>
            </svg>
            <div style="position: absolute; bottom: 6px; left: 24%; font-size: 12px; opacity: 0.6;">🌊 🪨</div>
            <div style="position: absolute; bottom: 6px; right: 28%; font-size: 12px; opacity: 0.6;">🪨 🌊</div>
          </div>

          <!-- Left Cliff (Start Cliff) -->
          <div style="position: absolute; left: 0; bottom: 36px; width: 64px; height: 110px; background: linear-gradient(180deg, #78350F 0%, #451A03 100%); border-radius: 0 16px 0 0; border-top: 4px solid #15803D; box-shadow: 2px 0 8px rgba(0,0,0,0.2); z-index: 2;">
            <div style="position: absolute; top: -14px; left: 10px; font-size: 14px;">🚩 Mulai</div>
          </div>

          <!-- Right Cliff (Goal Cliff with Star Castle & Treasure Chest) -->
          <div style="position: absolute; right: 0; bottom: 36px; width: 72px; height: 110px; background: linear-gradient(180deg, #78350F 0%, #451A03 100%); border-radius: 16px 0 0 0; border-top: 4px solid #15803D; box-shadow: -2px 0 8px rgba(0,0,0,0.2); z-index: 2; display: flex; flex-direction: column; align-items: center; justify-content: flex-start;">
            <div id="bridge-treasure" style="font-size: 26px; margin-top: -18px; filter: drop-shadow(0 4px 6px rgba(0,0,0,0.2)); transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);">
              🎁
            </div>
            <div style="font-size: 10px; font-weight: 800; color: #FEF08A; margin-top: 4px;">Kastil Angka</div>
          </div>

          <!-- Suspension Bridge Wooden Planks Container -->
          <div style="position: absolute; bottom: 56px; left: 54px; right: 62px; height: 80px; display: flex; align-items: flex-end; justify-content: space-between; z-index: 3;">
            
            <!-- Suspension Rope Cable (SVG Arc) -->
            <svg viewBox="0 0 380 60" style="position: absolute; top: 0; left: 0; width: 100%; height: 60px; pointer-events: none; z-index: 1;">
              <path d="M 10,10 Q 190,48 370,10" fill="none" stroke="#92400E" stroke-width="3" stroke-dasharray="6,3"/>
              <!-- Vertical Suspension Ropes -->
              <line x1="40" y1="20" x2="40" y2="48" stroke="#B45309" stroke-width="2"/>
              <line x1="110" y1="36" x2="110" y2="48" stroke="#B45309" stroke-width="2"/>
              <line x1="185" y1="45" x2="185" y2="48" stroke="#B45309" stroke-width="2"/>
              <line x1="260" y1="36" x2="260" y2="48" stroke="#B45309" stroke-width="2"/>
              <line x1="335" y1="20" x2="335" y2="48" stroke="#B45309" stroke-width="2"/>
            </svg>

            <!-- Plank 1: [ 3 ] -->
            <div class="bridge-plank-node" id="plank-0" style="position: relative; width: 56px; height: 46px; background: linear-gradient(180deg, #D97706 0%, #B45309 100%); border: 2.5px solid #78350F; border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; box-shadow: 0 4px 6px rgba(0,0,0,0.25); z-index: 2;">
              <span class="bridge-jump-tag" style="position: absolute; top: -18px; font-size: 10px; font-weight: 800; color: #15803D; background: #DCFCE7; padding: 1px 5px; border-radius: 6px; border: 1px solid #86EFAC; display: none;">+4 ↗</span>
              <span style="font-size: 17px; font-weight: 900; color: #FFF; text-shadow: 0 1px 2px rgba(0,0,0,0.4);">3</span>
              <div style="width: 80%; height: 3px; background: #92400E; border-radius: 2px;"></div>
            </div>

            <!-- Plank 2: [ 7 ] -->
            <div class="bridge-plank-node" id="plank-1" style="position: relative; width: 56px; height: 46px; background: linear-gradient(180deg, #D97706 0%, #B45309 100%); border: 2.5px solid #78350F; border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; box-shadow: 0 4px 6px rgba(0,0,0,0.25); z-index: 2;">
              <span class="bridge-jump-tag" style="position: absolute; top: -18px; font-size: 10px; font-weight: 800; color: #15803D; background: #DCFCE7; padding: 1px 5px; border-radius: 6px; border: 1px solid #86EFAC; display: none;">+4 ↗</span>
              <span style="font-size: 17px; font-weight: 900; color: #FFF; text-shadow: 0 1px 2px rgba(0,0,0,0.4);">7</span>
              <div style="width: 80%; height: 3px; background: #92400E; border-radius: 2px;"></div>
            </div>

            <!-- Plank 3: [ 11 ] (Botty Stands Here Initially) -->
            <div class="bridge-plank-node" id="plank-2" style="position: relative; width: 56px; height: 46px; background: linear-gradient(180deg, #D97706 0%, #B45309 100%); border: 2.5px solid #78350F; border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; box-shadow: 0 4px 6px rgba(0,0,0,0.25); z-index: 2;">
              <span class="bridge-jump-tag" style="position: absolute; top: -18px; font-size: 10px; font-weight: 800; color: #15803D; background: #DCFCE7; padding: 1px 5px; border-radius: 6px; border: 1px solid #86EFAC; display: none;">+4 ↗</span>
              <span style="font-size: 17px; font-weight: 900; color: #FFF; text-shadow: 0 1px 2px rgba(0,0,0,0.4);">11</span>
              <div style="width: 80%; height: 3px; background: #92400E; border-radius: 2px;"></div>
            </div>

            <!-- Plank 4: MISSING GAP SLOT [ ? ] -->
            <div class="bridge-plank-node" id="bridge-gap-slot" style="position: relative; width: 58px; height: 46px; background: rgba(255, 255, 255, 0.45); border: 2.5px dashed #F59E0B; border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; box-shadow: 0 0 10px rgba(245, 158, 11, 0.2); z-index: 2; transition: all 0.3s ease;">
              <span class="bridge-jump-tag" style="position: absolute; top: -18px; font-size: 10px; font-weight: 800; color: #15803D; background: #DCFCE7; padding: 1px 5px; border-radius: 6px; border: 1px solid #86EFAC; display: none;">+4 ↗</span>
              <span id="bridge-gap-label" style="font-size: 20px; font-weight: 900; color: #D97706; animation: pulseGlow 1.8s infinite;">❓</span>
            </div>

            <!-- Plank 5: [ 19 ] -->
            <div class="bridge-plank-node" id="plank-4" style="position: relative; width: 56px; height: 46px; background: linear-gradient(180deg, #D97706 0%, #B45309 100%); border: 2.5px solid #78350F; border-radius: 8px; display: flex; flex-direction: column; align-items: center; justify-content: center; box-shadow: 0 4px 6px rgba(0,0,0,0.25); z-index: 2;">
              <span style="font-size: 17px; font-weight: 900; color: #FFF; text-shadow: 0 1px 2px rgba(0,0,0,0.4);">19</span>
              <div style="width: 80%; height: 3px; background: #92400E; border-radius: 2px;"></div>
            </div>

          </div>

          <!-- Dynamic Walking / Jumping Botty Sprite -->
          <div id="botty-walker" style="position: absolute; bottom: 98px; left: 198px; width: 44px; height: 44px; z-index: 10; display: flex; align-items: center; justify-content: center; transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1); filter: drop-shadow(0 4px 6px rgba(0,0,0,0.2));">
            <svg viewBox="0 0 44 44" width="40" height="40" fill="none" xmlns="http://www.w3.org/2000/svg">
              <!-- Explorer Hat -->
              <ellipse cx="22" cy="12" rx="14" ry="4" fill="#92400E"/>
              <path d="M14 12 C14 6 30 6 30 12 Z" fill="#B45309"/>
              <!-- Robot Head -->
              <rect x="12" y="14" width="20" height="18" rx="6" fill="#38BDF8" stroke="#0284C7" stroke-width="2"/>
              <!-- Goggles -->
              <rect x="14" y="18" width="7" height="6" rx="2" fill="#FEF08A" stroke="#CA8A04" stroke-width="1.5"/>
              <rect x="23" y="18" width="7" height="6" rx="2" fill="#FEF08A" stroke="#CA8A04" stroke-width="1.5"/>
              <line x1="21" y1="21" x2="23" y2="21" stroke="#CA8A04" stroke-width="1.5"/>
              <!-- Smile -->
              <path d="M18 27 Q22 30 26 27" stroke="#0F172A" stroke-width="1.5" stroke-linecap="round"/>
              <!-- Backpack -->
              <rect x="7" y="20" width="5" height="12" rx="2" fill="#F97316"/>
              <!-- Feet -->
              <ellipse cx="17" cy="34" rx="4" ry="2" fill="#0369A1"/>
              <ellipse cx="27" cy="34" rx="4" ry="2" fill="#0369A1"/>
            </svg>
          </div>

        </div>

        <!-- Status Footer -->
        <div style="width: 100%; background: #FFFBEB; border-top: 2px solid #FDE68A; padding: 6px 14px; display: flex; align-items: center; justify-content: space-between; font-size: 11px; font-weight: 700; color: #92400E;">
          <span>Pola Deret Lompatan: <strong id="bridge-formula-tag" style="color: #15803D;">+4 setiap langkah</strong></span>
          <span id="bridge-status-text" style="color: #D97706;">Pilih balok di bawah untuk menyambung jembatan</span>
        </div>
      </div>
    `;

    // 2. Interactive Tactile Controls (Wood Workshop)
    controlsEl.innerHTML = `
      <div style="display: flex; flex-direction: column; gap: 10px;">
        <div style="font-weight: 800; font-size: 13px; color: #92400E; display: flex; align-items: center; justify-content: space-between;">
          <span style="display: flex; align-items: center; gap: 6px;">
            <span>🪵 WORKSHOP BALOK PEMBANGUN</span>
            <span class="badge-pill badge-pill-accent" style="font-size: 10px; padding: 1px 6px;">Celah Jembatan</span>
          </span>
          <span style="font-size: 11px; color: #64748B;">Ketuk balok untuk memasangnya</span>
        </div>

        <!-- 4 Tactile 3D Wooden Blocks -->
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px;">
          <button type="button" class="bridge-choice-btn btn-kid" data-val="13" style="padding: 0.85rem 0.6rem; background: linear-gradient(180deg, #FFFBEB 0%, #FEF3C7 100%); border: 2.5px solid #D97706; border-radius: var(--radius-lg); box-shadow: 0 4px 8px rgba(217, 119, 6, 0.15); display: flex; flex-direction: column; align-items: center; gap: 2px; cursor: pointer; transition: all 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);">
            <div style="display: flex; align-items: center; gap: 6px;">
              <span style="font-size: 18px;">🪵</span>
              <strong style="font-size: 16px; color: #78350F;">Balok 13</strong>
            </div>
            <span style="font-size: 11px; color: #92400E; font-weight: 600;">(11 + 2)</span>
          </button>

          <button type="button" class="bridge-choice-btn btn-kid" data-val="14" style="padding: 0.85rem 0.6rem; background: linear-gradient(180deg, #FFFBEB 0%, #FEF3C7 100%); border: 2.5px solid #D97706; border-radius: var(--radius-lg); box-shadow: 0 4px 8px rgba(217, 119, 6, 0.15); display: flex; flex-direction: column; align-items: center; gap: 2px; cursor: pointer; transition: all 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);">
            <div style="display: flex; align-items: center; gap: 6px;">
              <span style="font-size: 18px;">🪵</span>
              <strong style="font-size: 16px; color: #78350F;">Balok 14</strong>
            </div>
            <span style="font-size: 11px; color: #92400E; font-weight: 600;">(11 + 3)</span>
          </button>

          <button type="button" class="bridge-choice-btn btn-kid" data-val="15" style="padding: 0.85rem 0.6rem; background: linear-gradient(180deg, #FFFBEB 0%, #FEF3C7 100%); border: 2.5px solid #D97706; border-radius: var(--radius-lg); box-shadow: 0 4px 8px rgba(217, 119, 6, 0.15); display: flex; flex-direction: column; align-items: center; gap: 2px; cursor: pointer; transition: all 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);">
            <div style="display: flex; align-items: center; gap: 6px;">
              <span style="font-size: 18px;">🪵</span>
              <strong style="font-size: 16px; color: #78350F;">Balok 15 ⭐</strong>
            </div>
            <span style="font-size: 11px; color: #92400E; font-weight: 600;">(11 + 4)</span>
          </button>

          <button type="button" class="bridge-choice-btn btn-kid" data-val="16" style="padding: 0.85rem 0.6rem; background: linear-gradient(180deg, #FFFBEB 0%, #FEF3C7 100%); border: 2.5px solid #D97706; border-radius: var(--radius-lg); box-shadow: 0 4px 8px rgba(217, 119, 6, 0.15); display: flex; flex-direction: column; align-items: center; gap: 2px; cursor: pointer; transition: all 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);">
            <div style="display: flex; align-items: center; gap: 6px;">
              <span style="font-size: 18px;">🪵</span>
              <strong style="font-size: 16px; color: #78350F;">Balok 16</strong>
            </div>
            <span style="font-size: 11px; color: #92400E; font-weight: 600;">(11 + 5)</span>
          </button>
        </div>

        <!-- Action / Reset Bar -->
        <div style="display: flex; gap: 8px; margin-top: 2px;">
          <button type="button" id="btn-reset-bridge" class="btn-kid btn-kid-ghost" style="flex: 1; padding: 0.5rem; font-size: 12px; color: #64748B;">
            🔄 Ulangi Posisi Botty
          </button>
        </div>
      </div>
    `;

    // Elements & State Handlers
    const gapSlot = document.getElementById('bridge-gap-slot');
    const gapLabel = document.getElementById('bridge-gap-label');
    const botty = document.getElementById('botty-walker');
    const botBubble = document.getElementById('bridge-bot-bubble');
    const statusText = document.getElementById('bridge-status-text');
    const treasure = document.getElementById('bridge-treasure');
    const jumpTags = canvasEl.querySelectorAll('.bridge-jump-tag');
    const choiceBtns = controlsEl.querySelectorAll('.bridge-choice-btn');

    let hintVisible = false;
    document.getElementById('btn-hint-bridge').addEventListener('click', () => {
      hintVisible = !hintVisible;
      jumpTags.forEach(tag => tag.style.display = hintVisible ? 'block' : 'none');
      if (window.SoundFX) window.SoundFX.playTap();
      if (hintVisible) {
        botBubble.innerHTML = `"Perhatikan lompatannya: dari 3 ke 7 tambah 4, dari 7 ke 11 tambah 4! Polanya selalu bertambah 4! 💡"`;
      }
    });

    const resetBotty = () => {
      this.state.selectedValue = null;
      gapSlot.style.background = 'rgba(255, 255, 255, 0.45)';
      gapSlot.style.borderColor = '#F59E0B';
      gapSlot.style.borderStyle = 'dashed';
      gapSlot.style.boxShadow = 'none';
      gapLabel.textContent = '❓';
      gapLabel.style.color = '#D97706';
      botty.style.left = '198px';
      botty.style.bottom = '98px';
      treasure.innerHTML = '🎁';
      treasure.style.transform = 'scale(1)';
      statusText.textContent = 'Pilih balok di bawah untuk menyambung jembatan';
      statusText.style.color = '#D97706';
      choiceBtns.forEach(btn => {
        btn.style.borderColor = '#D97706';
        btn.style.background = 'linear-gradient(180deg, #FFFBEB 0%, #FEF3C7 100%)';
      });
      botBubble.innerHTML = `"Halo Penjelajah Cilik! 🎒 Jembatannya putus 1 balok. Pasangkan balok yang pas agar aku bisa menyeberang!"`;
      if (window.SoundFX) window.SoundFX.playTap();
    };

    document.getElementById('btn-reset-bridge').addEventListener('click', resetBotty);

    choiceBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        const val = parseInt(btn.dataset.val, 10);
        this.state.selectedValue = val;

        choiceBtns.forEach(b => {
          b.style.borderColor = '#D97706';
          b.style.background = 'linear-gradient(180deg, #FFFBEB 0%, #FEF3C7 100%)';
        });
        btn.style.borderColor = '#2563EB';
        btn.style.background = '#EFF6FF';

        // Play Wood Thud Block Drop
        if (window.SoundFX && typeof window.SoundFX.playWoodThud === 'function') {
          window.SoundFX.playWoodThud();
        }

        // Mount block into gap
        gapSlot.style.borderStyle = 'solid';
        gapLabel.textContent = String(val);

        if (val === 15) {
          // CORRECT ANSWER (15)
          gapSlot.style.background = 'linear-gradient(180deg, #F59E0B 0%, #D97706 100%)';
          gapSlot.style.borderColor = '#78350F';
          gapSlot.style.boxShadow = '0 0 16px rgba(245, 158, 11, 0.6)';
          gapLabel.style.color = '#FFFFFF';
          statusText.textContent = '🎉 Jembatan tersambung kokoh! Botty siap menyeberang!';
          statusText.style.color = '#15803D';
          botBubble.innerHTML = `"Horeee! 11 + 4 = 15! Jembatan sudah utuh! Ayo menyeberang ke peti harta! 🌟"`;

          // Botty Crosses the Bridge Adventure (Multi-hop Animation)
          setTimeout(() => {
            if (window.SoundFX && typeof window.SoundFX.playJumpBoing === 'function') {
              window.SoundFX.playJumpBoing();
            }
            // Step 1: Hop onto block 15
            botty.style.left = '264px';
            botty.style.bottom = '106px';

            setTimeout(() => {
              if (window.SoundFX && typeof window.SoundFX.playJumpBoing === 'function') {
                window.SoundFX.playJumpBoing();
              }
              // Step 2: Hop onto block 19
              botty.style.left = '332px';
              botty.style.bottom = '112px';

              setTimeout(() => {
                if (window.SoundFX && typeof window.SoundFX.playJumpBoing === 'function') {
                  window.SoundFX.playJumpBoing();
                }
                // Step 3: Land safely at Goal Castle Cliff & Open Treasure!
                botty.style.left = '388px';
                botty.style.bottom = '126px';
                treasure.innerHTML = '✨ 👑 💎';
                treasure.style.transform = 'scale(1.25) rotate(-5deg)';
                botBubble.innerHTML = `"YAAAY! Kita sampai di Kastil Angka dan membuka peti harta karun! Kamu hebat sekali! 🏆"`;
                if (window.SoundFX && typeof window.SoundFX.playCelebration === 'function') {
                  window.SoundFX.playCelebration();
                }
              }, 400);
            }, 380);
          }, 300);

        } else {
          // INCORRECT BLOCK
          gapSlot.style.background = '#FEE2E2';
          gapSlot.style.borderColor = '#EF4444';
          gapSlot.style.boxShadow = 'none';
          gapLabel.style.color = '#DC2626';
          statusText.textContent = `Balok ${val} belum pas. Amati selisih lompatan 11 + 4!`;
          statusText.style.color = '#DC2626';
          botBubble.innerHTML = `"Aduh, balok ${val} belum seimbang! Dari 11 kita harus melompat 4 langkah (+4). Berapa 11 + 4 ya? 🤔"`;
          if (window.SoundFX && typeof window.SoundFX.playWobble === 'function') {
            window.SoundFX.playWobble();
          }
          // Shake gap slot
          gapSlot.style.animation = 'wiggleJoy 0.4s ease';
          setTimeout(() => gapSlot.style.animation = '', 450);
        }
      });
    });
  }

  // =========================================================================
  // 6. Kota Pola (Number City) — Mini-Game: Taman Musik Kristal Bercahaya
  // =========================================================================
  mountCrystalPattern(canvasEl, controlsEl) {
    this.state = { selectedColor: null };

    // 1. Interactive Musical Crystal Garden Canvas
    canvasEl.innerHTML = `
      <div style="width: 100%; max-width: 520px; position: relative; background: linear-gradient(180deg, #0F172A 0%, #1E1B4B 55%, #311042 100%); border: 3px solid #8B5CF6; border-radius: var(--radius-2xl); box-shadow: 0 10px 28px rgba(139, 92, 246, 0.22); overflow: hidden; display: flex; flex-direction: column; align-items: center; user-select: none;">
        
        <!-- Night Sky Twinkling Stars & Aurora -->
        <div style="position: absolute; top: 10px; left: 20px; font-size: 14px; opacity: 0.85; animation: sparkleTwinkle 2s infinite;">✨</div>
        <div style="position: absolute; top: 24px; left: 45%; font-size: 12px; opacity: 0.75; animation: sparkleTwinkle 2.5s infinite 0.6s;">⭐</div>
        <div style="position: absolute; top: 12px; right: 26px; font-size: 15px; opacity: 0.9; animation: sparkleTwinkle 1.8s infinite 1.2s;">✨</div>

        <!-- Header & Miko Companion Bubble -->
        <div style="width: 100%; padding: 12px 14px 6px; display: flex; align-items: center; justify-content: space-between; z-index: 2;">
          <div style="display: flex; align-items: center; gap: 10px;">
            <div id="miko-crystal-avatar" style="width: 50px; height: 50px; min-width: 50px; background: #EDE9FE; border: 2.5px solid #8B5CF6; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(139, 92, 246, 0.3); font-size: 26px;">
              🔮
            </div>
            <div id="miko-crystal-bubble" style="background: #FFFFFF; border: 2px solid #8B5CF6; border-radius: 12px; padding: 7px 11px; font-size: 12px; font-weight: 700; color: #4C1D95; line-height: 1.35; max-width: 280px; box-shadow: 0 2px 6px rgba(139, 92, 246, 0.2); position: relative;">
              "Dengarkan irama warna kristal ini! 🎶 Polanya berulang dengan melodi merdu. Kristal warna apa yang menyala berikutnya?"
              <div style="position: absolute; left: -7px; top: 16px; width: 0; height: 0; border-top: 5px solid transparent; border-bottom: 5px solid transparent; border-right: 7px solid #8B5CF6;"></div>
            </div>
          </div>
          <button type="button" id="btn-play-garden-melody" class="btn-kid btn-kid-accent" style="padding: 6px 10px; font-size: 11px; font-weight: 800; background: linear-gradient(135deg, #A855F7, #7C3AED); border: none; box-shadow: 0 4px 10px rgba(124, 58, 237, 0.35); display: flex; align-items: center; gap: 4px;" title="Putar irama kristal berurutan">
            <span>🎵 Putar Melodi</span>
          </button>
        </div>

        <!-- Crystal Garden Sanctuary Scene -->
        <div style="width: 100%; padding: 18px 12px 14px; display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative;">
          
          <!-- Crystal Pedestals Row -->
          <div style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 8px; flex-wrap: nowrap; padding: 10px 4px; background: rgba(15, 23, 42, 0.6); border: 2px solid #4338CA; border-radius: 18px; box-shadow: inset 0 2px 10px rgba(0,0,0,0.4);">
            
            <!-- Crystal 1: RED (Ruby - Note C4) -->
            <button type="button" class="crystal-pedestal-btn" data-color="red" data-freq="261.63" style="flex: 1; min-width: 48px; max-width: 68px; background: transparent; border: none; cursor: pointer; display: flex; flex-direction: column; align-items: center; gap: 4px; padding: 4px; transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);">
              <div id="c-lamp-0" class="crystal-gem-orb" style="width: 46px; height: 46px; border-radius: 50%; background: radial-gradient(circle at 35% 35%, #F87171, #DC2626 70%, #991B1B); border: 2.5px solid #FCA5A5; display: flex; align-items: center; justify-content: center; box-shadow: 0 0 14px rgba(239, 68, 68, 0.6); font-size: 20px;">
                🔴
              </div>
              <span style="font-size: 10px; font-weight: 800; color: #FCA5A5;">Merah</span>
            </button>

            <!-- Crystal 2: YELLOW (Topaz - Note E4) -->
            <button type="button" class="crystal-pedestal-btn" data-color="yellow" data-freq="329.63" style="flex: 1; min-width: 48px; max-width: 68px; background: transparent; border: none; cursor: pointer; display: flex; flex-direction: column; align-items: center; gap: 4px; padding: 4px; transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);">
              <div id="c-lamp-1" class="crystal-gem-orb" style="width: 46px; height: 46px; border-radius: 50%; background: radial-gradient(circle at 35% 35%, #FDE047, #EAB308 70%, #A16207); border: 2.5px solid #FEF08A; display: flex; align-items: center; justify-content: center; box-shadow: 0 0 14px rgba(234, 179, 8, 0.6); font-size: 20px;">
                🟡
              </div>
              <span style="font-size: 10px; font-weight: 800; color: #FEF08A;">Kuning</span>
            </button>

            <!-- Crystal 3: BLUE (Sapphire - Note G4) -->
            <button type="button" class="crystal-pedestal-btn" data-color="blue" data-freq="392.00" style="flex: 1; min-width: 48px; max-width: 68px; background: transparent; border: none; cursor: pointer; display: flex; flex-direction: column; align-items: center; gap: 4px; padding: 4px; transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);">
              <div id="c-lamp-2" class="crystal-gem-orb" style="width: 46px; height: 46px; border-radius: 50%; background: radial-gradient(circle at 35% 35%, #60A5FA, #2563EB 70%, #1E40AF); border: 2.5px solid #93C5FD; display: flex; align-items: center; justify-content: center; box-shadow: 0 0 14px rgba(37, 99, 235, 0.6); font-size: 20px;">
                🔵
              </div>
              <span style="font-size: 10px; font-weight: 800; color: #93C5FD;">Biru</span>
            </button>

            <!-- Crystal 4: RED (Ruby - Note C4) -->
            <button type="button" class="crystal-pedestal-btn" data-color="red" data-freq="261.63" style="flex: 1; min-width: 48px; max-width: 68px; background: transparent; border: none; cursor: pointer; display: flex; flex-direction: column; align-items: center; gap: 4px; padding: 4px; transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);">
              <div id="c-lamp-3" class="crystal-gem-orb" style="width: 46px; height: 46px; border-radius: 50%; background: radial-gradient(circle at 35% 35%, #F87171, #DC2626 70%, #991B1B); border: 2.5px solid #FCA5A5; display: flex; align-items: center; justify-content: center; box-shadow: 0 0 14px rgba(239, 68, 68, 0.6); font-size: 20px;">
                🔴
              </div>
              <span style="font-size: 10px; font-weight: 800; color: #FCA5A5;">Merah</span>
            </button>

            <!-- Crystal 5: YELLOW (Topaz - Note E4) -->
            <button type="button" class="crystal-pedestal-btn" data-color="yellow" data-freq="329.63" style="flex: 1; min-width: 48px; max-width: 68px; background: transparent; border: none; cursor: pointer; display: flex; flex-direction: column; align-items: center; gap: 4px; padding: 4px; transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);">
              <div id="c-lamp-4" class="crystal-gem-orb" style="width: 46px; height: 46px; border-radius: 50%; background: radial-gradient(circle at 35% 35%, #FDE047, #EAB308 70%, #A16207); border: 2.5px solid #FEF08A; display: flex; align-items: center; justify-content: center; box-shadow: 0 0 14px rgba(234, 179, 8, 0.6); font-size: 20px;">
                🟡
              </div>
              <span style="font-size: 10px; font-weight: 800; color: #FEF08A;">Kuning</span>
            </button>

            <!-- Slot 6: MYSTERIOUS PEDESTAL GAP [ ? ] -->
            <div id="c-slot-container" style="flex: 1; min-width: 48px; max-width: 68px; display: flex; flex-direction: column; align-items: center; gap: 4px; padding: 4px;">
              <div id="crystal-slot-pedestal" style="width: 46px; height: 46px; border-radius: 50%; background: rgba(255, 255, 255, 0.08); border: 2.5px dashed #C084FC; display: flex; align-items: center; justify-content: center; box-shadow: 0 0 12px rgba(192, 132, 252, 0.3); font-size: 22px; transition: all 0.3s ease;">
                <span id="crystal-slot-icon" style="animation: pulseGlow 1.8s infinite;">❓</span>
              </div>
              <span id="crystal-slot-tag" style="font-size: 10px; font-weight: 800; color: #C084FC;">Lampu ?</span>
            </div>

          </div>

          <!-- Interactive Garden Flora (Glowing Flowers at Night) -->
          <div id="crystal-garden-flowers" style="display: flex; gap: 16px; margin-top: 12px; font-size: 16px; opacity: 0.8; transition: all 0.5s ease;">
            <span>🌸</span>
            <span>🌿</span>
            <span style="font-size: 11px; color: #C4B5FD; font-weight: 700; display: flex; align-items: center;">💡 Ketuk lentera mana saja di atas untuk mendengar nadanya</span>
            <span>🌿</span>
            <span>🌸</span>
          </div>

        </div>

        <!-- Status Footer -->
        <div style="width: 100%; background: #1E1B4B; border-top: 2px solid #4338CA; padding: 6px 14px; display: flex; align-items: center; justify-content: space-between; font-size: 11px; font-weight: 700; color: #C7D2FE;">
          <span>Pola Irama Warna: <strong id="crystal-pattern-status" style="color: #FDE047;">Merah ➔ Kuning ➔ Biru</strong></span>
          <span id="crystal-guide-hint" style="color: #A5B4FC;">Pilih kristal di bawah</span>
        </div>
      </div>
    `;

    // 2. Interactive Tactile Controls (Magic Crystal Vault)
    controlsEl.innerHTML = `
      <div style="display: flex; flex-direction: column; gap: 10px;">
        <div style="font-weight: 800; font-size: 13px; color: #4C1D95; display: flex; align-items: center; justify-content: space-between;">
          <span style="display: flex; align-items: center; gap: 6px;">
            <span>💎 KOTAK KRISTAL AJAIB</span>
            <span class="badge-pill badge-pill-primary" style="font-size: 10px; padding: 1px 6px;">Pilihan Lentera</span>
          </span>
          <span style="font-size: 11px; color: #64748B;">Pilih kristal yang pas</span>
        </div>

        <!-- 3 Rich 3D Glowing Crystals -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px;">
          
          <!-- Blue Sapphire -->
          <button type="button" class="crystal-choice-btn btn-kid" data-color="blue" data-freq="392.00" style="padding: 0.9rem 0.5rem; background: linear-gradient(180deg, #EFF6FF 0%, #DBEAFE 100%); border: 2.5px solid #2563EB; border-radius: var(--radius-lg); box-shadow: 0 4px 8px rgba(37, 99, 235, 0.2); display: flex; flex-direction: column; align-items: center; gap: 4px; cursor: pointer; transition: all 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);">
            <div style="width: 36px; height: 36px; border-radius: 50%; background: radial-gradient(circle at 35% 35%, #60A5FA, #2563EB 70%, #1E40AF); display: flex; align-items: center; justify-content: center; box-shadow: 0 0 10px rgba(37, 99, 235, 0.5); font-size: 16px;">
              🔵
            </div>
            <strong style="font-size: 13px; color: #1E40AF;">Safir Biru ⭐</strong>
            <span style="font-size: 10px; color: #3B82F6; font-weight: 700;">Nada Sol</span>
          </button>

          <!-- Green Emerald -->
          <button type="button" class="crystal-choice-btn btn-kid" data-color="green" data-freq="440.00" style="padding: 0.9rem 0.5rem; background: linear-gradient(180deg, #F0FDF4 0%, #DCFCE7 100%); border: 2.5px solid #16A34A; border-radius: var(--radius-lg); box-shadow: 0 4px 8px rgba(22, 163, 74, 0.2); display: flex; flex-direction: column; align-items: center; gap: 4px; cursor: pointer; transition: all 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);">
            <div style="width: 36px; height: 36px; border-radius: 50%; background: radial-gradient(circle at 35% 35%, #4ADE80, #16A34A 70%, #166534); display: flex; align-items: center; justify-content: center; box-shadow: 0 0 10px rgba(22, 163, 74, 0.5); font-size: 16px;">
              🟢
            </div>
            <strong style="font-size: 13px; color: #166534;">Zamrud Hijau</strong>
            <span style="font-size: 10px; color: #22C55E; font-weight: 700;">Nada La</span>
          </button>

          <!-- Purple Amethyst -->
          <button type="button" class="crystal-choice-btn btn-kid" data-color="purple" data-freq="493.88" style="padding: 0.9rem 0.5rem; background: linear-gradient(180deg, #FAF5FF 0%, #F3E8FF 100%); border: 2.5px solid #9333EA; border-radius: var(--radius-lg); box-shadow: 0 4px 8px rgba(147, 51, 234, 0.2); display: flex; flex-direction: column; align-items: center; gap: 4px; cursor: pointer; transition: all 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);">
            <div style="width: 36px; height: 36px; border-radius: 50%; background: radial-gradient(circle at 35% 35%, #C084FC, #9333EA 70%, #6B21A8); display: flex; align-items: center; justify-content: center; box-shadow: 0 0 10px rgba(147, 51, 234, 0.5); font-size: 16px;">
              🟣
            </div>
            <strong style="font-size: 13px; color: #6B21A8;">Ametis Ungu</strong>
            <span style="font-size: 10px; color: #A855F7; font-weight: 700;">Nada Si</span>
          </button>

        </div>

        <!-- Action / Reset Bar -->
        <div style="display: flex; gap: 8px; margin-top: 2px;">
          <button type="button" id="btn-reset-crystal" class="btn-kid btn-kid-ghost" style="flex: 1; padding: 0.5rem; font-size: 12px; color: #64748B;">
            🔄 Kosongkan Pedestal
          </button>
        </div>
      </div>
    `;

    // Elements & Handlers
    const slotPedestal = document.getElementById('crystal-slot-pedestal');
    const slotIcon = document.getElementById('crystal-slot-icon');
    const slotTag = document.getElementById('crystal-slot-tag');
    const mikoBubble = document.getElementById('miko-crystal-bubble');
    const guideHint = document.getElementById('crystal-guide-hint');
    const flowers = document.getElementById('crystal-garden-flowers');
    const choiceBtns = controlsEl.querySelectorAll('.crystal-choice-btn');
    const lampBtns = canvasEl.querySelectorAll('.crystal-pedestal-btn');

    // Tap to hear individual crystal sound
    lampBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        const freq = parseFloat(btn.dataset.freq);
        if (window.SoundFX && typeof window.SoundFX.playCrystalChime === 'function') {
          window.SoundFX.playCrystalChime(freq);
        }
        btn.style.transform = 'scale(1.22)';
        setTimeout(() => btn.style.transform = 'scale(1)', 200);
      });
    });

    // Musical Melody Playback
    document.getElementById('btn-play-garden-melody').addEventListener('click', () => {
      mikoBubble.innerHTML = `"Dengarkan melodinya ya: Merah (Do), Kuning (Mi), Biru (Sol)... Merah (Do), Kuning (Mi)... 🎶"`;
      if (window.SoundFX && typeof window.SoundFX.playCrystalGardenSequence === 'function') {
        window.SoundFX.playCrystalGardenSequence(
          (stepIdx, colorName) => {
            const lamp = document.getElementById(`c-lamp-${stepIdx}`);
            if (lamp) {
              lamp.style.transform = 'scale(1.25)';
              lamp.style.boxShadow = '0 0 24px rgba(255, 255, 255, 0.9)';
              setTimeout(() => {
                lamp.style.transform = 'scale(1)';
                lamp.style.boxShadow = '';
              }, 350);
            }
          },
          () => {
            slotPedestal.style.animation = 'wiggleJoy 0.6s ease';
            setTimeout(() => slotPedestal.style.animation = '', 650);
            mikoBubble.innerHTML = `"Nah! Setelah Kuning yang kedua, warna apa yang harus menyala agar melodinya lengkap? ✨"`;
          }
        );
      }
    });

    // Reset Handler
    document.getElementById('btn-reset-crystal').addEventListener('click', () => {
      this.state.selectedColor = null;
      slotPedestal.style.background = 'rgba(255, 255, 255, 0.08)';
      slotPedestal.style.borderColor = '#C084FC';
      slotPedestal.style.borderStyle = 'dashed';
      slotPedestal.style.boxShadow = '0 0 12px rgba(192, 132, 252, 0.3)';
      slotIcon.textContent = '❓';
      slotIcon.style.animation = 'pulseGlow 1.8s infinite';
      slotTag.textContent = 'Lampu ?';
      slotTag.style.color = '#C084FC';
      guideHint.textContent = 'Pilih kristal di bawah';
      guideHint.style.color = '#A5B4FC';
      flowers.style.transform = 'scale(1)';
      choiceBtns.forEach(b => {
        b.style.borderColor = b.dataset.color === 'blue' ? '#2563EB' : (b.dataset.color === 'green' ? '#16A34A' : '#9333EA');
      });
      mikoBubble.innerHTML = `"Dengarkan irama warna kristal ini! 🎶 Polanya berulang dengan melodi merdu. Kristal warna apa yang menyala berikutnya?"`;
      if (window.SoundFX) window.SoundFX.playTap();
    });

    // Choice Selection Handlers
    choiceBtns.forEach(btn => {
      btn.addEventListener('click', () => {
        const color = btn.dataset.color;
        const freq = parseFloat(btn.dataset.freq);
        this.state.selectedColor = color;

        choiceBtns.forEach(b => b.style.transform = 'scale(1)');
        btn.style.transform = 'scale(1.05)';

        // Play Crystal Chime Sound
        if (window.SoundFX && typeof window.SoundFX.playCrystalChime === 'function') {
          window.SoundFX.playCrystalChime(freq);
        }

        slotPedestal.style.borderStyle = 'solid';

        if (color === 'blue') {
          // CORRECT (BLUE SAPPHIRE)
          slotPedestal.style.background = 'radial-gradient(circle at 35% 35%, #60A5FA, #2563EB 70%, #1E40AF)';
          slotPedestal.style.borderColor = '#93C5FD';
          slotPedestal.style.boxShadow = '0 0 24px rgba(37, 99, 235, 0.85)';
          slotIcon.textContent = '🔵';
          slotIcon.style.animation = 'popInBouncy 0.4s ease';
          slotTag.textContent = 'Safir Biru ✨';
          slotTag.style.color = '#93C5FD';
          guideHint.textContent = '🎉 Pola sempurna: Merah - Kuning - Biru!';
          guideHint.style.color = '#38BDF8';
          flowers.style.transform = 'scale(1.15)';
          mikoBubble.innerHTML = `"WAH LUAR BIASA! 🌟 Pola lengkap: Merah - Kuning - Biru! Seluruh taman kristal bernyanyi harmonis!"`;

          setTimeout(() => {
            if (window.SoundFX && typeof window.SoundFX.playCelebration === 'function') {
              window.SoundFX.playCelebration();
            }
          }, 350);

        } else if (color === 'green') {
          // GREEN
          slotPedestal.style.background = 'radial-gradient(circle at 35% 35%, #4ADE80, #16A34A 70%, #166534)';
          slotPedestal.style.borderColor = '#86EFAC';
          slotPedestal.style.boxShadow = '0 0 16px rgba(22, 163, 74, 0.5)';
          slotIcon.textContent = '🟢';
          slotIcon.style.animation = '';
          slotTag.textContent = 'Zamrud Hijau';
          slotTag.style.color = '#86EFAC';
          guideHint.textContent = 'Belum sesuai urutan deret (Merah, Kuning, ...)';
          guideHint.style.color = '#F87171';
          mikoBubble.innerHTML = `"Kristal hijau ini indah, tapi nadanya belum selaras dengan irama sebelumnya (Merah, Kuning, lalu apa ya?). Putar melodi untuk mengecek! 🎵"`;
          if (window.SoundFX && typeof window.SoundFX.playWobble === 'function') {
            window.SoundFX.playWobble();
          }
          slotPedestal.style.animation = 'wiggleJoy 0.4s ease';
          setTimeout(() => slotPedestal.style.animation = '', 450);

        } else {
          // PURPLE
          slotPedestal.style.background = 'radial-gradient(circle at 35% 35%, #C084FC, #9333EA 70%, #6B21A8)';
          slotPedestal.style.borderColor = '#D8B4FE';
          slotPedestal.style.boxShadow = '0 0 16px rgba(147, 51, 234, 0.5)';
          slotIcon.textContent = '🟣';
          slotIcon.style.animation = '';
          slotTag.textContent = 'Ametis Ungu';
          slotTag.style.color = '#D8B4FE';
          guideHint.textContent = 'Belum sesuai urutan deret (Merah, Kuning, ...)';
          guideHint.style.color = '#F87171';
          mikoBubble.innerHTML = `"Kristal ungu ini berkilau cantik, tapi deretnya berulang dari awal: Merah, Kuning, lalu biru! Coba dengarkan melodinya lagi ya! 🎶"`;
          if (window.SoundFX && typeof window.SoundFX.playWobble === 'function') {
            window.SoundFX.playWobble();
          }
          slotPedestal.style.animation = 'wiggleJoy 0.4s ease';
          setTimeout(() => slotPedestal.style.animation = '', 450);
        }
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
      if (isCorrect) {
        if (window.SoundFX && typeof window.SoundFX.playCashRegister === 'function') {
          window.SoundFX.playCashRegister();
        }
        const bellaBubble = document.getElementById('bella-bubble');
        if (bellaBubble) {
          bellaBubble.innerHTML = "🎁 <strong>TERIMA KASIH KAK KASIR!</strong><br>Donatnya dibungkus rapi dan kembaliannya pas! 💖";
        }
      }
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
