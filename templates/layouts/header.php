<?php
/**
 * MISSION KIDS — Master Header Layout
 */

declare(strict_types=1);

require_once __DIR__ . '/../../src/Helpers/Avatar.php';

$isLoggedIn = Session::isLoggedIn();
$currentNickname = Session::get('nickname', 'Sahabat Cilik');
$currentAvatar = Session::get('avatar_id', Avatar::DEFAULT_AVATAR);
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
  <link rel="stylesheet" href="css/design-system.css?v=4.0">
  <link rel="stylesheet" href="css/components.css?v=4.0">
  <link rel="stylesheet" href="css/animations.css?v=4.0">
  <link rel="stylesheet" href="css/missions.css?v=4.0">
  <link rel="stylesheet" href="css/worlds.css?v=4.0">

  <!-- Core Interactive Sound & Celebration Scripts -->
  <script src="js/engine/SoundEffects.js?v=3.3"></script>
  <script src="js/engine/CelebrationEffects.js?v=3.3"></script>
  <script src="js/engine/MikoCompanion.js?v=5.2"></script>
</head>
<body class="<?= $isLoggedIn ? 'has-bottom-nav' : 'landing-guest-page' ?>">

<header class="app-header">
  <div class="container header-container">
    <a href="<?= $isLoggedIn ? '?page=home' : '?page=landing' ?>" class="brand-logo" id="nav-brand-logo">
      <div class="brand-icon" style="border-radius: 50%; animation: floatRocket 4s ease-in-out infinite;">🚀</div>
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

        <?php $charData = Avatar::get($currentAvatar); ?>
        <div class="avatar-badge-btn" title="Karakter: <?= e($charData['title']) ?> (<?= e($currentNickname) ?>)">
          <div class="avatar-icon-small" style="overflow: hidden; border: 1.5px solid #93C5FD; padding: 0;">
            <img src="<?= e($charData['thumb']) ?>" alt="<?= e($charData['name']) ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: block;" onerror="this.outerHTML='<?= $charData['fallback_icon'] ?>';">
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
        <a href="?page=login" class="btn-kid btn-nav-auth-login" id="btn-nav-login">
          Masuk
        </a>
        <a href="?page=register" class="btn-kid btn-nav-auth-register" id="btn-nav-register">
          <span style="font-weight: 800; font-size: 15px; margin-right: 2px;">+</span> <span class="nav-reg-text">Daftar</span>
        </a>
      </div>
    <?php endif; ?>
  </div>
</header>

<main class="main-content">
