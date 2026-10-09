<?php
/**
 * MISSION KIDS — Master Footer Layout
 */

declare(strict_types=1);
?>
</main>

<footer style="background: #FFFFFF; border-top: 2px solid var(--border-subtle); padding: var(--space-8) 0; margin-top: auto;">
  <div class="container" style="display: flex; flex-direction: column; align-items: center; justify-content: center; gap: var(--space-3); text-align: center;">
    <div style="display: flex; align-items: center; gap: var(--space-2); font-family: var(--font-heading); font-size: var(--fs-lg); color: var(--color-primary);">
      <span>🚀</span> <strong>MISSION KIDS</strong>
    </div>
    <p style="font-size: var(--fs-sm); max-width: 500px; color: var(--text-muted);">
      Platform pembelajaran interaktif berbasis misi untuk anak Sekolah Dasar. Belajar, menjelajah, dan menyelesaikan masalah nyata bersama sahabat AI MIKO.
    </p>
    <div style="display: flex; gap: var(--space-4); font-size: var(--fs-xs); color: var(--text-light); margin-top: var(--space-2);">
      <span>🛡️ 100% Ramah Anak</span>
      <span>🔒 Tanpa Iklan & Pelacak Pribadi</span>
      <span>💡 Didukung Pendamping Edukasi MIKO</span>
    </div>
  </div>
</footer>

<?php if (Session::isLoggedIn()): ?>
  <!-- Mobile Thumb-Friendly Bottom Navigation -->
  <nav class="mobile-bottom-nav" aria-label="Navigasi Cepat Ponsel">
    <a href="?page=home" class="mobile-nav-item <?= $currentPage === 'home' ? 'active' : '' ?>">
      <span class="mobile-nav-icon">🏠</span>
      <span class="mobile-nav-label">Markas</span>
    </a>
    <a href="?page=worlds" class="mobile-nav-item <?= in_array($currentPage, ['worlds', 'mission']) ? 'active' : '' ?>">
      <span class="mobile-nav-icon">🗺️</span>
      <span class="mobile-nav-label">Misi</span>
    </a>
    <a href="?page=achievements" class="mobile-nav-item <?= $currentPage === 'achievements' ? 'active' : '' ?>">
      <span class="mobile-nav-icon">🏅</span>
      <span class="mobile-nav-label">Medali</span>
    </a>
    <a href="?page=progress" class="mobile-nav-item <?= $currentPage === 'progress' ? 'active' : '' ?>">
      <span class="mobile-nav-icon">📊</span>
      <span class="mobile-nav-label">Jejak</span>
    </a>
  </nav>

  <?php require __DIR__ . '/../components/miko_bubble.php'; ?>
<?php endif; ?>

<!-- App Script -->
<script src="js/app.js"></script>

</body>
</html>
