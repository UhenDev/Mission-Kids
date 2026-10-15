<?php
/**
 * MISSION KIDS — Landing Page (Redesign: Adventure Meets Professionalism)
 */

declare(strict_types=1);

require __DIR__ . '/../layouts/header.php';
?>

<div class="landing-redesign-container">

  <!-- =========================================================================
       1. HERO SECTION: Adventure Meets Professionalism
       ========================================================================= -->
  <section class="hero-adventure-section">
    <div class="container hero-adventure-grid">
      <!-- Left Column: Copywriting & CTAs -->
      <div class="hero-left-column">
        <div class="badge-pill badge-pill-primary hero-category-tag">
          Platform Edukasi Interaktif untuk Anak
        </div>

        <h1 class="hero-headline">
          Belajar Itu<br><span class="hero-headline-accent">Petualangan!</span>
        </h1>

        <p class="hero-description">
          Jelajahi dunia baru, pecahkan tantangan, dan temukan hal seru bersama MIKO.
        </p>

        <div class="hero-cta-group">
          <a href="?page=register" class="btn-kid btn-kid-primary hero-btn-primary shine-effect" id="hero-btn-cta">
            <span>Mulai Petualangan</span>
            <span class="btn-arrow-icon">➔</span>
          </a>
          <a href="#dunia" class="btn-kid btn-kid-ghost hero-btn-secondary" id="hero-btn-explore">
            <span class="btn-play-circle">▶</span>
            <span>Jelajahi Dunia</span>
          </a>
        </div>

        <!-- Key Features Mini Ribbon -->
        <div class="hero-ribbon-pills">
          <div class="hero-ribbon-item">
            <span class="ribbon-icon">🏠</span>
            <span class="ribbon-text">Belajar Sambil Bermain</span>
          </div>
          <div class="hero-ribbon-item">
            <span class="ribbon-icon">🎒</span>
            <span class="ribbon-text">4 Dunia Petualangan</span>
          </div>
          <div class="hero-ribbon-item">
            <span class="ribbon-icon">🧩</span>
            <span class="ribbon-text">80+ Misi Menarik</span>
          </div>
          <div class="hero-ribbon-item">
            <span class="ribbon-icon">🏅</span>
            <span class="ribbon-text">Penghargaan & Medali</span>
          </div>
        </div>
      </div>

      <!-- Right Column: Visual Adventure Scene -->
      <div class="hero-right-column">
        <div class="hero-visual-frame">
          <img src="assets/images/hero_adventure.jpg" alt="Petualangan Sahabat Cilik dan MIKO di Pulau Fantasi" class="hero-main-illustration">
          <!-- Floating Interactive Speech Balloon -->
          <div class="hero-floating-callout">
            <div class="callout-bubble-content">
              <span>Ayo jelajahi dunia bersama MIKO!</span>
              <span class="callout-sparkle">🪁</span>
            </div>
            <div class="callout-curve-arrow">⤵</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- =========================================================================
       2. DUNIA PETUALANGAN SECTION (4 Worlds Connected Adventure Trail)
       ========================================================================= -->
  <!-- =========================================================================
       2. DUNIA PETUALANGAN SECTION (Unified Interactive World Map)
       ========================================================================= -->
  <?php
  // Structured World Map Data (20 Missions per World)
  $defaultWorldsData = [
      'number-city' => [
          'slug' => 'number-city',
          'title' => 'Number City',
          'subtitle' => 'Aritmetika, Deret & Logika Pola',
          'badge_sub' => '20 Misi Seru',
          'theme_class' => 'theme-number',
          'theme_color' => '#F59E0B',
          'icon' => '🧮',
          'icon_bg' => 'icon-bg-number',
          'total_missions' => 20,
          'completed_missions' => 0,
          'missions' => [
              ['id' => 1, 'title' => 'Toko Kue Donat Bibi Bella', 'desc' => 'Bantu kasir menyiapkan donat & uang kembalian', 'objective' => 'Operasi penjumlahan, pengurangan & pecahan uang', 'slug' => 'toko-kue', 'xp' => 100, 'status' => 'available'],
              ['id' => 2, 'title' => 'Jembatan Angka yang Hilang', 'desc' => 'Temukan angka loncat misterius penyambung jembatan', 'objective' => 'Pola deret angka & lompatan bilangan bertingkat', 'slug' => 'jembatan-angka', 'xp' => 100, 'status' => 'locked'],
              ['id' => 3, 'title' => 'Taman Lampu Kristal Berpola', 'desc' => 'Pasang kristal warna lampu taman agar bersinar serasi', 'objective' => 'Pengenalan pola berulang visual & keteraturan ritme', 'slug' => 'kota-pola', 'xp' => 100, 'status' => 'locked'],
          ]
      ],
      'discovery-lab' => [
          'slug' => 'discovery-lab',
          'title' => 'Discovery Lab',
          'subtitle' => 'Sains, Fotosintesis, Optik & Siklus Air',
          'badge_sub' => '20 Misi Seru',
          'theme_class' => 'theme-discovery',
          'theme_color' => '#10B981',
          'icon' => '🌿',
          'icon_bg' => 'icon-bg-discovery',
          'total_missions' => 20,
          'completed_missions' => 0,
          'missions' => [
              ['id' => 1, 'title' => 'Dokter Tanaman: Bunga Matahari', 'desc' => 'Atur air dan sinar matahari lab agar mekar ceria', 'objective' => 'Kebutuhan dasar tumbuhan & fotosintesis alami', 'slug' => 'tanaman-layu', 'xp' => 100, 'status' => 'available'],
              ['id' => 2, 'title' => 'Misteri Teater Bayangan Kelinci', 'desc' => 'Atur posisi senter agar bayangan pas di layar pentas', 'objective' => 'Sifat perambatan cahaya & pengaruh jarak bayangan', 'slug' => 'misteri-bayangan', 'xp' => 100, 'status' => 'locked'],
              ['id' => 3, 'title' => 'Petualangan Tetes Air di Awan', 'desc' => 'Susun 3 tahapan siklus air alamiah di danau lab', 'objective' => 'Mengenal siklus evaporasi, kondensasi & presipitasi', 'slug' => 'perjalanan-air', 'xp' => 100, 'status' => 'locked'],
          ]
      ],
      'thinking-lab' => [
          'slug' => 'thinking-lab',
          'title' => 'Thinking Lab',
          'subtitle' => 'Berpikir Komputasional, Algoritma & Loop',
          'badge_sub' => '20 Misi Seru',
          'theme_class' => 'theme-thinking',
          'theme_color' => '#6366F1',
          'icon' => '🤖',
          'icon_bg' => 'icon-bg-thinking',
          'total_missions' => 20,
          'completed_missions' => 0,
          'missions' => [
              ['id' => 1, 'title' => 'Robot Botty Pulang ke Rumah', 'desc' => 'Susun perintah kartu langkah agar Botty tiba di stasiun cas', 'objective' => 'Melatih urutan instruksi & eksekusi langkah (sequence)', 'slug' => 'robot-pulang', 'xp' => 100, 'status' => 'available'],
              ['id' => 2, 'title' => 'Sensor Pintu Jalan Rahasia', 'desc' => 'Pilih rute aman dengan membaca rambu kondisi lampu sensor', 'objective' => 'Logika percabangan kondisional (IF / THEN)', 'slug' => 'jalan-rahasia', 'xp' => 100, 'status' => 'locked'],
              ['id' => 3, 'title' => 'Robot Pintar Kartu Mengulang (Loop)', 'desc' => 'Ringkas langkah menaiki anak tangga dengan kartu perulangan', 'objective' => 'Konsep efisiensi instruksi berbasis Loop', 'slug' => 'robot-mengulang', 'xp' => 100, 'status' => 'locked'],
          ]
      ],
      'space-odyssey' => [
          'slug' => 'space-odyssey',
          'title' => 'Space Odyssey',
          'subtitle' => 'Navigasi Angkasa, Sudut, Radar & Grid',
          'badge_sub' => '20 Misi Seru',
          'theme_class' => 'theme-space',
          'theme_color' => '#8B5CF6',
          'icon' => '🚀',
          'icon_bg' => 'icon-bg-space',
          'total_missions' => 20,
          'completed_missions' => 0,
          'missions' => [
              ['id' => 1, 'title' => 'Peluncuran Roket Angkasa', 'desc' => 'Hitung mundur dan tentukan lintasan awal roket', 'objective' => 'Hitung mundur & koordinat lintasan peluncuran', 'slug' => 'roket-angkasa', 'xp' => 100, 'status' => 'available'],
              ['id' => 2, 'title' => 'Rasi Bintang Penunjuk Arah', 'desc' => 'Hubungkan gugusan bintang untuk navigasi angkasa', 'objective' => 'Mengenal sudut derajat dan orientasi ruang langit', 'slug' => 'rasi-bintang', 'xp' => 100, 'status' => 'locked'],
              ['id' => 3, 'title' => 'Rover Penjelajah Mars', 'desc' => 'Pandu robot penjelajah menghindari kawah permukaan Mars', 'objective' => 'Perencanaan koordinat grid permukaan planet', 'slug' => 'rover-mars', 'xp' => 100, 'status' => 'locked'],
          ]
      ],
  ];

  // Enrich with database progress if available
  if (!empty($worlds)) {
      foreach ($worlds as $dbWorld) {
          $slug = $dbWorld['slug'];
          if (isset($defaultWorldsData[$slug])) {
              $defaultWorldsData[$slug]['title'] = $dbWorld['title'];
              if (!empty($dbWorld['subtitle'])) {
                  $defaultWorldsData[$slug]['subtitle'] = $dbWorld['subtitle'];
              }
              $totalM = (int)$dbWorld['total_missions'];
              $compM = (int)$dbWorld['completed_missions'];
              $defaultWorldsData[$slug]['total_missions'] = $totalM;
              $defaultWorldsData[$slug]['completed_missions'] = $compM;
              $defaultWorldsData[$slug]['badge_sub'] = $compM > 0 ? "{$compM} / {$totalM} Misi" : "{$totalM} Misi Seru";

              if (!empty($dbWorld['missions'])) {
                  $formattedMissions = [];
                  foreach ($dbWorld['missions'] as $idx => $m) {
                      $formattedMissions[] = [
                          'id' => $idx + 1,
                          'title' => $m['title'],
                          'desc' => $m['subtitle'] ?? '',
                          'objective' => $m['learning_objective'] ?? '',
                          'slug' => $m['slug'],
                          'xp' => (int)($m['xp_reward'] ?? 100),
                          'status' => $m['progress_status'] ?? ($idx === 0 ? 'available' : 'locked')
                      ];
                  }
                  $defaultWorldsData[$slug]['missions'] = $formattedMissions;
              }
          }
      }
  }
  ?>

  <section id="dunia" class="worlds-adventure-section">
    <div class="container">
      <!-- Section Header -->
      <div class="section-header-row">
        <div>
          <div class="badge-pill badge-pill-primary" style="margin-bottom: 0.6rem; font-size: var(--fs-xs);">
            <span>🗺️</span> 4 Dunia, 80 Misi Seru
          </div>
          <h2 class="section-title-bold">Dunia Petualangan</h2>
          <p class="section-subtitle-muted">
            Setiap dunia punya tantangan unik yang akan mengasah logika, pengetahuan, dan kreativitasmu!
          </p>
        </div>
      </div>

      <!-- Unified Interactive World Map Stage -->
      <div class="interactive-world-map-wrapper" id="world-map-stage" role="region" aria-label="Peta Interaktif Dunia Petualangan MISSION KIDS">
        <!-- Base Map Illustration Panorama -->
        <img 
          src="assets/images/worlds_adventure_map.jpg" 
          alt="Peta Petualangan 4 Pulau Terapung MISSION KIDS: Number City, Discovery Lab, Thinking Lab, Space Odyssey" 
          class="interactive-world-map-img"
          draggable="false"
        >

        <!-- ==========================================
             Island 1: Number City (Math & Logic Island)
             ========================================== -->
        <div class="map-island-interactive-zone" data-world-slug="number-city">
          <a href="?page=register" class="island-hitbox hitbox-number" data-world="number-city" aria-label="Buka Pulau Number City" tabindex="0"></a>
          
          <div class="map-pin-anchor pin-number" data-world="number-city" aria-hidden="true">
            <span class="map-pin-pulse"></span>
            <svg class="map-pin-svg" viewBox="0 0 32 38" width="28" height="34">
              <path d="M16 0C7.16 0 0 7.16 0 16c0 11.5 16 22 16 22s16-10.5 16-22C32 7.16 24.84 0 16 0z" fill="#2563EB"/>
              <circle cx="16" cy="15" r="5.5" fill="#FFFFFF"/>
            </svg>
          </div>

          <a href="?page=register" class="map-island-badge badge-number" data-world="number-city" id="badge-number-city" aria-label="Number City: <?= e($defaultWorldsData['number-city']['badge_sub']) ?>">
            <div class="map-badge-icon icon-bg-number" aria-hidden="true">
              <span>🧮</span>
            </div>
            <div class="map-badge-content">
              <span class="map-badge-title">Number City</span>
              <span class="map-badge-sub"><?= e($defaultWorldsData['number-city']['badge_sub']) ?></span>
            </div>
            <span class="map-badge-arrow" aria-hidden="true">›</span>
          </a>
        </div>

        <!-- ==========================================
             Island 2: Discovery Lab (Nature & Science Island)
             ========================================== -->
        <div class="map-island-interactive-zone" data-world-slug="discovery-lab">
          <a href="?page=register" class="island-hitbox hitbox-discovery" data-world="discovery-lab" aria-label="Buka Pulau Discovery Lab" tabindex="0"></a>
          
          <div class="map-pin-anchor pin-discovery" data-world="discovery-lab" aria-hidden="true">
            <span class="map-pin-pulse"></span>
            <svg class="map-pin-svg" viewBox="0 0 32 38" width="28" height="34">
              <path d="M16 0C7.16 0 0 7.16 0 16c0 11.5 16 22 16 22s16-10.5 16-22C32 7.16 24.84 0 16 0z" fill="#2563EB"/>
              <circle cx="16" cy="15" r="5.5" fill="#FFFFFF"/>
            </svg>
          </div>

          <a href="?page=register" class="map-island-badge badge-discovery" data-world="discovery-lab" id="badge-discovery-lab" aria-label="Discovery Lab: <?= e($defaultWorldsData['discovery-lab']['badge_sub']) ?>">
            <div class="map-badge-icon icon-bg-discovery" aria-hidden="true">
              <span>🌿</span>
            </div>
            <div class="map-badge-content">
              <span class="map-badge-title">Discovery Lab</span>
              <span class="map-badge-sub"><?= e($defaultWorldsData['discovery-lab']['badge_sub']) ?></span>
            </div>
            <span class="map-badge-arrow" aria-hidden="true">›</span>
          </a>
        </div>

        <!-- ==========================================
             Island 3: Thinking Lab (Coding & Tech Island)
             ========================================== -->
        <div class="map-island-interactive-zone" data-world-slug="thinking-lab">
          <a href="?page=register" class="island-hitbox hitbox-thinking" data-world="thinking-lab" aria-label="Buka Pulau Thinking Lab" tabindex="0"></a>
          
          <div class="map-pin-anchor pin-thinking" data-world="thinking-lab" aria-hidden="true">
            <span class="map-pin-pulse"></span>
            <svg class="map-pin-svg" viewBox="0 0 32 38" width="28" height="34">
              <path d="M16 0C7.16 0 0 7.16 0 16c0 11.5 16 22 16 22s16-10.5 16-22C32 7.16 24.84 0 16 0z" fill="#2563EB"/>
              <circle cx="16" cy="15" r="5.5" fill="#FFFFFF"/>
            </svg>
          </div>

          <a href="?page=register" class="map-island-badge badge-thinking" data-world="thinking-lab" id="badge-thinking-lab" aria-label="Thinking Lab: <?= e($defaultWorldsData['thinking-lab']['badge_sub']) ?>">
            <div class="map-badge-icon icon-bg-thinking" aria-hidden="true">
              <span>🤖</span>
            </div>
            <div class="map-badge-content">
              <span class="map-badge-title">Thinking Lab</span>
              <span class="map-badge-sub"><?= e($defaultWorldsData['thinking-lab']['badge_sub']) ?></span>
            </div>
            <span class="map-badge-arrow" aria-hidden="true">›</span>
          </a>
        </div>

        <!-- ==========================================
             Island 4: Space Odyssey (Rocket & Astronomy Island)
             ========================================== -->
        <div class="map-island-interactive-zone" data-world-slug="space-odyssey">
          <a href="?page=register" class="island-hitbox hitbox-space" data-world="space-odyssey" aria-label="Buka Pulau Space Odyssey" tabindex="0"></a>
          
          <div class="map-pin-anchor pin-space" data-world="space-odyssey" aria-hidden="true">
            <span class="map-pin-pulse"></span>
            <svg class="map-pin-svg" viewBox="0 0 32 38" width="28" height="34">
              <path d="M16 0C7.16 0 0 7.16 0 16c0 11.5 16 22 16 22s16-10.5 16-22C32 7.16 24.84 0 16 0z" fill="#2563EB"/>
              <circle cx="16" cy="15" r="5.5" fill="#FFFFFF"/>
            </svg>
          </div>

          <a href="?page=register" class="map-island-badge badge-space" data-world="space-odyssey" id="badge-space-odyssey" aria-label="Space Odyssey: <?= e($defaultWorldsData['space-odyssey']['badge_sub']) ?>">
            <div class="map-badge-icon icon-bg-space" aria-hidden="true">
              <span>🚀</span>
            </div>
            <div class="map-badge-content">
              <span class="map-badge-title">Space Odyssey</span>
              <span class="map-badge-sub"><?= e($defaultWorldsData['space-odyssey']['badge_sub']) ?></span>
            </div>
            <span class="map-badge-arrow" aria-hidden="true">›</span>
          </a>
        </div>

        <!-- ==========================================
             Floating Bottom-Left MIKO Helper Pill
             ========================================== -->
        <div class="map-helper-pill" role="status" aria-live="polite">
          <div class="map-helper-avatar-circle">
            <img src="assets/images/miko_companion_wave.jpg" alt="MIKO" class="map-helper-avatar-img">
          </div>
          <span class="map-helper-msg">Klik pada pulau untuk menjelajahi setiap dunia petualangan! <span class="sparkle-anim">✨</span></span>
          <span class="map-helper-chevron" aria-hidden="true">›</span>
        </div>
      </div>

      <!-- Single Primary Action Button: Lihat Dunia Lengkap -->
      <div class="worlds-action-row" style="text-align: center; margin-top: var(--space-6);">
        <a href="?page=register" class="btn-kid btn-kid-primary btn-kid-lg btn-single-world-cta" id="btn-lihat-dunia-lengkap" style="display: inline-flex; align-items: center; justify-content: center; gap: 0.75rem; padding: 0.95rem 2.4rem; font-size: var(--fs-md); font-weight: 800; border-radius: var(--radius-pill); box-shadow: 0 10px 25px -4px rgba(37, 99, 235, 0.4); text-decoration: none;">
          <span style="font-size: 1.25rem;">🗺️</span>
          <span>Lihat Dunia Lengkap</span>
          <span aria-hidden="true" style="font-size: 1.1rem; transition: transform 0.2s ease;">➔</span>
        </a>
      </div>
    </div>
  </section>

  <!-- =========================================================================
       WORLD DETAIL PREVIEW MODAL (Tampilan Detail Pulau Saat Diklik)
       ========================================================================= -->
  <div class="world-detail-modal-backdrop" id="world-detail-modal" aria-hidden="true" role="dialog" aria-modal="true" aria-labelledby="modal-world-title">
    <div class="world-detail-modal-card">
      <button type="button" class="world-modal-close-btn" id="btn-close-world-modal" aria-label="Tutup Tampilan Dunia">✕</button>
      
      <div class="world-modal-hero theme-number" id="modal-world-hero">
        <div class="world-modal-header-content">
          <div class="world-modal-icon-bubble" id="modal-world-icon">🧮</div>
          <div>
            <span class="world-modal-tag" id="modal-world-tag">Dunia Petualangan</span>
            <h3 class="world-modal-title" id="modal-world-title">Number City</h3>
            <p class="world-modal-subtitle" id="modal-world-subtitle">Aritmetika, Deret & Logika Pola</p>
          </div>
        </div>
      </div>

      <div class="world-modal-body-content">
        <div class="world-modal-meta-row">
          <div class="world-meta-chip">
            <span class="meta-chip-icon">🎯</span>
            <span class="meta-chip-label" id="modal-world-missions-count">3 Misi Petualangan</span>
          </div>
          <div class="world-meta-chip">
            <span class="meta-chip-icon">⚡</span>
            <span class="meta-chip-label" id="modal-world-xp-reward">Total 300 XP Menantimu</span>
          </div>
        </div>

        <div class="world-modal-missions-label">
          <span>Daftar Misi di Pulau Ini</span>
          <span style="font-size: 0.76rem; color: #64748B; font-weight: 600;">Tahap Petualangan</span>
        </div>

        <div class="world-modal-missions-list" id="modal-missions-list">
          <!-- Populated by JavaScript -->
        </div>
      </div>

      <div class="world-modal-footer-row">
        <button type="button" class="btn-kid btn-kid-ghost" id="btn-modal-cancel">Tutup</button>
        <a href="?page=register" class="btn-kid btn-kid-primary" id="btn-modal-start-cta">
          <span id="btn-modal-start-text">Mulai Petualangan di Number City</span>
          <span>➔</span>
        </a>
      </div>
    </div>
  </div>

  <!-- =========================================================================
       3. KENALAN DENGAN MIKO SECTION (AI Companion Showcase)
       ========================================================================= -->
  <section id="miko" class="miko-spotlight-section">
    <div class="container miko-spotlight-grid">
      <!-- MIKO Mascot Visual & Speech Bubble (Interactive Avatar Voice Trigger) -->
      <div class="miko-visual-column">
        <div 
          class="miko-mascot-wrapper miko-avatar-btn" 
          id="miko-avatar-trigger" 
          role="button" 
          tabindex="0" 
          aria-label="Klik Miko untuk mendengarkan suaraku!" 
          aria-pressed="false"
          title="Klik Miko untuk mendengarkan suaraku!"
        >
          <!-- Waving Mascot Dialogue Balloon (Dedicated speech container above Miko) -->
          <div class="miko-waving-balloon">
            <div class="miko-balloon-content">
              <span class="miko-balloon-heading">Aku MIKO! 🤖</span>
              <span class="miko-balloon-sub" id="miko-balloon-subtitle">Teman belajarmu di setiap petualangan!</span>
            </div>
            <div class="miko-balloon-pointer" aria-hidden="true"></div>
          </div>

          <!-- Mascot Interactive Image with Speaking Halo/Glow -->
          <div class="miko-img-container">
            <img src="assets/images/miko_companion_wave.jpg" alt="MIKO si Robot Sahabat Belajar Ramah Anak" class="miko-mascot-img" draggable="false">
            <div class="miko-speaking-halo" aria-hidden="true"></div>
            
            <!-- Sound Wave Speaking Indicator (Active during playback) -->
            <div class="miko-voice-wave-indicator" aria-hidden="true">
              <span class="wave-bar"></span>
              <span class="wave-bar"></span>
              <span class="wave-bar"></span>
              <span class="wave-bar"></span>
              <span class="wave-text">Miko Sedang Berbicara...</span>
            </div>
          </div>

          <!-- Friendly Interactive Tooltip / Hint Pill -->
          <div class="miko-click-hint-pill" id="miko-click-hint" aria-hidden="true">
            <span class="hint-icon">🔊</span>
            <span class="hint-text">Klik Miko untuk mendengarkan suaraku!</span>
            <span class="hint-sparkle sparkle-anim">✨</span>
          </div>
        </div>

        <!-- Dedicated Single-Source-of-Truth Miko Speech Box Under Mascot -->
        <div class="miko-speech-card" id="miko-speech-card" aria-live="polite">
          <div class="miko-speech-header">
            <div class="miko-speech-badge">
              <span>💬</span> Ucapan AI Miko
            </div>
            <span class="miko-speech-status" id="miko-speech-status">Siap didengarkan</span>
          </div>
          <div class="miko-speech-text" id="miko-speech-text">
            Halo Sahabat Cilik! Aku MIKO, teman belajarmu di setiap petualangan! Ayo jelajahi empat dunia seru di MISSION KIDS dan kumpulkan banyak bintang!
          </div>
          
          <!-- Interactive Topic Chips (Interaksi langsung dengan Miko) -->
          <div class="miko-topic-chips" id="miko-topic-chips" role="group" aria-label="Pilih topik interaksi Miko">
            <button type="button" class="miko-topic-chip active" data-topic="intro" aria-label="Topik: Siapa Miko?">👋 Siapa Miko?</button>
            <button type="button" class="miko-topic-chip" data-topic="worlds" aria-label="Topik: Cerita 4 Dunia">🗺️ Cerita 4 Dunia</button>
            <button type="button" class="miko-topic-chip" data-topic="tips" aria-label="Topik: Tips Belajar Seru">💡 Tips Belajar Seru</button>
            <button type="button" class="miko-topic-chip" data-topic="cheer" aria-label="Topik: Semangat Juara">⭐ Semangat Juara</button>
          </div>

          <div class="miko-speech-footer-note">
            <span class="note-icon">👉</span>
            <span class="note-text">Klik avatar Miko di atas untuk mendengarkan kalimat di atas!</span>
          </div>
        </div>
      </div>

      <!-- MIKO Story & Companion Narrative -->
      <div class="miko-text-column">
        <div class="badge-pill badge-pill-miko">
          <span>🤖</span> Teman Setia Belajarmu
        </div>

        <h2 class="miko-section-heading">Kenalan dengan MIKO</h2>

        <p class="miko-section-desc">
          MIKO adalah AI Companion yang selalu menemani, memberi petunjuk, menjelaskan materi dengan cara yang menyenangkan, dan merayakan setiap pencapaianmu.
        </p>

        <!-- Companion Highlights & Perks to balance layout -->
        <div class="miko-perks-list">
          <div class="miko-perk-card">
            <div class="miko-perk-icon" style="background: #EFF6FF; color: #2563EB;">🗣️</div>
            <div class="miko-perk-body">
              <h4 class="miko-perk-title">Panduan Suara Interaktif</h4>
              <p class="miko-perk-desc">Mendengarkan arahan belajar dan instruksi misi lewat suara ramah anak yang mudah dipahami.</p>
            </div>
          </div>
          <div class="miko-perk-card">
            <div class="miko-perk-icon" style="background: #FEF3C7; color: #D97706;">💡</div>
            <div class="miko-perk-body">
              <h4 class="miko-perk-title">Petunjuk Pintar Bertingkat</h4>
              <p class="miko-perk-desc">Memberikan bimbingan terarah saat anak merasa bingung tanpa mengurangi rasa ingin tahu.</p>
            </div>
          </div>
          <div class="miko-perk-card">
            <div class="miko-perk-icon" style="background: #FDF2F8; color: #DB2777;">⭐</div>
            <div class="miko-perk-body">
              <h4 class="miko-perk-title">Motivasi & Apresiasi Bintang</h4>
              <p class="miko-perk-desc">Selalu menyemangati dan merayakan setiap pencapaian serta petualangan baru yang diselesaikan.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- =========================================================================
       4. KENAPA MEMILIH MISSION KIDS? (Editorial Learning Benefits)
       ========================================================================= -->
  <section id="fitur" class="editorial-benefits-section">
    <div class="container editorial-benefits-grid">
      <!-- Left Editorial Intro -->
      <div class="benefits-intro-column">
        <div class="badge-pill badge-pill-primary" style="margin-bottom: 0.6rem; font-size: var(--fs-xs);">
          <span>💡</span> Kenapa Memilih MISSION KIDS?
        </div>
        <h2 class="benefits-headline">
          Belajar Jadi Lebih Seru!
        </h2>
        <p class="benefits-subtext">
          Dengan cara yang menyenangkan, anak bisa tumbuh lebih percaya diri dan siap menghadapi masa depan.
        </p>
      </div>

      <!-- Right 3 Pillars Horizontal Stack -->
      <div class="benefits-pillars-column">
        <!-- Pillar 1: Petualangan Interaktif -->
        <div class="benefit-clean-card">
          <div class="benefit-icon-badge badge-color-blue">
            <span>🎮</span>
          </div>
          <div class="benefit-card-content">
            <h3 class="benefit-card-title">Petualangan Interaktif</h3>
            <p class="benefit-card-desc">Belajar melalui tantangan dan mini-game yang seru.</p>
          </div>
        </div>

        <!-- Pillar 2: Melatih Logika & Kreativitas -->
        <div class="benefit-clean-card">
          <div class="benefit-icon-badge badge-color-yellow">
            <span>💡</span>
          </div>
          <div class="benefit-card-content">
            <h3 class="benefit-card-title">Melatih Logika & Kreativitas</h3>
            <p class="benefit-card-desc">Memecahkan masalah dengan cara yang menyenangkan.</p>
          </div>
        </div>

        <!-- Pillar 3: Dapatkan Penghargaan -->
        <div class="benefit-clean-card">
          <div class="benefit-icon-badge badge-color-purple">
            <span>🏅</span>
          </div>
          <div class="benefit-card-content">
            <h3 class="benefit-card-title">Dapatkan Penghargaan</h3>
            <p class="benefit-card-desc">Kumpulkan bintang, medali, dan naik level.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- =========================================================================
       5. CTA CLOSING BANNER: Petualangan Seru Menunggumu!
       ========================================================================= -->
  <section id="tentang" class="cta-adventure-banner-section">
    <div class="container">
      <div class="cta-adventure-box">
        <!-- Flying Rocket MIKO Mascot -->
        <div class="cta-flying-miko-col">
          <img src="assets/images/miko_cta_rocket.jpg" alt="MIKO Terbang Bersama Roket" class="cta-flying-miko-img">
        </div>

        <!-- Text & Action Button -->
        <div class="cta-box-center-content">
          <h2 class="cta-banner-heading">
            Petualangan Seru Menunggumu!
          </h2>
          <p class="cta-banner-subtext">
            Buat akun dan mulai jelajahi tantangan belajar bersama MIKO.
          </p>
          <div style="margin-top: 1.25rem;">
            <a href="?page=register" class="btn-cta-gold shine-effect" id="btn-cta-register-bottom">
              <span>Daftar Gratis</span>
              <span>➔</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

