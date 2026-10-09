<?php
/**
 * MISSION KIDS — Register & 3-Step Express Onboarding
 */

declare(strict_types=1);

require __DIR__ . '/../../layouts/header.php';
?>

<div class="container" style="max-width: 540px; padding: var(--space-8) var(--space-4);">
  <div class="card-kid" style="padding: var(--space-8); text-align: center;">
    <div style="font-size: 3rem; margin-bottom: var(--space-2);">🌟</div>
    <h1 style="font-size: var(--fs-2xl); margin-bottom: var(--space-2);">Buat Akun Petualang Cilik</h1>
    <p style="font-size: var(--fs-sm); margin-bottom: var(--space-6);">
      Isi data singkat berikut untuk memulai misi pertamamu bersama MIKO!
    </p>

    <?php if (!empty($error)): ?>
      <div style="background: #FEE2E2; border: 2px solid #FCA5A5; color: #991B1B; border-radius: var(--radius-lg); padding: var(--space-3) var(--space-4); font-size: var(--fs-sm); font-weight: 700; margin-bottom: var(--space-6); text-align: left;">
        ⚠️ <?= e($error) ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="?page=register" style="text-align: left; display: flex; flex-direction: column; gap: var(--space-5);">
      <input type="hidden" name="csrf_token" value="<?= e($csrfToken) ?>">

      <!-- Step 1: Nickname & Username -->
      <div>
        <label for="nickname" style="display: block; font-family: var(--font-heading); font-size: var(--fs-sm); font-weight: 700; margin-bottom: var(--space-1);">
          1. Siapa nama panggilanmu?
        </label>
        <input type="text" id="nickname" name="nickname" required placeholder="Contoh: Rian, Maya, Budi"
               style="width: 100%; padding: 0.8rem 1rem; border: 2px solid var(--border-interactive); border-radius: var(--radius-lg); font-size: var(--fs-base); font-family: inherit; outline: none;">
      </div>

      <div>
        <label for="username" style="display: block; font-family: var(--font-heading); font-size: var(--fs-sm); font-weight: 700; margin-bottom: var(--space-1);">
          Nama Masuk Akun (Username)
        </label>
        <input type="text" id="username" name="username" required placeholder="Contoh: rian_cilik (tanpa spasi)"
               style="width: 100%; padding: 0.8rem 1rem; border: 2px solid var(--border-interactive); border-radius: var(--radius-lg); font-size: var(--fs-base); font-family: inherit; outline: none;">
        <span style="font-size: var(--fs-xs); color: var(--text-light); margin-top: 4px; display: block;">
          Gunakan huruf kecil dan angka sederhana yang mudah kamu ingat.
        </span>
      </div>

      <!-- Step 2: Avatar Selection -->
      <div>
        <label style="display: block; font-family: var(--font-heading); font-size: var(--fs-sm); font-weight: 700; margin-bottom: var(--space-2);">
          2. Pilih Karakter Avatarmu
        </label>
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: var(--space-2);">
          <label style="cursor: pointer; text-align: center;">
            <input type="radio" name="avatar_id" value="astro_cat" checked style="display: none;" class="avatar-radio">
            <div class="avatar-pick-box" style="border: 2px solid var(--color-primary); background: var(--color-primary-light); border-radius: var(--radius-lg); padding: var(--space-3); transition: all 150ms ease;">
              <div style="font-size: 2.2rem;">🐱</div>
              <div style="font-size: var(--fs-xs); font-weight: 700; margin-top: 4px;">Kucing</div>
            </div>
          </label>

          <label style="cursor: pointer; text-align: center;">
            <input type="radio" name="avatar_id" value="super_bear" style="display: none;" class="avatar-radio">
            <div class="avatar-pick-box" style="border: 2px solid var(--border-subtle); background: var(--bg-surface-elevated); border-radius: var(--radius-lg); padding: var(--space-3); transition: all 150ms ease;">
              <div style="font-size: 2.2rem;">🐻</div>
              <div style="font-size: var(--fs-xs); font-weight: 700; margin-top: 4px;">Beruang</div>
            </div>
          </label>

          <label style="cursor: pointer; text-align: center;">
            <input type="radio" name="avatar_id" value="clever_fox" style="display: none;" class="avatar-radio">
            <div class="avatar-pick-box" style="border: 2px solid var(--border-subtle); background: var(--bg-surface-elevated); border-radius: var(--radius-lg); padding: var(--space-3); transition: all 150ms ease;">
              <div style="font-size: 2.2rem;">🦊</div>
              <div style="font-size: var(--fs-xs); font-weight: 700; margin-top: 4px;">Rubah</div>
            </div>
          </label>

          <label style="cursor: pointer; text-align: center;">
            <input type="radio" name="avatar_id" value="star_owl" style="display: none;" class="avatar-radio">
            <div class="avatar-pick-box" style="border: 2px solid var(--border-subtle); background: var(--bg-surface-elevated); border-radius: var(--radius-lg); padding: var(--space-3); transition: all 150ms ease;">
              <div style="font-size: 2.2rem;">🦉</div>
              <div style="font-size: var(--fs-xs); font-weight: 700; margin-top: 4px;">Hantu</div>
            </div>
          </label>
        </div>
      </div>

      <!-- Step 3: Password -->
      <div>
        <label for="password" style="display: block; font-family: var(--font-heading); font-size: var(--fs-sm); font-weight: 700; margin-bottom: var(--space-1);">
          3. Buat Kata Sandi Rahasiamu
        </label>
        <input type="password" id="password" name="password" required placeholder="Minimal 4 karakter"
               style="width: 100%; padding: 0.8rem 1rem; border: 2px solid var(--border-interactive); border-radius: var(--radius-lg); font-size: var(--fs-base); font-family: inherit; outline: none;">
      </div>

      <button type="submit" class="btn-kid btn-kid-primary" style="width: 100%; margin-top: var(--space-2); padding: 1rem;" id="btn-submit-register">
        Mulai Petualangan Baruku! 🎉
      </button>
    </form>

    <div style="margin-top: var(--space-6); padding-top: var(--space-4); border-top: 1px solid var(--border-subtle); font-size: var(--fs-sm);">
      Sudah punya akun? <br>
      <a href="?page=login" style="color: var(--color-primary); font-weight: 700; text-decoration: underline;">
        Masuk di sini
      </a>
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
</script>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
