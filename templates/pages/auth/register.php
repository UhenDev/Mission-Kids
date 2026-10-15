<?php
/**
 * MISSION KIDS — Register & 3-Step Express Onboarding
 * Featuring Dynamic 3D Human Avatar Selection
 */

declare(strict_types=1);

require_once __DIR__ . '/../../../src/Helpers/Avatar.php';
require __DIR__ . '/../../layouts/header.php';

$avatars = Avatar::all();
$defaultAvatar = $avatars[Avatar::DEFAULT_AVATAR];
?>

<div class="container" style="max-width: 980px; padding: var(--space-4) var(--space-4);">
  <div class="auth-split-wrapper">
    <!-- Left Visual Side (Dynamic 3D Character Hero Stage) -->
    <div class="auth-visual-side auth-visual-register" id="auth-visual-panel">
      <div class="auth-visual-header">
        <div class="auth-visual-brand-row">
          <span class="auth-visual-rocket-badge" aria-hidden="true">🚀</span>
          <strong class="auth-visual-brand-name">MISSION KIDS</strong>
        </div>

        <div class="preview-podium-tag">
          <span class="preview-tag-pulse" aria-hidden="true"></span>
          <span>Karakter Pilihanmu</span>
        </div>

        <h2 class="auth-visual-char-headline" id="auth-visual-char-title">
          <?= e($defaultAvatar['title']) ?>
        </h2>

        <div class="auth-visual-char-role-badge" id="auth-visual-char-role">
          <?= e($defaultAvatar['role']) ?>
        </div>

        <p class="auth-visual-char-desc" id="auth-visual-char-desc">
          <?= e($defaultAvatar['desc']) ?>
        </p>
      </div>

      <!-- Large Character Hero Showcase with Illustrated Spotlight Podium -->
      <div class="auth-character-stage">
        <div class="auth-stage-aura" aria-hidden="true"></div>
        <img id="auth-hero-character-img"
             src="<?= e($defaultAvatar['image']) ?>"
             alt="<?= e($defaultAvatar['alt']) ?>"
             class="auth-character-img"
             width="896"
             height="1200">
        <div class="auth-stage-podium" aria-hidden="true"></div>
      </div>
    </div>

    <!-- Right Form Side -->
    <div class="auth-form-side">
      <h1 class="auth-heading-main">Buat Akun Baru</h1>
      <p class="auth-subtext-main">
        Lengkapi profil singkatmu untuk memulai petualangan seru!
      </p>

      <?php if (!empty($error)): ?>
        <div style="background: #FEE2E2; border: 2px solid #FCA5A5; color: #991B1B; border-radius: var(--radius-lg); padding: var(--space-3) var(--space-4); font-size: var(--fs-sm); font-weight: 700; margin-bottom: var(--space-4);" role="alert">
          ⚠️ <?= e($error) ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="?page=register" style="display: flex; flex-direction: column; gap: var(--space-4);" id="form-register">
        <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">

        <div>
          <label for="nickname" style="display: block; font-family: var(--font-heading); font-size: var(--fs-xs); font-weight: 700; margin-bottom: 6px; color: #334155;">
            Nama Panggilan
          </label>
          <div class="input-icon-group">
            <span class="input-icon-prefix" aria-hidden="true">✨</span>
            <input type="text" id="nickname" name="nickname" required placeholder="Masukkan nama panggilanmu"
                   class="input-with-icon" autocomplete="name">
          </div>
        </div>

        <div>
          <label for="username" style="display: block; font-family: var(--font-heading); font-size: var(--fs-xs); font-weight: 700; margin-bottom: 6px; color: #334155;">
            Nama Pengguna (Username)
          </label>
          <div class="input-icon-group">
            <span class="input-icon-prefix" aria-hidden="true">👤</span>
            <input type="text" id="username" name="username" required placeholder="Pilih nama pengguna (huruf & angka)"
                   class="input-with-icon" autocomplete="username">
          </div>
        </div>

        <div>
          <label for="password" style="display: block; font-family: var(--font-heading); font-size: var(--fs-xs); font-weight: 700; margin-bottom: 6px; color: #334155;">
            Kata Sandi
          </label>
          <div class="password-input-wrapper input-icon-group">
            <span class="input-icon-prefix" aria-hidden="true">🔒</span>
            <input type="password" id="password" name="password" required placeholder="Minimal 4 karakter"
                   class="input-with-icon"
                   autocomplete="new-password"
                   style="padding-right: 3.2rem !important;">
            <button type="button" class="btn-toggle-password" id="toggle-password" aria-label="Tampilkan kata sandi" title="Tampilkan kata sandi">
              👁️
            </button>
          </div>
        </div>

        <!-- 8 Dynamic 3D Human Avatars Selection as Large Portrait Cards -->
        <div>
          <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 8px;">
            <label style="font-family: var(--font-heading); font-size: var(--fs-xs); font-weight: 700; color: #334155; margin: 0;" id="avatar-section-label">
              Pilih Avatar Karakter
            </label>
            <span style="font-size: 11px; font-weight: 700; color: #2563EB; background: #EFF6FF; padding: 2px 8px; border-radius: 9999px;">
              Ketuk untuk memilih
            </span>
          </div>

          <div class="avatar-grid-8" role="radiogroup" aria-labelledby="avatar-section-label">
            <?php 
              $idx = 0;
              foreach ($avatars as $avId => $av):
                $isDefault = ($avId === Avatar::DEFAULT_AVATAR);
                $idx++;
            ?>
              <label class="avatar-option-label" for="avatar-<?= e($av['id']) ?>">
                <input type="radio"
                       id="avatar-<?= e($av['id']) ?>"
                       name="avatar_id"
                       value="<?= e($av['id']) ?>"
                       <?= $isDefault ? 'checked' : '' ?>
                       class="avatar-radio"
                       data-title="<?= e($av['title']) ?>"
                       data-desc="<?= e($av['desc']) ?>"
                       data-role="<?= e($av['role']) ?>"
                       data-image="<?= e($av['image']) ?>"
                       data-alt="<?= e($av['alt']) ?>"
                       aria-label="<?= e($av['title']) ?>"
                       aria-checked="<?= $isDefault ? 'true' : 'false' ?>">
                <div class="avatar-pick-box <?= $isDefault ? 'is-selected' : '' ?>">
                  <span class="avatar-pick-badge" aria-hidden="true">✓</span>
                  <div class="avatar-pick-thumb-wrapper">
                    <img src="<?= e($av['thumb']) ?>" 
                         alt="<?= e($av['name']) ?>" 
                         class="avatar-pick-thumb" 
                         width="82" 
                         height="82" 
                         loading="eager">
                  </div>
                  <div class="avatar-pick-info">
                    <div class="avatar-pick-name"><?= e($av['name']) ?></div>
                    <div class="avatar-pick-role"><?= e($av['role']) ?></div>
                  </div>
                </div>
              </label>
            <?php endforeach; ?>
          </div>
        </div>

        <button type="submit" class="btn-kid btn-kid-primary" style="width: 100%; border-radius: var(--radius-pill); padding: 0.95rem; font-size: 1.05rem; margin-top: var(--space-2);" id="btn-submit-register">
          Daftar Sekarang ➔
        </button>
      </form>

      <div style="margin-top: var(--space-4); text-align: center; font-size: var(--fs-xs); color: #64748B;">
        Sudah punya akun? 
        <a href="?page=login" style="color: var(--color-primary); font-weight: 700; text-decoration: none;">
          Masuk di sini
        </a>
      </div>
    </div>
  </div>
