<?php
/**
 * MISSION KIDS — Master Footer Layout
 */

declare(strict_types=1);
?>
</main>

<?php $isAuthPage = in_array($currentPage ?? '', ['login', 'register'], true); ?>

<?php if ($isAuthPage): ?>
  <!-- Dedicated Clean Minimalist Auth Footer for Login & Register -->
  <footer class="app-auth-footer" role="contentinfo" aria-label="Footer Autentikasi">
    <div class="container auth-footer-row">
      <div class="auth-footer-brand">
        <a href="?page=landing" class="auth-footer-logo" title="Kembali ke Beranda MISSION KIDS">
          <span class="auth-footer-rocket" aria-hidden="true">🚀</span>
          <strong class="auth-footer-name">MISSION KIDS</strong>
        </a>
        <span class="auth-footer-tagline">Belajar • Bermain • Jadi Hebat</span>
      </div>

      <div class="auth-footer-credit-col">
        <p class="footer-credit-text">Website ini dibuat oleh Hendrik Wildansyah.</p>
      </div>

      <div class="auth-footer-meta">
        <span class="auth-footer-copy">&copy; <?= date('Y') ?> MISSION KIDS. All rights reserved.</span>
      </div>
    </div>
  </footer>
<?php else: ?>
  <!-- Master Public & Student Footer Layout -->
  <footer class="app-main-footer" role="contentinfo" aria-label="Footer Utama">
    <div class="container footer-content-row">
      <!-- Left: Brand & Tagline -->
      <div class="footer-brand-side">
        <a href="?page=landing" class="footer-brand-logo" title="Beranda MISSION KIDS">
          <div class="brand-icon footer-brand-icon">🚀</div>
          <strong class="footer-brand-title">MISSION KIDS</strong>
        </a>
        <span class="footer-tagline-text">
          Belajar • Bermain • Jadi Hebat
        </span>
      </div>

      <!-- Center: Quick Nav Links -->
      <nav class="footer-nav-links" aria-label="Navigasi Cepat Footer">
        <a href="?page=landing" class="footer-nav-link">Beranda</a>
        <a href="#fitur" class="footer-nav-link">Fitur</a>
        <a href="#dunia" class="footer-nav-link">Dunia</a>
        <a href="#tentang" class="footer-nav-link">Tentang</a>
      </nav>

      <!-- Right: Social, Creator Credit & Copyright -->
      <div class="footer-meta-side">
        <p class="footer-credit-text">Website ini dibuat oleh Hendrik Wildansyah.</p>
        <div class="footer-social-group">
          <a href="javascript:void(0)" title="YouTube Channel" class="footer-social-btn" aria-label="YouTube Channel">▶</a>
          <a href="javascript:void(0)" title="Email & Pesan" class="footer-social-btn" aria-label="Kirim Pesan">✉</a>
          <a href="javascript:void(0)" title="Website Komunitas" class="footer-social-btn" aria-label="Tautan Komunitas">🔗</a>
        </div>
        <span class="footer-copyright-text">&copy; <?= date('Y') ?> MISSION KIDS. All rights reserved.</span>
      </div>
    </div>
  </footer>
<?php endif; ?>

<?php if (Session::isLoggedIn()): ?>
  <!-- Mobile Thumb-Friendly Bottom Navigation -->
  <nav class="mobile-bottom-nav" aria-label="Navigasi Cepat Ponsel">
    <a href="?page=home" class="mobile-nav-item <?= $currentPage === 'home' ? 'active' : '' ?>">
      <span class="mobile-nav-icon">🏠</span>
      <span class="mobile-nav-label">Beranda</span>
    </a>
    <a href="?page=worlds" class="mobile-nav-item <?= in_array($currentPage, ['worlds', 'mission']) ? 'active' : '' ?>">
      <span class="mobile-nav-icon">🗺️</span>
      <span class="mobile-nav-label">Dunia</span>
    </a>
    <a href="?page=achievements" class="mobile-nav-item <?= $currentPage === 'achievements' ? 'active' : '' ?>">
      <span class="mobile-nav-icon">🏅</span>
      <span class="mobile-nav-label">Pencapaian</span>
    </a>
    <a href="?page=progress" class="mobile-nav-item <?= $currentPage === 'progress' ? 'active' : '' ?>">
      <span class="mobile-nav-icon">👤</span>
      <span class="mobile-nav-label">Profil</span>
    </a>
  </nav>
<?php endif; ?>

<!-- MIKO Floating Companion (Tersedia di setiap halaman) -->
<?php require __DIR__ . '/../components/miko_bubble.php'; ?>

<!-- App Script -->
<script src="js/app.js?v=5.1"></script>

</body>
</html>
