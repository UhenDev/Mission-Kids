<?php
/**
 * MISSION KIDS — Login Page
 */

declare(strict_types=1);

require __DIR__ . '/../../layouts/header.php';
?>

<div class="container" style="max-width: 920px; padding: var(--space-4) var(--space-4);">
  <div class="auth-split-wrapper">
    <!-- Left Visual Side -->
    <div class="auth-visual-side">
      <div style="display: flex; align-items: center; gap: 8px; margin-bottom: var(--space-3);">
        <span style="font-size: 1.6rem;">🚀</span>
        <strong style="font-family: var(--font-heading); color: #1D4ED8; font-size: 1.15rem;">MISSION KIDS</strong>
      </div>
      <div style="font-size: var(--fs-xs); color: #475569; font-weight: 700; margin-bottom: var(--space-3);">
        Belajar • Bermain • Jadi Hebat
      </div>
      <img src="assets/images/auth-banner.jpg" alt="Petualang Cilik & Sahabat MIKO" class="auth-visual-img">
    </div>

    <!-- Right Form Side -->
    <div class="auth-form-side">
      <h1 class="auth-heading-main">Masuk ke Akun Anda</h1>
      <p class="auth-subtext-main">
        Gunakan akun yang sudah terdaftar untuk melanjutkan petualangan.
      </p>

      <?php if (!empty($error)): ?>
        <div style="background: #FEE2E2; border: 2px solid #FCA5A5; color: #991B1B; border-radius: var(--radius-lg); padding: var(--space-3) var(--space-4); font-size: var(--fs-sm); font-weight: 700; margin-bottom: var(--space-4);">
          ⚠️ <?= e($error) ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="?page=login" style="display: flex; flex-direction: column; gap: var(--space-4);">
        <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">

        <div>
          <label for="username" style="display: block; font-family: var(--font-heading); font-size: var(--fs-xs); font-weight: 700; margin-bottom: 6px; color: #334155;">
            Nama Pengguna
          </label>
          <div class="input-icon-group">
            <span class="input-icon-prefix">👤</span>
            <input type="text" id="username" name="username" required autocomplete="username"
                   placeholder="Masukkan nama pengguna"
                   class="input-with-icon">
          </div>
        </div>

        <div>
          <label for="password" style="display: block; font-family: var(--font-heading); font-size: var(--fs-xs); font-weight: 700; margin-bottom: 6px; color: #334155;">
            Kata Sandi
          </label>
          <div class="password-input-wrapper input-icon-group">
            <span class="input-icon-prefix">🔒</span>
            <input type="password" id="password" name="password" required autocomplete="current-password"
                   placeholder="Masukkan kata sandi"
                   class="input-with-icon"
                   style="padding-right: 3.2rem !important;">
            <button type="button" class="btn-toggle-password" id="toggle-password" aria-label="Tampilkan kata sandi" title="Tampilkan kata sandi">
              👁️
            </button>
          </div>
        </div>

        <div style="display: flex; align-items: center; justify-content: space-between; font-size: var(--fs-xs); color: var(--text-muted); margin-top: -4px;">
          <label style="display: flex; align-items: center; gap: 6px; cursor: pointer; user-select: none;">
            <input type="checkbox" name="remember_me" value="1" style="accent-color: var(--color-primary); width: 16px; height: 16px;">
            <span>Ingat saya</span>
          </label>
          <a href="?page=register" style="color: var(--color-primary); font-weight: 700; text-decoration: none;">
            Bantuan?
          </a>
        </div>

        <button type="submit" class="btn-kid btn-kid-primary" style="width: 100%; border-radius: var(--radius-pill); padding: 0.9rem; font-size: 1.05rem; margin-top: var(--space-2);" id="btn-submit-login">
          Masuk ➔
        </button>
      </form>

      <div style="margin-top: var(--space-6); text-align: center; font-size: var(--fs-xs); color: #64748B;">
        Belum punya akun? 
        <a href="?page=register" style="color: var(--color-primary); font-weight: 700; text-decoration: none;">
          Daftar sekarang
        </a>
      </div>
    </div>
  </div>
</div>

<script>
document.getElementById('toggle-password')?.addEventListener('click', function() {
  const pwd = document.getElementById('password');
  if (!pwd) return;
  const isHidden = pwd.type === 'password';
  pwd.type = isHidden ? 'text' : 'password';
  this.textContent = isHidden ? '🙈' : '👁️';
  this.setAttribute('aria-label', isHidden ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
  this.title = isHidden ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi';
});
</script>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
