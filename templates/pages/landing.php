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
            <span class="ribbon-text">12 Misi Menarik</span>
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
  <section id="dunia" class="worlds-adventure-section">
    <div class="container">
      <!-- Section Header -->
      <div class="section-header-row">
        <div>
          <div class="badge-pill badge-pill-primary" style="margin-bottom: 0.6rem; font-size: var(--fs-xs);">
            <span>🗺️</span> 4 Dunia, 12 Misi Seru
          </div>
          <h2 class="section-title-bold">Dunia Petualangan</h2>
          <p class="section-subtitle-muted">
            Setiap dunia punya tantangan unik yang akan mengasah logika, pengetahuan, dan kreativitasmu!
          </p>
        </div>
        <div class="section-header-action">
          <a href="?page=register" class="link-bold-accent">
            <span>Lihat Semua Dunia</span>
            <span>➔</span>
          </a>
        </div>
      </div>

      <!-- Visual Adventure Trail Map -->
      <div class="worlds-trail-map-container">
        <img src="assets/images/worlds_adventure_map.jpg" alt="Peta Petualangan 4 Pulau Terapung MISSION KIDS" class="worlds-trail-map-img">
      </div>

      <!-- 4 Connected World Feature Cards -->
      <div class="worlds-interactive-grid">
        <!-- World 1: Number City -->
        <a href="?page=register" class="world-node-card world-card-number">
          <div class="world-card-icon-pill icon-bg-number">
            <span>🧮</span>
          </div>
          <div class="world-card-text">
            <h3 class="world-card-name">Number City</h3>
            <p class="world-card-theme">Aritmetika, Deret & Logika Pola</p>
          </div>
          <div class="world-card-cta cta-text-number">
            <span>3 Misi</span>
            <span>➔</span>
          </div>
        </a>

        <!-- World 2: Discovery Lab -->
        <a href="?page=register" class="world-node-card world-card-discovery">
          <div class="world-card-icon-pill icon-bg-discovery">
            <span>🌿</span>
          </div>
          <div class="world-card-text">
            <h3 class="world-card-name">Discovery Lab</h3>
            <p class="world-card-theme">Sains, Fotosintesis, Optik & Siklus Air</p>
          </div>
          <div class="world-card-cta cta-text-discovery">
            <span>3 Misi</span>
            <span>➔</span>
          </div>
        </a>

        <!-- World 3: Thinking Lab -->
        <a href="?page=register" class="world-node-card world-card-thinking">
          <div class="world-card-icon-pill icon-bg-thinking">
            <span>🤖</span>
          </div>
          <div class="world-card-text">
            <h3 class="world-card-name">Thinking Lab</h3>
            <p class="world-card-theme">Berpikir Komputasional, Algoritma & Loop</p>
          </div>
          <div class="world-card-cta cta-text-thinking">
            <span>3 Misi</span>
            <span>➔</span>
          </div>
        </a>

        <!-- World 4: Space Odyssey -->
        <a href="?page=register" class="world-node-card world-card-space">
          <div class="world-card-icon-pill icon-bg-space">
            <span>🚀</span>
          </div>
          <div class="world-card-text">
            <h3 class="world-card-name">Space Odyssey</h3>
            <p class="world-card-theme">Navigasi Angkasa, Sudut, Radar & Grid</p>
          </div>
          <div class="world-card-cta cta-text-space">
            <span>3 Misi</span>
            <span>➔</span>
          </div>
        </a>
      </div>
    </div>
  </section>

  <!-- =========================================================================
       3. KENALAN DENGAN MIKO SECTION (AI Companion Showcase)
       ========================================================================= -->
  <section id="miko" class="miko-spotlight-section">
    <div class="container miko-spotlight-grid">
      <!-- MIKO Mascot Visual & Speech Bubble -->
      <div class="miko-visual-column">
        <div class="miko-mascot-wrapper">
          <img src="assets/images/miko_companion_wave.jpg" alt="MIKO si Robot Sahabat Belajar Ramah Anak" class="miko-mascot-img">
          <!-- Waving Mascot Dialogue Balloon -->
          <div class="miko-waving-balloon">
            <span class="miko-balloon-heading">Aku MIKO!</span>
            <span class="miko-balloon-sub">Teman belajarmu di setiap petualangan!</span>
            <div class="miko-balloon-pointer"></div>
          </div>
        </div>
      </div>

      <!-- MIKO Story & Interactive Voice Trigger -->
      <div class="miko-text-column">
        <div class="badge-pill badge-pill-miko">
          <span>🤖</span> Teman Setia Belajarmu
        </div>

        <h2 class="miko-section-heading">Kenalan dengan MIKO</h2>

        <p class="miko-section-desc">
          MIKO adalah AI Companion yang selalu menemani, memberi petunjuk, menjelaskan materi dengan cara yang menyenangkan, dan merayakan setiap pencapaianmu.
        </p>

        <div>
          <button type="button" class="btn-kid btn-kid-primary btn-miko-listen-voice" id="btn-miko-voice-action">
            <span style="font-size: 1.25rem;">🔊</span>
            <span>Dengar Suara MIKO</span>
          </button>
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
document.addEventListener('DOMContentLoaded', () => {
  // Interactive Voice Button for MIKO Introduction
  const mikoVoiceBtn = document.getElementById('btn-miko-voice-action');
  if (mikoVoiceBtn) {
    mikoVoiceBtn.addEventListener('click', () => {
      if (window.SoundFX) {
        window.SoundFX.playStar(0);
      }
      if (window.mikoCompanion && typeof window.mikoCompanion.speak === 'function') {
        window.mikoCompanion.speak('Halo Sahabat Cilik! Aku MIKO, teman petualangan belajarmu di MISSION KIDS! Ayo jelajahi empat dunia seru dan kumpulkan bintang!');
      } else if (window.SoundFX && typeof window.SoundFX.speakRobotCartoon === 'function') {
        window.SoundFX.speakRobotCartoon('Halo Sahabat Cilik! Aku MIKO, teman petualangan belajarmu!');
      }
    });
  }
});
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
