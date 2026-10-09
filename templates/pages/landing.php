<?php
/**
 * MISSION KIDS — Landing Page
 */

declare(strict_types=1);

require __DIR__ . '/../layouts/header.php';
?>

<div class="container" style="position: relative;">
  <!-- Floating Atmospheric Stickers -->
  <div class="floating-badge-item floating-badge-1">🪐 Discovery Lab</div>
  <div class="floating-badge-item floating-badge-2">⭐ +100 XP Misi</div>
  <div class="floating-badge-item floating-badge-3">🧩 Jembatan Angka</div>
  <div class="floating-badge-item floating-badge-4">🤖 Robot Botty</div>

  <!-- Hero Section -->
  <section style="text-align: center; padding: var(--space-12) 0 var(--space-8); max-width: 820px; margin: 0 auto; position: relative; z-index: 1;">
    <div class="badge-pill badge-pill-primary" style="margin-bottom: var(--space-4); font-size: var(--fs-sm); animation: pulseGlow 3s infinite;">
      🌟 Platform Edukasi Interaktif Berbasis Misi untuk Anak SD
    </div>
    <h1 style="font-size: clamp(2.2rem, 5vw, 3.5rem); margin-bottom: var(--space-4); letter-spacing: -0.02em;">
      Petualangan Misimu Dimulai di Sini.
    </h1>
    <p style="font-size: var(--fs-xl); line-height: 1.6; color: var(--text-muted); margin-bottom: var(--space-8);">
      Belajar. Jelajah. Pecahkan tantangan. Hadapi masalah nyata, bereksperimen dengan objek interaktif, dan kembangkan rasa ingin tahumu bersama sahabat AI <strong>MIKO</strong>!
    </p>
    <div class="hero-actions-row">
      <a href="?page=register" class="btn-kid btn-kid-primary hero-cta-btn shine-effect" id="hero-btn-cta" style="font-size: 1.15rem; padding: 1.1rem 2.4rem;">
        Mulai Petualangan <span style="display: inline-block; animation: floatRocket 3s ease-in-out infinite;">🚀</span>
      </a>
      <a href="?page=login" class="btn-kid btn-kid-ghost hero-cta-btn">
        Sudah Punya Akun? Masuk
      </a>
    </div>
  </section>

  <!-- 4 Core Pillars -->
  <section style="padding: var(--space-10) 0;">
    <div style="text-align: center; margin-bottom: var(--space-8);">
      <h2 style="font-size: var(--fs-3xl); margin-bottom: var(--space-2);">Mengapa Belajar di MISSION KIDS?</h2>
      <p style="font-size: var(--fs-md);">Bukan sekadar kuis atau video, anak belajar melalui tindakan nyata.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: var(--space-6);">
      <div class="card-kid">
        <div style="font-size: 2.5rem; margin-bottom: var(--space-3);">🔬</div>
        <h3 style="font-size: var(--fs-xl); margin-bottom: var(--space-2);">Belajar Melalui Pengalaman</h3>
        <p style="font-size: var(--fs-sm);">Eksperimen langsung dengan tanaman, cahaya, dan air. Pahami prinsip sebab-akibat secara visual.</p>
      </div>

      <div class="card-kid">
        <div style="font-size: 2.5rem; margin-bottom: var(--space-3);">🧩</div>
        <h3 style="font-size: var(--fs-xl); margin-bottom: var(--space-2);">Pecahkan Masalah Nyata</h3>
        <p style="font-size: var(--fs-sm);">Bantu toko kue menghitung uang belanja, bangun jembatan angka yang putus, dan susun pola warna serasi.</p>
      </div>

      <div class="card-kid">
        <div style="font-size: 2.5rem; margin-bottom: var(--space-3);">🤖</div>
        <h3 style="font-size: var(--fs-xl); margin-bottom: var(--space-2);">Belajar Bersama MIKO</h3>
        <p style="font-size: var(--fs-sm);">Sahabat AI ramah yang memberikan petunjuk bertahap (scaffolding), bukan pembocor jawaban instan.</p>
      </div>

      <div class="card-kid">
        <div style="font-size: 2.5rem; margin-bottom: var(--space-3);">🏆</div>
        <h3 style="font-size: var(--fs-xl); margin-bottom: var(--space-2);">Rayakan Setiap Kemajuan</h3>
        <p style="font-size: var(--fs-sm);">Dapatkan XP, naikkan level petualang, dan kumpulkan medali pencapaian di setiap misi yang selesai.</p>
      </div>
    </div>
  </section>

  <!-- 3 Worlds Preview -->
  <section style="padding: var(--space-8) 0 var(--space-12);">
    <div style="text-align: center; margin-bottom: var(--space-8);">
      <h2 style="font-size: var(--fs-3xl); margin-bottom: var(--space-2);">Jelajahi 3 Dunia Petualangan</h2>
      <p style="font-size: var(--fs-md);">Setiap dunia melatih cara berpikir dan keterampilan berbeda.</p>
    </div>

    <div class="worlds-grid">
      <!-- World 1 -->
      <div class="world-card theme-number">
        <div>
          <div class="world-badge-icon">🧮</div>
          <div class="badge-pill badge-pill-secondary" style="margin-bottom: var(--space-2);">Numerasi & Belanja</div>
          <h3 class="world-title">Number City</h3>
          <p class="world-subtitle">Pecahkan teka-teki kasir toko kue, pola jembatan angka, dan kristal warna di jalanan kota modern!</p>
        </div>
        <a href="?page=register" class="btn-kid btn-kid-secondary" style="width: 100%;">
          Jelajahi Number City
        </a>
      </div>

      <!-- World 2 -->
      <div class="world-card theme-discovery">
        <div>
          <div class="world-badge-icon">🌿</div>
          <div class="badge-pill badge-pill-accent" style="margin-bottom: var(--space-2);">Sains & Eksperimen</div>
          <h3 class="world-title">Discovery Lab</h3>
          <p class="world-subtitle">Selamatkan bunga matahari yang layu, mainkan teater bayangan cahaya, dan telusuri perjalanan siklus air!</p>
        </div>
        <a href="?page=register" class="btn-kid btn-kid-accent" style="width: 100%;">
          Masuk ke Discovery Lab
        </a>
      </div>

      <!-- World 3 -->
      <div class="world-card theme-thinking">
        <div>
          <div class="world-badge-icon">🤖</div>
          <div class="badge-pill badge-pill-purple" style="margin-bottom: var(--space-2);">Computational Thinking</div>
          <h3 class="world-title">Thinking Lab</h3>
          <p class="world-subtitle">Bantu Robot Botty pulang ke rumah dengan menyusun kartu instruksi langkah dan konsep perulangan pintar!</p>
        </div>
        <a href="?page=register" class="btn-kid btn-kid-purple" style="width: 100%;">
          Buka Thinking Lab
        </a>
      </div>
    </div>
  </section>

  <!-- CTA Box -->
  <section style="background: linear-gradient(135deg, var(--color-primary), #1D4ED8); border-radius: var(--radius-2xl); padding: var(--space-10) var(--space-6); text-align: center; color: #FFFFFF; margin-bottom: var(--space-12); box-shadow: var(--shadow-lg);">
    <h2 style="color: #FFFFFF; font-size: var(--fs-3xl); margin-bottom: var(--space-3);">Siap Memulai Misi Pertamamu?</h2>
    <p style="color: #DBEAFE; font-size: var(--fs-lg); max-width: 550px; margin: 0 auto var(--space-6);">
      Bergabunglah sekarang dan rasakan serunya belajar dengan cara memecahkan masalah nyata bersama MIKO.
    </p>
    <a href="?page=register" class="btn-kid btn-kid-secondary" style="padding: 1rem 2.4rem; font-size: var(--fs-lg);">
      Daftar Gratis Sekarang 🌟
    </a>
  </section>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>
