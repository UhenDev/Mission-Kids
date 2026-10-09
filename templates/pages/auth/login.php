<?php
/**
 * MISSION KIDS — Login Page
 */

declare(strict_types=1);

require __DIR__ . '/../../layouts/header.php';
?>

<div class="container" style="max-width: 480px; padding: var(--space-8) var(--space-4);">
  <div class="card-kid" style="padding: var(--space-8); text-align: center;">
    <div style="font-size: 3rem; margin-bottom: var(--space-2);">👋</div>
    <h1 style="font-size: var(--fs-2xl); margin-bottom: var(--space-2);">Selamat Datang Kembali!</h1>
    <p style="font-size: var(--fs-sm); margin-bottom: var(--space-6);">
      Masukkan nama pengguna dan kata sandimu untuk melanjutkan misi.
    </p>

    <?php if (!empty($error)): ?>
      <div style="background: #FEE2E2; border: 2px solid #FCA5A5; color: #991B1B; border-radius: var(--radius-lg); padding: var(--space-3) var(--space-4); font-size: var(--fs-sm); font-weight: 700; margin-bottom: var(--space-6); text-align: left;">
        ⚠️ <?= e($error) ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="?page=login" style="text-align: left; display: flex; flex-direction: column; gap: var(--space-4);">
      <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">

      <div>
        <label for="username" style="display: block; font-family: var(--font-heading); font-size: var(--fs-sm); font-weight: 700; margin-bottom: var(--space-1);">
          Nama Pengguna
        </label>
        <input type="text" id="username" name="username" required autocomplete="username"
               placeholder="Contoh: rian_juara"
               style="width: 100%; padding: 0.8rem 1rem; border: 2px solid var(--border-interactive); border-radius: var(--radius-lg); font-size: var(--fs-base); font-family: inherit; outline: none;">
      </div>

      <div>
        <label for="password" style="display: block; font-family: var(--font-heading); font-size: var(--fs-sm); font-weight: 700; margin-bottom: var(--space-1);">
          Kata Sandi
        </label>
        <input type="password" id="password" name="password" required autocomplete="current-password"
               placeholder="Masukkan kata sandi..."
               style="width: 100%; padding: 0.8rem 1rem; border: 2px solid var(--border-interactive); border-radius: var(--radius-lg); font-size: var(--fs-base); font-family: inherit; outline: none;">
      </div>

      <button type="submit" class="btn-kid btn-kid-primary" style="width: 100%; margin-top: var(--space-2);" id="btn-submit-login">
        Masuk ke Markas 🚀
      </button>
    </form>

    <div style="margin-top: var(--space-6); padding-top: var(--space-4); border-top: 1px solid var(--border-subtle); font-size: var(--fs-sm);">
      Belum punya akun petualang? <br>
      <a href="?page=register" style="color: var(--color-primary); font-weight: 700; text-decoration: underline;">
        Daftar Cepat Di Sini 🌟
      </a>
    </div>
  </div>
</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
