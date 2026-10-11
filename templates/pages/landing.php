<?php
/**
 * MISSION KIDS — Landing Page
 */

declare(strict_types=1);

require __DIR__ . '/../layouts/header.php';
?>

<div class="container">

  <!-- Hero Section (Desktop 2-Column Split & Mobile Stacked) -->
  <section class="hero-grid-split">
    <div class="hero-content-left">
      <div class="badge-pill badge-pill-primary" style="margin-bottom: var(--space-4); display: inline-flex; align-items: center; gap: 6px; font-size: var(--fs-xs);">
        <span>🚀</span> MISSION KIDS • Petualangan Misimu Dimulai di Sini.
      </div>
      <h1 class="hero-title-main">
        Petualangan Seru<br>untuk Anak Hebat!
      </h1>
      <p class="hero-subtext-main">
        Ayo bantu MIKO memecahkan teka-teki seru, kumpulkan bintang, dan jadilah penemu cilik!
      </p>
      <div>
        <a href="?page=register" class="hero-cta-btn-pill shine-effect" id="hero-btn-cta">
          <span>Mulai Petualangan</span>
          <span style="font-size: 1.25rem;">➔</span>
        </a>
      </div>
    </div>

    <div class="hero-media-right">
      <div class="hero-art-wrapper">
        <img src="assets/images/hero.jpg" alt="Petualangan MIKO dan Sahabat Cilik" class="hero-art-image">
        <div class="hero-float-bubble">
          <span>✨</span> Belajar Sambil Bermain!
        </div>
      </div>
    </div>
  </section>

  <!-- Fitur Unggulan -->
  <section id="fitur" style="margin-bottom: var(--space-6);">
    <h2 class="features-section-title">Fitur Unggulan</h2>
    <div class="features-grid-row">
      <div class="feature-pill-card">
        <div class="feature-icon-circle feature-icon-blue">🧪</div>
        <h3 class="feature-card-heading">Eksperimen Sains</h3>
        <p class="feature-card-desc">Jelajahi dunia sains dengan cara yang menyenangkan!</p>
      </div>

      <div class="feature-pill-card">
        <div class="feature-icon-circle feature-icon-purple">🧩</div>
        <h3 class="feature-card-heading">Logika & Pola</h3>
        <p class="feature-card-desc">Latih kemampuan berpikir kritis dan kreatif!</p>
      </div>

      <div class="feature-pill-card">
        <div class="feature-icon-circle feature-icon-cyan">🤖</div>
        <h3 class="feature-card-heading">Pemrograman Dasar</h3>
        <p class="feature-card-desc">Beri perintah ke robot dan lihat hasilnya!</p>
      </div>

      <div class="feature-pill-card">
        <div class="feature-icon-circle feature-icon-gold">🏆</div>
        <h3 class="feature-card-heading">Reward & Pencapaian</h3>
        <p class="feature-card-desc">Kumpulkan bintang, naik level, dan buka dunia baru!</p>
      </div>
    </div>
  </section>

  <!-- 3 Dunia Petualangan -->
  <section id="dunia" style="margin-bottom: var(--space-10);">
    <h2 class="features-section-title">3 Dunia Petualangan</h2>
    <div class="worlds-showcase-grid">
      <!-- World 1: Number City -->
      <div class="world-showcase-card">
        <div class="world-thumb-container">
          <img src="assets/images/number-city.jpg" alt="Number City" class="world-thumb-img">
        </div>
        <div class="world-showcase-body">
          <h3 class="world-showcase-title">Number City</h3>
          <p class="world-showcase-sub">Angka, Belanja & Pola Logika</p>
          <a href="?page=register" class="btn-kid btn-kid-secondary" style="width: 100%; margin-top: auto; border-radius: var(--radius-pill);">
            Jelajahi Number City
          </a>
        </div>
      </div>

      <!-- World 2: Discovery Lab -->
      <div class="world-showcase-card">
        <div class="world-thumb-container">
          <img src="assets/images/discovery-lab.jpg" alt="Discovery Lab" class="world-thumb-img">
        </div>
        <div class="world-showcase-body">
          <h3 class="world-showcase-title">Discovery Lab</h3>
          <p class="world-showcase-sub">Sains & Alam</p>
          <a href="?page=register" class="btn-kid btn-kid-accent" style="width: 100%; margin-top: auto; border-radius: var(--radius-pill);">
            Masuk ke Discovery Lab
          </a>
        </div>
      </div>

      <!-- World 3: Thinking Lab -->
      <div class="world-showcase-card">
        <div class="world-thumb-container">
          <img src="assets/images/thinking-lab.jpg" alt="Thinking Lab" class="world-thumb-img">
        </div>
        <div class="world-showcase-body">
          <h3 class="world-showcase-title">Thinking Lab</h3>
          <p class="world-showcase-sub">Logika & Robot</p>
          <a href="?page=register" class="btn-kid btn-kid-purple" style="width: 100%; margin-top: auto; border-radius: var(--radius-pill);">
            Buka Thinking Lab
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA Box -->
  <section id="tentang" style="background: linear-gradient(135deg, var(--color-primary), #1D4ED8); border-radius: var(--radius-2xl); padding: var(--space-8) var(--space-6); text-align: center; color: #FFFFFF; margin-bottom: var(--space-12); box-shadow: var(--shadow-lg);">
    <h2 style="color: #FFFFFF; font-size: var(--fs-2xl); margin-bottom: var(--space-2);">Siap Memulai Misi Pertamamu?</h2>
    <p style="color: #DBEAFE; font-size: var(--fs-md); max-width: 550px; margin: 0 auto var(--space-5);">
      Bergabunglah sekarang dan rasakan serunya belajar dengan cara memecahkan masalah nyata bersama MIKO.
    </p>
    <a href="?page=register" class="btn-kid btn-kid-secondary" style="padding: 0.85rem 2.2rem; font-size: var(--fs-md); border-radius: var(--radius-pill);">
      Daftar Gratis Sekarang 🌟
    </a>
  </section>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
