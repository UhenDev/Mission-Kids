<?php
/**
 * MISSION KIDS — Master Header Layout
 */

declare(strict_types=1);

$isLoggedIn = Session::isLoggedIn();
$currentNickname = Session::get('nickname', 'Sahabat Cilik');
$currentAvatar = Session::get('avatar_id', 'astro_cat');
$currentPage = $_GET['page'] ?? ($isLoggedIn ? 'home' : 'landing');
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($pageTitle ?? 'MISSION KIDS — Petualangan Misimu Dimulai di Sini.') ?></title>
  <meta name="description" content="Platform edukasi interaktif berbasis misi untuk anak Sekolah Dasar (SD). Belajar, bereksplorasi, dan memecahkan tantangan seru bersama MIKO.">
  
  <!-- Design System CSS dengan Cache Busting -->
  <link rel="stylesheet" href="css/design-system.css?v=3.0">
  <link rel="stylesheet" href="css/components.css?v=3.0">
  <link rel="stylesheet" href="css/animations.css?v=3.0">
  <link rel="stylesheet" href="css/missions.css?v=3.0">
  <link rel="stylesheet" href="css/worlds.css?v=3.0">

  <!-- Core Interactive Sound & Celebration Scripts -->
  <script src="js/engine/SoundEffects.js?v=3.2"></script>
  <script src="js/engine/CelebrationEffects.js?v=3.2"></script>
  <script src="js/engine/MikoCompanion.js?v=3.2"></script>
</head>
<body>

<header class="app-header">
  <div class="container header-container">
    <a href="<?= $isLoggedIn ? '?page=home' : '?page=landing' ?>" class="brand-logo" id="nav-brand-logo">
      <div class="brand-icon" style="animation: floatRocket 4s ease-in-out infinite;">🚀</div>
      <span>MISSION KIDS</span>
    </a>

    <?php if ($isLoggedIn): ?>
      <nav aria-label="Navigasi Utama Siswa" class="header-desktop-nav">
        <ul class="nav-links">
          <li>
            <a href="?page=home" class="nav-link <?= $currentPage === 'home' ? 'active' : '' ?>" id="nav-home">
              Beranda
            </a>
          </li>
          <li>
            <a href="?page=worlds" class="nav-link <?= in_array($currentPage, ['worlds', 'mission']) ? 'active' : '' ?>" id="nav-worlds">
              Dunia
            </a>
          </li>
          <li>
            <a href="?page=achievements" class="nav-link <?= $currentPage === 'achievements' ? 'active' : '' ?>" id="nav-achievements">
              Pencapaian
            </a>
          </li>
          <li>
            <a href="?page=progress" class="nav-link <?= $currentPage === 'progress' ? 'active' : '' ?>" id="nav-progress">
              Profil
            </a>
          </li>
        </ul>
      </nav>

      <div class="header-user-status">
        <button type="button" class="sound-toggle-btn" onclick="window.SoundFX.toggleMute()" title="Atur Suara Ceria" id="btn-sound-toggle-auth">
          🔊
        </button>

        <?php if (isset($levelInfo)): ?>
          <div class="badge-pill badge-pill-secondary" style="font-size: 11px; padding: 4px 10px;" title="Total XP Belajar">
            <span>⭐</span>
            <span id="nav-total-xp"><?= (int)$levelInfo['total_xp'] ?></span> XP
          </div>
          <div class="badge-pill badge-pill-primary" style="font-size: 11px; padding: 4px 10px;">
            Level <?= (int)$levelInfo['level'] ?>
          </div>
        <?php endif; ?>

        <div class="avatar-badge-btn" title="Profil Kamu: <?= e($currentNickname) ?>">
          <div class="avatar-icon-small">
            <?= match ($currentAvatar) {
                'astro_cat' => '🐱',
                'super_bear' => '🐻',
                'clever_fox' => '🦊',
                'star_owl' => '🦉',
                'rocket_boy' => '👦',
                'wonder_girl' => '👧',
                'botty_bot' => '🤖',
                'happy_dino' => '🦕',
                default => '🚀'
            } ?>
          </div>
          <span class="student-nickname-nav">Halo, <?= e($currentNickname) ?>! ⌄</span>
        </div>

        <a href="?page=logout" class="btn-kid btn-kid-ghost" style="padding: 0.35rem 0.75rem; font-size: var(--fs-xs); min-height: 34px; border-radius: var(--radius-pill);" title="Keluar dari akun">
          Keluar
        </a>
      </div>
    <?php else: ?>
      <nav aria-label="Navigasi Menu Utama" class="header-desktop-nav">
        <ul class="nav-links">
          <li>
            <a href="?page=landing" class="nav-link <?= $currentPage === 'landing' ? 'active' : '' ?>">
              Beranda
            </a>
          </li>
          <li>
            <a href="#fitur" class="nav-link">
              Fitur
            </a>
          </li>
          <li>
            <a href="#dunia" class="nav-link">
              Dunia
            </a>
          </li>
          <li>
            <a href="#tentang" class="nav-link">
              Tentang
            </a>
          </li>
        </ul>
      </nav>

      <div class="header-guest-actions">
        <button type="button" class="sound-toggle-btn" onclick="window.SoundFX.toggleMute()" title="Atur Suara Ceria" id="btn-sound-toggle-guest">
          🔊
        </button>
        <a href="?page=login" class="btn-kid btn-kid-ghost btn-nav-auth" id="btn-nav-login" style="border-radius: var(--radius-pill); padding: 0.45rem 1.2rem;">
          Login
        </a>
        <a href="?page=register" class="btn-kid btn-kid-primary btn-nav-auth shine-effect" id="btn-nav-register" style="border-radius: var(--radius-pill); padding: 0.45rem 1.4rem;">
          Daftar
        </a>
      </div>
    <?php endif; ?>
  </div>
</header>

<main class="main-content">
