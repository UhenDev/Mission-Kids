<?php
/**
 * MISSION KIDS — Login Page
 * Reference-Accurate Production Implementation
 */

declare(strict_types=1);

require __DIR__ . '/../../layouts/header.php';
?>

<div class="login-page-section">
  <!-- Master Login Card (50% Visual / 50% Form) -->
  <div class="login-master-card">
    
    <!-- Left Illustration Panel -->
    <div class="login-panel-visual" aria-hidden="true">
      <div class="login-visual-overlay">
        <a href="?page=landing" class="login-visual-brand">
          <div class="login-visual-rocket">🚀</div>
          <strong class="login-visual-brand-title">MISSION KIDS</strong>
        </a>
        <div class="login-visual-tagline">
          Belajar • Bermain • Jadi Hebat
        </div>
        <h2 class="login-visual-headline">
          Petualangan Hebatmu<br>Dimulai di Sini!
        </h2>
      </div>
    </div>

    <!-- Right Login Form Panel -->
    <div class="login-panel-form">
      <div class="login-form-inner">
        <h1 class="login-title">Masuk ke Akun Anda</h1>
        <p class="login-subtitle">
          Gunakan akun yang sudah terdaftar untuk melanjutkan petualangan.
        </p>

        <?php if (!empty($error)): ?>
          <div style="background: #FEE2E2; border: 1.5px solid #FCA5A5; color: #991B1B; border-radius: 16px; padding: 12px 18px; font-size: 14px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;" role="alert">
            <span>⚠️</span>
            <span><?= e($error) ?></span>
          </div>
        <?php endif; ?>

        <form method="POST" action="?page=login" id="login-form" novalidate>
          <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">

          <!-- Nama Pengguna Field -->
          <div class="login-field-group">
            <label for="username" class="login-label">
              Nama Pengguna
            </label>
            <div class="login-input-wrapper">
              <span class="login-input-icon" aria-hidden="true">
                <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                  <circle cx="12" cy="7" r="4"/>
                </svg>
              </span>
              <input type="text"
                     id="username"
                     name="username"
                     required
                     autocomplete="username"
                     placeholder="Masukkan nama pengguna"
                     class="login-input">
            </div>
          </div>

          <!-- Kata Sandi Field -->
          <div class="login-field-group">
            <label for="password" class="login-label">
              Kata Sandi
            </label>
            <div class="login-input-wrapper">
              <span class="login-input-icon" aria-hidden="true">
                <svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                  <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
              </span>
              <input type="password"
                     id="password"
                     name="password"
                     required
                     autocomplete="current-password"
                     placeholder="Masukkan kata sandi"
                     class="login-input has-toggle">
              <button type="button"
                      class="login-toggle-pwd"
                      id="toggle-password"
                      aria-label="Tampilkan kata sandi"
                      title="Tampilkan kata sandi">
                <svg id="eye-icon" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                  <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                  <circle cx="12" cy="12" r="3"/>
                </svg>
              </button>
            </div>
          </div>

          <!-- Remember Me & Help Row -->
          <div class="login-options-row">
            <label class="login-remember-label">
              <input type="checkbox" name="remember_me" value="1" class="login-remember-checkbox">
              <span>Ingat saya</span>
            </label>
            <button type="button" class="login-help-link" id="btn-open-help">
              Bantuan?
            </button>
          </div>

          <!-- Submit Button -->
          <button type="submit" class="login-submit-btn" id="btn-submit-login">
            <span id="btn-text">Masuk ➔</span>
          </button>

          <!-- Register Link -->
          <div class="login-bottom-register">
            Belum punya akun? <a href="?page=register">Daftar sekarang</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal Bantuan Login (Pusat Bantuan Edukatif) -->