</div>

<script>
(function() {
  // Elements
  const heroImg = document.getElementById('auth-hero-character-img');
  const titleElem = document.getElementById('auth-visual-char-title');
  const roleElem = document.getElementById('auth-visual-char-role');
  const descElem = document.getElementById('auth-visual-char-desc');
  const radios = document.querySelectorAll('.avatar-radio');

  // Preload all 8 full-body character images into browser memory cache for zero latency
  const preloadedImages = {};
  radios.forEach(radio => {
    const imgSrc = radio.dataset.image;
    if (imgSrc) {
      const img = new Image();
      img.src = imgSrc;
      preloadedImages[radio.value] = img;
    }
  });

  // Dynamic Avatar Selection Handler
  function selectAvatar(radio) {
    if (!radio) return;

    // 1. Update selection highlight on all boxes
    document.querySelectorAll('.avatar-pick-box').forEach(box => {
      box.classList.remove('is-selected');
    });
    radios.forEach(r => {
      r.setAttribute('aria-checked', r === radio ? 'true' : 'false');
    });

    const activeBox = radio.closest('label')?.querySelector('.avatar-pick-box');
    if (activeBox) {
      activeBox.classList.add('is-selected');
    }

    // 2. Extract character data attributes
    const nextSrc = radio.dataset.image;
    const nextAlt = radio.dataset.alt || radio.dataset.title;
    const nextTitle = radio.dataset.title;
    const nextRole = radio.dataset.role;
    const nextDesc = radio.dataset.desc;

    // 3. Smooth transition on the left visual panel
    if (heroImg && nextSrc) {
      heroImg.classList.add('switching');
      setTimeout(() => {
        heroImg.src = nextSrc;
        heroImg.alt = nextAlt;
        heroImg.classList.remove('switching');
      }, 70);
    }

    if (titleElem && nextTitle) {
      titleElem.textContent = nextTitle;
    }

    if (roleElem && nextRole) {
      roleElem.textContent = nextRole;
    }

    if (descElem && nextDesc) {
      descElem.textContent = nextDesc;
    }
  }

  // Bind change & click events
  radios.forEach(radio => {
    radio.addEventListener('change', () => selectAvatar(radio));
    radio.addEventListener('click', () => selectAvatar(radio));
  });

  // Password visibility toggle
  document.getElementById('toggle-password')?.addEventListener('click', function() {
    const pwd = document.getElementById('password');
    if (!pwd) return;
    const isHidden = pwd.type === 'password';
    pwd.type = isHidden ? 'text' : 'password';
    this.textContent = isHidden ? '🙈' : '👁️';
    this.setAttribute('aria-label', isHidden ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
    this.title = isHidden ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi';
  });
})();
</script>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
