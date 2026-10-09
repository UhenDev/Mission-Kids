<?php
/**
 * MISSION KIDS — MIKO Floating Companion Component
 */

declare(strict_types=1);
$currentNick = Session::get('nickname', 'Sahabat Cilik');
?>
<div class="miko-dock" id="miko-dock">
  <!-- MIKO Speech Bubble -->
  <div class="miko-bubble-container" id="miko-bubble">
    <div class="miko-bubble-header">
      <div class="miko-bubble-title">
        <span>💡</span> Sahabat MIKO
      </div>
      <button class="miko-bubble-close" id="miko-bubble-close" aria-label="Tutup pesan MIKO">&times;</button>
    </div>
    <div class="miko-bubble-text" id="miko-bubble-text">
      Halo <?= e($currentNick) ?>! MIKO siap menemanimu bereksplorasi. Kalau butuh bantuan di dalam misi, klik tombol petunjuk ya!
    </div>
  </div>

  <!-- MIKO Trigger Button with Inline SVG Avatar -->
  <button class="miko-avatar-btn miko-living-avatar" id="miko-avatar-trigger" title="Bicara dengan MIKO" aria-label="Buka bantuan MIKO">
    <svg width="44" height="44" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
      <!-- Antenna -->
      <line x1="50" y1="12" x2="50" y2="28" stroke="#FFFFFF" stroke-width="6" stroke-linecap="round"/>
      <circle cx="50" cy="10" r="7" fill="#FBBF24"/>
      <!-- Head / Screen -->
      <rect x="15" y="26" width="70" height="54" rx="18" fill="#0F172A" stroke="#FFFFFF" stroke-width="4"/>
      <!-- Expressive Cyan LED Eyes -->
      <circle cx="36" cy="48" r="8" fill="#38BDF8" class="miko-eye-left"/>
      <circle cx="64" cy="48" r="8" fill="#38BDF8" class="miko-eye-right"/>
      <!-- Digital Smile -->
      <path d="M 38 64 Q 50 72 62 64" stroke="#38BDF8" stroke-width="4" stroke-linecap="round" fill="none"/>
      <!-- Ear Sensors -->
      <rect x="8" y="44" width="8" height="18" rx="4" fill="#38BDF8"/>
      <rect x="84" y="44" width="8" height="18" rx="4" fill="#38BDF8"/>
    </svg>
    <div class="miko-badge-pulse" id="miko-hint-indicator" style="display: none;"></div>
  </button>
</div>
