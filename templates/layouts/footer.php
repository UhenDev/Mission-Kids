<?php
/**
 * MISSION KIDS — Master Footer Layout
 */

declare(strict_types=1);
?>
</main>

<footer class="app-main-footer" style="background: #FFFFFF; border-top: 1.5px solid #E2E8F0; padding: 2rem 0; margin-top: auto;">
  <div class="container footer-content-row" style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1.5rem;">
    <!-- Left: Brand & Tagline -->
    <div style="display: flex; align-items: center; gap: 12px;">
      <a href="?page=landing" style="display: flex; align-items: center; gap: 8px; text-decoration: none;">
        <span style="font-size: 1.6rem; animation: floatRocket 4s ease-in-out infinite;">🚀</span>
        <strong style="font-family: var(--font-heading); font-size: 1.2rem; color: #1E3A8A; letter-spacing: -0.01em;">MISSION KIDS</strong>
      </a>
      <span style="font-size: 0.8rem; color: #64748B; font-weight: 600; border-left: 2px solid #E2E8F0; padding-left: 12px;">
        Belajar • Bermain • Jadi Hebat
      </span>
    </div>

    <!-- Center: Quick Nav Links -->
    <div style="display: flex; align-items: center; gap: 1.5rem; font-size: 0.875rem; font-weight: 700;">
      <a href="?page=landing" style="color: #475569; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#2563EB'" onmouseout="this.style.color='#475569'">Beranda</a>
      <a href="#fitur" style="color: #475569; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#2563EB'" onmouseout="this.style.color='#475569'">Fitur</a>
      <a href="#dunia" style="color: #475569; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#2563EB'" onmouseout="this.style.color='#475569'">Dunia</a>
      <a href="#tentang" style="color: #475569; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#2563EB'" onmouseout="this.style.color='#475569'">Tentang</a>
    </div>

    <!-- Right: Social & Copyright -->
    <div style="display: flex; align-items: center; gap: 1rem; font-size: 0.8rem; color: #64748B;">
      <div style="display: flex; gap: 8px;">
        <a href="javascript:void(0)" title="YouTube Channel" style="width: 30px; height: 30px; border-radius: 50%; background: #EFF6FF; color: #2563EB; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 13px; font-weight: 800;">▶</a>
        <a href="javascript:void(0)" title="Instagram" style="width: 30px; height: 30px; border-radius: 50%; background: #EFF6FF; color: #2563EB; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 13px; font-weight: 800;">📷</a>
        <a href="javascript:void(0)" title="Website Komunitas" style="width: 30px; height: 30px; border-radius: 50%; background: #EFF6FF; color: #2563EB; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 13px; font-weight: 800;">🔗</a>
      </div>
      <span>&copy; 2026 MISSION KIDS. All rights reserved.</span>
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