</div>

<script>
window.WORLD_MAP_DATA = <?= json_encode($defaultWorldsData, JSON_UNESCAPED_UNICODE) ?>;

document.addEventListener('DOMContentLoaded', () => {
  // 1. Interactive Avatar Controller for AI MIKO with Single Source of Truth
  const mikoAvatarTrigger = document.getElementById('miko-avatar-trigger');
  const mikoClickHint = document.getElementById('miko-click-hint');
  const mikoBalloonSubtitle = document.getElementById('miko-balloon-subtitle');
  const mikoSpeechText = document.getElementById('miko-speech-text');
  const mikoSpeechStatus = document.getElementById('miko-speech-status');
  const topicChips = document.querySelectorAll('.miko-topic-chip');

  const MIKO_TOPICS = {
    intro: {
      balloon: 'Teman belajarmu di setiap petualangan!',
      text: 'Halo Sahabat Cilik! Aku MIKO, teman belajarmu di setiap petualangan! Ayo jelajahi empat dunia seru di MISSION KIDS dan kumpulkan banyak bintang!',
      audio: '/audio/miko/topic_intro.mp3'
    },
    worlds: {
      balloon: 'Ada empat pulau petualangan seru!',
      text: 'Ada empat dunia menakjubkan di MISSION KIDS: Number City pulau matematika, Discovery Lab ilmu alam, Thinking Lab logika teka-teki, dan Space Odyssey roket antariksa!',
      audio: '/audio/miko/topic_worlds.mp3'
    },
    tips: {
      balloon: 'Belajar perlahan dan nikmati prosesnya!',
      text: 'Belajar sedikit demi sedikit setiap hari membuat otakmu semakin hebat dan cerdas! Jangan takut salah, karena dari salah kita bisa belajar hal baru!',
      audio: '/audio/miko/topic_tips.mp3'
    },
    cheer: {
      balloon: 'Kamu pasti bisa jadi juara hebat!',
      text: 'Kamu adalah kapten cilik yang hebat dan pemberani! Kumpulkan bintang, selesaikan misi, dan raih prestasi terbaikmu bersama MIKO!',
      audio: '/audio/miko/topic_cheer.mp3'
    }
  };

  let currentTopicKey = 'intro';
  let activeSpeechId = 0;
  let isSpeaking = false;
  let activeMikoAudio = null;

  function updateMikoUi(speaking) {
    isSpeaking = speaking;
    if (mikoAvatarTrigger) {
      if (speaking) {
        mikoAvatarTrigger.classList.add('miko-speaking');
        mikoAvatarTrigger.setAttribute('aria-pressed', 'true');
      } else {
        mikoAvatarTrigger.classList.remove('miko-speaking');
        mikoAvatarTrigger.setAttribute('aria-pressed', 'false');
      }
    }
    if (mikoSpeechStatus) {
      if (speaking) {
        mikoSpeechStatus.classList.add('speaking');
        mikoSpeechStatus.textContent = '🔊 Sedang berbicara...';
      } else {
        mikoSpeechStatus.classList.remove('speaking');
        mikoSpeechStatus.textContent = 'Siap didengarkan';
      }
    }
    if (mikoClickHint) {
      if (speaking) {
        mikoClickHint.innerHTML = '<span class="hint-icon">🔊</span><span class="hint-text">Sedang berbicara... Klik untuk berhenti!</span>';
      } else {
        mikoClickHint.innerHTML = '<span class="hint-icon">🔊</span><span class="hint-text">Klik Miko untuk mendengarkan suaraku!</span><span class="hint-sparkle sparkle-anim">✨</span>';
      }
    }
    if (mikoBalloonSubtitle) {
      if (speaking) {
        mikoBalloonSubtitle.textContent = 'Aku siap bertualang bersamamu!';
      } else {
        mikoBalloonSubtitle.textContent = MIKO_TOPICS[currentTopicKey] ? MIKO_TOPICS[currentTopicKey].balloon : 'Teman belajarmu di setiap petualangan!';
      }
    }
  }

  function stopMikoVoice() {
    activeSpeechId++;
    if (activeMikoAudio) {
      try {
        activeMikoAudio.pause();
        activeMikoAudio.currentTime = 0;
      } catch (e) {}
      activeMikoAudio = null;
    }
    if (window.mikoCompanion && typeof window.mikoCompanion.stopSpeaking === 'function') {
      window.mikoCompanion.stopSpeaking();
    }
    if (window.SoundFX && typeof window.SoundFX.stopRobotCartoon === 'function') {
      window.SoundFX.stopRobotCartoon();
    }
    if (window.speechSynthesis) {
      try { window.speechSynthesis.cancel(); } catch (e) {}
    }
    updateMikoUi(false);
  }

  function playCuteTtsVoice(text, onComplete, speechId = null) {
    if (typeof window === 'undefined' || !window.speechSynthesis) {
      if (typeof onComplete === 'function') onComplete();
      return;
    }
    const myId = speechId || activeSpeechId;

    try {
      window.speechSynthesis.cancel();

      const bestVoice = (window.MIKO_VOICE_CONFIG && typeof window.MIKO_VOICE_CONFIG.getBestVoice === 'function')
        ? window.MIKO_VOICE_CONFIG.getBestVoice()
        : ((window.MIKO_VOICE_CONFIG && typeof window.MIKO_VOICE_CONFIG.getBestCuteVoice === 'function')
            ? window.MIKO_VOICE_CONFIG.getBestCuteVoice()
            : null);

      const utterance = new SpeechSynthesisUtterance(text);
      utterance.lang = 'id-ID';

      if (bestVoice) {
        utterance.voice = bestVoice;
        if (bestVoice.lang && (bestVoice.lang.startsWith('id') || bestVoice.lang.includes('ID'))) {
          utterance.lang = bestVoice.lang;
        }
      }

      // Karakter Suara AI MIKO Lucu Laki-Laki & Bahasa Indonesia:
      // - Jika Microsoft Ardi (suara pria asli): pitch 1.16 memberi nada anak laki-laki ceria & bersemangat
      // - Jika Google Bahasa Indonesia: pitch 1.25 memberi nada maskot anak laki-laki lucu (cute anime boy robot)
      const isArdiMale = bestVoice && /ardi|andika|male|pria|laki/i.test(bestVoice.name);
      utterance.pitch = isArdiMale ? 1.16 : 1.25;
      utterance.rate = (window.MIKO_VOICE_CONFIG && window.MIKO_VOICE_CONFIG.rate !== undefined) ? window.MIKO_VOICE_CONFIG.rate : 1.05;
      utterance.volume = 1.0;

      utterance.onend = () => {
        if (activeSpeechId === myId && typeof onComplete === 'function') onComplete();
      };
      utterance.onerror = () => {
        if (activeSpeechId === myId && typeof onComplete === 'function') onComplete();
      };

      window.speechSynthesis.speak(utterance);
    } catch (e) {
      if (typeof onComplete === 'function') onComplete();
    }
  }

  function playMikoVoice() {
    // 1. Single source of truth: Get the exact text currently displayed under Miko
    const targetText = mikoSpeechText ? mikoSpeechText.textContent.trim() : 'Halo Sahabat Cilik! Aku MIKO, teman belajarmu di setiap petualangan! Ayo jelajahi empat dunia seru di MISSION KIDS dan kumpulkan banyak bintang!';
    
    // 2. Stop any ongoing audio immediately to prevent collision
    stopMikoVoice();
    const myId = ++activeSpeechId;
    updateMikoUi(true);

    const onDone = () => {
      if (activeSpeechId === myId) {
        activeMikoAudio = null;
        updateMikoUi(false);
      }
    };

    // 3. Play Natural Expressive Indonesian Boy Voice (Microsoft id-ID-ArdiNeural)
    const topicAudio = (MIKO_TOPICS[currentTopicKey] && mikoSpeechText && mikoSpeechText.textContent.trim() === MIKO_TOPICS[currentTopicKey].text.trim())
      ? MIKO_TOPICS[currentTopicKey].audio
      : null;

    if (topicAudio) {
      try {
        const audio = new Audio(topicAudio + '?v=5.1');
        activeMikoAudio = audio;
        audio.onended = () => {
          onDone();
        };
        audio.onerror = () => {
          if (activeSpeechId === myId) {
            playCuteTtsVoice(targetText, onDone, myId);
          }
        };
        const playPromise = audio.play();
        if (playPromise !== undefined) {
          playPromise.catch(() => {
            if (activeSpeechId === myId) {
              playCuteTtsVoice(targetText, onDone, myId);
            }
          });
        }
        return;
      } catch (err) {
        // Fallback to TTS
      }
    }

    // 4. Shared Unified Miko Voice Engine for ALL interactions & buttons (Consistent male voice, pitch 1.16/1.25, rate 1.05)
    playCuteTtsVoice(targetText, onDone, myId);
  }

  // Set topic response handler (Satu Sumber Respons)
  function setMikoTopic(topicKey, autoPlay = true) {
    if (!MIKO_TOPICS[topicKey]) return;
    currentTopicKey = topicKey;

    // Update active chip
    topicChips.forEach(chip => {
      if (chip.dataset.topic === topicKey) {
        chip.classList.add('active');
        chip.setAttribute('aria-pressed', 'true');
      } else {
        chip.classList.remove('active');
        chip.setAttribute('aria-pressed', 'false');
      }
    });

    // Update text under Miko (Single source of truth)
    if (mikoSpeechText) {
      mikoSpeechText.textContent = MIKO_TOPICS[topicKey].text;
    }
    if (mikoBalloonSubtitle) {
      mikoBalloonSubtitle.textContent = MIKO_TOPICS[topicKey].balloon;
    }

    if (autoPlay) {
      playMikoVoice();
    } else {
      stopMikoVoice();
    }
  }

  // Event listener for interactive topic chips
  topicChips.forEach(chip => {
    chip.addEventListener('click', (e) => {
      e.stopPropagation();
      const topic = chip.dataset.topic;
      setMikoTopic(topic, true);
    });
  });

  if (mikoAvatarTrigger) {
    mikoAvatarTrigger.addEventListener('click', (e) => {
      e.preventDefault();
      if (isSpeaking || mikoAvatarTrigger.classList.contains('miko-speaking')) {
        stopMikoVoice();
      } else {
        playMikoVoice();
      }
    });

    mikoAvatarTrigger.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        if (isSpeaking || mikoAvatarTrigger.classList.contains('miko-speaking')) {
          stopMikoVoice();
        } else {
          playMikoVoice();
        }
      }
    });

    // Observer to reset UI when speech finishes naturally via MikoCompanion.setSpeakingState(false)
    const speakingObserver = new MutationObserver(() => {
      const active = mikoAvatarTrigger.classList.contains('miko-speaking');
      if (!active && isSpeaking) {
        updateMikoUi(false);
      }
    });
    speakingObserver.observe(mikoAvatarTrigger, { attributes: true, attributeFilter: ['class'] });
  }

  // 2. Interactive World Map Hotspots & World Detail Modal
  const modal = document.getElementById('world-detail-modal');
  const modalHero = document.getElementById('modal-world-hero');
  const modalIcon = document.getElementById('modal-world-icon');
  const modalTitle = document.getElementById('modal-world-title');
  const modalSubtitle = document.getElementById('modal-world-subtitle');
  const modalMissionsCount = document.getElementById('modal-world-missions-count');
  const modalXpReward = document.getElementById('modal-world-xp-reward');
  const modalMissionsList = document.getElementById('modal-missions-list');
  const modalStartCta = document.getElementById('btn-modal-start-cta');
  const modalStartText = document.getElementById('btn-modal-start-text');
  const btnCloseModal = document.getElementById('btn-close-world-modal');
  const btnCancelModal = document.getElementById('btn-modal-cancel');

  let lastFocusedElement = null;

  function openWorldModal(worldSlug) {
    const data = window.WORLD_MAP_DATA && window.WORLD_MAP_DATA[worldSlug];
    if (!data) return;

    if (window.SoundFX && typeof window.SoundFX.playTap === 'function') {
      window.SoundFX.playTap();
    }

    lastFocusedElement = document.activeElement;

    // Reset Hero Classes & Apply Active Theme
    modalHero.className = 'world-modal-hero ' + (data.theme_class || 'theme-number');
    modalIcon.textContent = data.icon || '🗺️';
    modalTitle.textContent = data.title || 'Dunia Petualangan';
    modalSubtitle.textContent = data.subtitle || '';
    modalMissionsCount.textContent = (data.missions ? data.missions.length : 3) + ' Misi Pembelajaran';
    
    const totalXp = (data.missions ? data.missions.reduce((sum, m) => sum + (m.xp || 100), 0) : 300);
    modalXpReward.textContent = 'Total ' + totalXp + ' XP Menantimu';

    // Populate Missions List
    if (modalMissionsList && data.missions) {
      modalMissionsList.innerHTML = '';
      data.missions.forEach((m, idx) => {
        const item = document.createElement('div');
        item.className = 'world-modal-mission-item';

        const isCompleted = m.status === 'completed';
        const isAvailable = m.status === 'available' || idx === 0;

        let statusClass = 'status-locked';
        let statusLabel = '🔒 Terkunci';
        if (isCompleted) {
          statusClass = 'status-completed';
          statusLabel = '⭐ Selesai';
        } else if (isAvailable) {
          statusClass = 'status-available';
          statusLabel = '⚡ Siap Dimainkan';
        }

        item.innerHTML = `
          <div class="mission-item-left">
            <div class="mission-item-number">${idx + 1}</div>
            <div class="mission-item-info">
              <h5>${escapeHtml(m.title)}</h5>
              <p>🎯 ${escapeHtml(m.objective || m.desc || '')}</p>
            </div>
          </div>
          <span class="mission-status-pill ${statusClass}">${statusLabel}</span>
        `;
        modalMissionsList.appendChild(item);
      });
    }

    // Update CTA Button
    modalStartText.textContent = 'Mulai Petualangan di ' + data.title;
    modalStartCta.href = '?page=register&world=' + encodeURIComponent(data.slug);

    // Open Modal with Animation & Keyboard Trap
    modal.classList.add('is-open');
    modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';

    // Focus close button for accessibility
    setTimeout(() => {
      if (btnCloseModal) btnCloseModal.focus();
    }, 100);
  }

  function closeWorldModal() {
    if (!modal.classList.contains('is-open')) return;

    if (window.SoundFX && typeof window.SoundFX.playTap === 'function') {
      window.SoundFX.playTap();
    }

    modal.classList.remove('is-open');
    modal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';

    if (lastFocusedElement && typeof lastFocusedElement.focus === 'function') {
      lastFocusedElement.focus();
    }
  }

  function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text || '';
    return div.innerHTML;
  }

  // Attach Click & Keyboard Listeners to Island Badges, Pins, and Hitboxes
  const interactiveTriggers = document.querySelectorAll('.island-hitbox, .map-island-badge, .map-pin-anchor');
  interactiveTriggers.forEach(el => {
    el.addEventListener('click', (e) => {
      e.preventDefault();
      const worldSlug = el.getAttribute('data-world');
      if (worldSlug) {
        openWorldModal(worldSlug);
      }
    });

    el.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        const worldSlug = el.getAttribute('data-world');
        if (worldSlug) {
          openWorldModal(worldSlug);
        }
      }
    });
  });

  // Close Modal Triggers
  if (btnCloseModal) {
    btnCloseModal.addEventListener('click', closeWorldModal);
  }
  if (btnCancelModal) {
    btnCancelModal.addEventListener('click', closeWorldModal);
  }

  modal.addEventListener('click', (e) => {
    if (e.target === modal) {
      closeWorldModal();
    }
  });

  window.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && modal.classList.contains('is-open')) {
      closeWorldModal();
    }
  });
});
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