<div class="login-help-modal-overlay" id="help-modal" role="dialog" aria-modal="true" aria-labelledby="help-modal-title">
  <div class="login-help-modal-card">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px;">
      <div style="display: flex; align-items: center; gap: 10px;">
        <span style="font-size: 1.8rem;">💡</span>
        <h3 id="help-modal-title" style="font-family: var(--font-heading); font-size: 1.35rem; color: #173F86; margin: 0;">
          Bantuan Masuk Akun
        </h3>
      </div>
      <button type="button" id="btn-close-help" style="background: none; border: none; font-size: 1.4rem; cursor: pointer; color: #94A3B8; padding: 4px;" aria-label="Tutup dialog bantuan">
        ✕
      </button>
    </div>
    
    <div style="color: #475569; font-size: 14px; line-height: 1.6; margin-bottom: 24px;">
      <p style="margin-bottom: 12px;">
        Halo Sahabat Penjelajah Cilik! Berikut panduan singkat untuk masuk ke petualanganmu:
      </p>
      <ul style="padding-left: 20px; margin-bottom: 14px;">
        <li style="margin-bottom: 6px;"><strong>Nama Pengguna:</strong> Gunakan username yang kamu buat saat pertama kali mendaftar.</li>
        <li style="margin-bottom: 6px;"><strong>Kata Sandi:</strong> Masukkan kata sandi rahasiamu (minimal 4 karakter).</li>
        <li><strong>Lupa Akun?</strong> Jangan khawatir! Tanyakan kepada orang tua atau guru pembimbingmu, atau buat akun baru secara gratis.</li>
      </ul>
      <p style="margin: 0; font-size: 13px; color: #64748B;">
        Butuh bantuan MIKO langsung? Kamu bisa mengetuk ikon MIKO di sudut kanan bawah layar kapan saja!
      </p>
    </div>

    <button type="button" id="btn-confirm-help" class="login-submit-btn" style="height: 48px; font-size: 15px;">
      Mengerti, Siap Masuk!
    </button>
  </div>
</div>

<script>
(function() {
  // Password Visibility Toggle
  const pwdInput = document.getElementById('password');
  const toggleBtn = document.getElementById('toggle-password');
  const eyeIcon = document.getElementById('eye-icon');

  if (toggleBtn && pwdInput) {
    toggleBtn.addEventListener('click', function() {
      const isHidden = pwdInput.type === 'password';
      pwdInput.type = isHidden ? 'text' : 'password';
      this.setAttribute('aria-label', isHidden ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
      this.title = isHidden ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi';

      if (isHidden) {
        // Eye-off SVG
        eyeIcon.innerHTML = `
          <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
          <line x1="1" y1="1" x2="23" y2="23"/>
        `;
      } else {
        // Eye SVG
        eyeIcon.innerHTML = `
          <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
          <circle cx="12" cy="12" r="3"/>
        `;
      }
    });
  }

  // Help Modal Dialog
  const helpModal = document.getElementById('help-modal');
  const openHelpBtn = document.getElementById('btn-open-help');
  const closeHelpBtn = document.getElementById('btn-close-help');
  const confirmHelpBtn = document.getElementById('btn-confirm-help');

  function openHelp() {
    if (helpModal) {
      helpModal.classList.add('is-open');
      closeHelpBtn?.focus();
    }
  }

  function closeHelp() {
    if (helpModal) {
      helpModal.classList.remove('is-open');
      openHelpBtn?.focus();
    }
  }

  openHelpBtn?.addEventListener('click', openHelp);
  closeHelpBtn?.addEventListener('click', closeHelp);
  confirmHelpBtn?.addEventListener('click', closeHelp);

  helpModal?.addEventListener('click', function(e) {
    if (e.target === helpModal) closeHelp();
  });

  window.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && helpModal?.classList.contains('is-open')) {
      closeHelp();
    }
  });

  // Client-side validation & submit feedback
  const loginForm = document.getElementById('login-form');
  const submitBtn = document.getElementById('btn-submit-login');
  const btnText = document.getElementById('btn-text');

  if (loginForm && submitBtn) {
    loginForm.addEventListener('submit', function(e) {
      const u = document.getElementById('username')?.value.trim();
      const p = document.getElementById('password')?.value;

      if (!u || !p) {
        e.preventDefault();
        alert('Mohon isi nama pengguna dan kata sandi terlebih dahulu ya!');
        return;
      }

      // Friendly loading indicator
      submitBtn.disabled = true;
      if (btnText) {
        btnText.textContent = 'Memeriksa Akun... ⏳';
      }
    });
  }
})();
</script>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
