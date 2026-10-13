<?php
/**
 * MISSION KIDS — Master Footer Layout
 */

declare(strict_types=1);
?>
</main>

<footer class="app-main-footer">
  <div class="container footer-content-row">
    <!-- Left: Brand & Tagline -->
    <div class="footer-brand-side">
      <a href="?page=landing" class="footer-brand-logo">
        <div class="brand-icon footer-brand-icon">🚀</div>
        <strong class="footer-brand-title">MISSION KIDS</strong>
      </a>
      <span class="footer-tagline-text">
        Belajar • Bermain • Jadi Hebat
      </span>
    </div>

    <!-- Center: Quick Nav Links -->
    <div class="footer-nav-links">
      <a href="?page=landing" class="footer-nav-link">Beranda</a>
      <a href="#fitur" class="footer-nav-link">Fitur</a>
      <a href="#dunia" class="footer-nav-link">Dunia</a>
      <a href="#tentang" class="footer-nav-link">Tentang</a>
    </div>

    <!-- Right: Social & Copyright -->
    <div class="footer-meta-side">
      <div class="footer-social-group">
        <a href="javascript:void(0)" title="YouTube Channel" class="footer-social-btn">▶</a>
        <a href="javascript:void(0)" title="Instagram" class="footer-social-btn">📷</a>
        <a href="javascript:void(0)" title="Website Komunitas" class="footer-social-btn">🔗</a>
      </div>
      <span class="footer-copyright-text">&copy; 2026 MISSION KIDS. All rights reserved.</span>
    </div>
  </div>
</footer>

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
<script src="js/app.js?v=3.3"></script>

</body>
</html>
