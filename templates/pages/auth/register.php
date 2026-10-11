<?php
/**
 * MISSION KIDS — Register & 3-Step Express Onboarding
 */

declare(strict_types=1);

require __DIR__ . '/../../layouts/header.php';
?>

<div class="container" style="max-width: 950px; padding: var(--space-4) var(--space-4);">
  <div class="auth-split-wrapper">
    <!-- Left Visual Side -->
    <div class="auth-visual-side">
      <div>
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: var(--space-2);">
          <span style="font-size: 1.6rem;">🚀</span>
          <strong style="font-family: var(--font-heading); color: #1D4ED8; font-size: 1.15rem;">MISSION KIDS</strong>
        </div>
        <h2 style="font-family: var(--font-heading); font-size: 1.5rem; color: #1E3A8A; margin-bottom: 4px;">
          Buat Akun Baru
        </h2>
        <p style="font-size: var(--fs-xs); color: #475569; font-weight: 600; margin-bottom: var(--space-4);">
          Bergabunglah dengan ribuan penemu cilik di seluruh Indonesia!
        </p>
      </div>
      <img src="assets/images/auth-banner.jpg" alt="Petualang Cilik & Sahabat MIKO" class="auth-visual-img">
    </div>

    <!-- Right Form Side -->
    <div class="auth-form-side">
      <h1 class="auth-heading-main">Buat Akun Baru</h1>
      <p class="auth-subtext-main">
        Lengkapi profil singkatmu untuk memulai petualangan seru!
      </p>

      <?php if (!empty($error)): ?>
        <div style="background: #FEE2E2; border: 2px solid #FCA5A5; color: #991B1B; border-radius: var(--radius-lg); padding: var(--space-3) var(--space-4); font-size: var(--fs-sm); font-weight: 700; margin-bottom: var(--space-4);">
          ⚠️ <?= e($error) ?>
        </div>
      <?php endif; ?>

      <form method="POST" action="?page=register" style="display: flex; flex-direction: column; gap: var(--space-4);">
        <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">

        <div>
          <label for="nickname" style="display: block; font-family: var(--font-heading); font-size: var(--fs-xs); font-weight: 700; margin-bottom: 6px; color: #334155;">
            Nama Panggilan
          </label>
          <div class="input-icon-group">
            <span class="input-icon-prefix">✨</span>
            <input type="text" id="nickname" name="nickname" required placeholder="Masukkan nama panggilanmu"
                   class="input-with-icon">
          </div>
        </div>

        <div>
          <label for="username" style="display: block; font-family: var(--font-heading); font-size: var(--fs-xs); font-weight: 700; margin-bottom: 6px; color: #334155;">
            Nama Pengguna (Username)
          </label>
          <div class="input-icon-group">
            <span class="input-icon-prefix">👤</span>
            <input type="text" id="username" name="username" required placeholder="Pilih nama pengguna (huruf & angka)"
                   class="input-with-icon">
          </div>
        </div>

        <div>
          <label for="password" style="display: block; font-family: var(--font-heading); font-size: var(--fs-xs); font-weight: 700; margin-bottom: 6px; color: #334155;">
            Kata Sandi
          </label>
          <div class="password-input-wrapper input-icon-group">
            <span class="input-icon-prefix">🔒</span>
            <input type="password" id="password" name="password" required placeholder="Minimal 4 karakter"
                   class="input-with-icon"
                   style="padding-right: 3.2rem !important;">
            <button type="button" class="btn-toggle-password" id="toggle-password" aria-label="Tampilkan kata sandi" title="Tampilkan kata sandi">
              👁️
            </button>
          </div>
        </div>

        <div>
          <label style="display: block; font-family: var(--font-heading); font-size: var(--fs-xs); font-weight: 700; margin-bottom: 8px; color: #334155;">
            Pilih Avatar Karakter
          </label>
          <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 8px;">
            <?php 
              $avatars = [
                ['id' => 'astro_cat', 'icon' => '🐱', 'name' => 'Kucing'],
                ['id' => 'super_bear', 'icon' => '🐻', 'name' => 'Beruang'],
                ['id' => 'clever_fox', 'icon' => '🦊', 'name' => 'Rubah'],
                ['id' => 'star_owl', 'icon' => '🦉', 'name' => 'Hantu'],
                ['id' => 'rocket_boy', 'icon' => '👦', 'name' => 'Astro'],
                ['id' => 'wonder_girl', 'icon' => '👧', 'name' => 'Maya'],
                ['id' => 'botty_bot', 'icon' => '🤖', 'name' => 'Botty'],
                ['id' => 'happy_dino', 'icon' => '🦕', 'name' => 'Dino'],
              ];
              foreach ($avatars as $idx => $av):
            ?>
              <label style="cursor: pointer; text-align: center;">
                <input type="radio" name="avatar_id" value="<?= $av['id'] ?>" <?= $idx === 0 ? 'checked' : '' ?> style="display: none;" class="avatar-radio">
                <div class="avatar-pick-box" style="border: 2px solid <?= $idx === 0 ? 'var(--color-primary)' : 'var(--border-subtle)' ?>; background: <?= $idx === 0 ? 'var(--color-primary-light)' : 'var(--bg-surface-elevated)' ?>; border-radius: var(--radius-lg); padding: 8px 4px; transition: all 150ms ease;">
                  <div style="font-size: 1.6rem;"><?= $av['icon'] ?></div>
                  <div style="font-size: 10px; font-weight: 700; margin-top: 2px;"><?= $av['name'] ?></div>
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
// Simple avatar selection highlight
document.querySelectorAll('.avatar-radio').forEach(radio => {
  radio.addEventListener('change', () => {
    document.querySelectorAll('.avatar-pick-box').forEach(box => {
      box.style.borderColor = 'var(--border-subtle)';
      box.style.background = 'var(--bg-surface-elevated)';
    });
    const selectedBox = radio.closest('label').querySelector('.avatar-pick-box');
    selectedBox.style.borderColor = 'var(--color-primary)';
    selectedBox.style.background = 'var(--color-primary-light)';
  });
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
</script>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
