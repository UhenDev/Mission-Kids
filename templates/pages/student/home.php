<?php
/**
 * MISSION KIDS — Student Home (Markas Petualang)
 */

declare(strict_types=1);

require __DIR__ . '/../../layouts/header.php';
?>

<div class="container">
  <!-- Top Greeting & Progress Hero -->
  <section class="card-kid" style="background: linear-gradient(135deg, #EFF6FF 0%, #FFFFFF 100%); border-color: #BFDBFE; padding: var(--space-8); margin-bottom: var(--space-8);">
    <div style="display: flex; align-items: center; justify-content: space-between; gap: var(--space-6); flex-wrap: wrap;">
      <div style="display: flex; align-items: center; gap: var(--space-4);">
        <div style="width: 76px; height: 76px; border-radius: 50%; background: #DBEAFE; display: flex; align-items: center; justify-content: center; font-size: 2.8rem; border: 3px solid #93C5FD; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.15);">
          <?= match ($profile['avatar_id'] ?? 'astro_cat') {
              'astro_cat' => '🐱',
              'super_bear' => '🐻',
              'clever_fox' => '🦊',
              'star_owl' => '🦉',
              default => '🚀'
          } ?>
        </div>
        <div>
          <div class="badge-pill badge-pill-primary" style="margin-bottom: var(--space-1);">
            <?= e($levelInfo['badge']) ?> Level <?= (int)$levelInfo['level'] ?> — <?= e($levelInfo['name']) ?>
          </div>
          <h1 style="font-size: var(--fs-2xl); margin-bottom: var(--space-1);">
            Halo, <?= e($profile['nickname']) ?>! 👋
          </h1>
          <p style="font-size: var(--fs-sm);">
            MIKO siap menemanimu. Siap memecahkan misi petualangan hari ini?
          </p>
        </div>
      </div>

      <!-- XP Level Progress Box -->
      <div style="min-width: 260px; flex: 1; max-width: 380px;">
        <div class="meter-wrapper">
          <div class="meter-header">
            <span>Level <?= (int)$levelInfo['level'] ?></span>
            <span><?= (int)$levelInfo['total_xp'] ?> / <?= (int)$levelInfo['next_min_xp'] ?> XP</span>
          </div>
          <div class="progress-bar-kid" style="height: 18px;">
            <div class="progress-fill-kid" style="width: <?= (int)$levelInfo['progress_percent'] ?>%;"></div>
          </div>
          <div style="text-align: right; font-size: var(--fs-xs); color: var(--text-light); margin-top: 2px;">
            <?php if ($levelInfo['level'] < 5): ?>
              Butuh <?= (int)($levelInfo['next_min_xp'] - $levelInfo['total_xp']) ?> XP lagi menuju Level <?= (int)$levelInfo['next_level'] ?>!
            <?php else: ?>
              Kamu berada di Level Tertinggi! Luar Biasa!
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Mission of the Day (Featured Quest) -->
  <?php if (!empty($recommendedMission)): ?>
    <section style="margin-bottom: var(--space-8);">
      <div class="card-kid" style="border: 3px solid #FBBF24; background: linear-gradient(135deg, #FFFBEB 0%, #FFFFFF 100%); display: flex; align-items: center; justify-content: space-between; gap: var(--space-6); flex-wrap: wrap;">
        <div style="display: flex; align-items: center; gap: var(--space-5);">
          <div style="width: 64px; height: 64px; border-radius: var(--radius-xl); background: #FEF3C7; display: flex; align-items: center; justify-content: center; font-size: 2.2rem; box-shadow: 0 4px 10px rgba(245, 158, 11, 0.2);">
            🎯
          </div>
          <div>
            <div class="badge-pill badge-pill-secondary" style="margin-bottom: var(--space-1);">
              Rekomendasi Misi Hari Ini • <?= e($recommendedMission['world_title'] ?? 'Dunia Petualangan') ?>
            </div>
            <h2 style="font-size: var(--fs-xl); margin-bottom: var(--space-1);">
              <?= e($recommendedMission['title']) ?>
            </h2>
            <p style="font-size: var(--fs-sm); max-width: 600px;">
              <?= e($recommendedMission['subtitle']) ?>
            </p>
          </div>
        </div>

        <a href="?page=mission&slug=<?= urlencode($recommendedMission['slug']) ?>" class="btn-kid btn-kid-secondary btn-featured-quest" style="padding: 0.9rem 2rem; font-size: var(--fs-md);" id="btn-play-today">
          Jalankan Misi Sekarang ⚡ (+<?= (int)$recommendedMission['xp_reward'] ?> XP)
        </a>
      </div>
    </section>
  <?php endif; ?>

  <!-- 3 Learning Worlds Hub -->
  <section style="margin-bottom: var(--space-10);">
    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: var(--space-4);">
      <div>
        <h2 style="font-size: var(--fs-2xl); margin-bottom: var(--space-1);">Dunia Petualangan</h2>
        <p style="font-size: var(--fs-sm);">Pilih dunia yang ingin kamu jelajahi:</p>
      </div>
      <a href="?page=worlds" class="btn-kid btn-kid-ghost" style="font-size: var(--fs-sm); padding: 0.5rem 1.2rem;">
        Lihat Peta Lengkap 🗺️
      </a>
    </div>

    <div class="worlds-grid">
      <?php foreach ($worlds as $w): ?>
        <?php 
          $themeClass = match($w['slug']) {
              'number-city' => 'theme-number',
              'discovery-lab' => 'theme-discovery',
              'thinking-lab' => 'theme-thinking',
              default => 'theme-discovery'
          };
          $icon = match($w['slug']) {
              'number-city' => '🧮',
              'discovery-lab' => '🌿',
              'thinking-lab' => '🤖',
              default => '⭐'
          };
          $btnClass = match($w['slug']) {
              'number-city' => 'btn-kid-secondary',
              'discovery-lab' => 'btn-kid-accent',
              'thinking-lab' => 'btn-kid-purple',
              default => 'btn-kid-primary'
          };
        ?>
        <div class="world-card <?= $themeClass ?>">
          <div>
            <div class="world-badge-icon"><?= $icon ?></div>
            <h3 class="world-title"><?= e($w['title']) ?></h3>
            <p class="world-subtitle"><?= e($w['subtitle']) ?></p>

            <!-- Progress Meter -->
            <div class="meter-wrapper" style="margin-bottom: var(--space-6);">
              <div class="meter-header">
                <span>Progres Selesai</span>
                <span><?= (int)$w['completed_missions'] ?> / <?= (int)$w['total_missions'] ?> Misi</span>
              </div>
              <div class="progress-bar-kid">
                <div class="progress-fill-kid" style="width: <?= (int)$w['progress_percent'] ?>%;"></div>
              </div>
            </div>
          </div>

          <a href="?page=worlds#world-<?= e($w['slug']) ?>" class="btn-kid <?= $btnClass ?>" style="width: 100%;">
            Jelajahi Misi 🚀
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </section>

  <!-- Skill Progress Journey -->
  <section style="margin-bottom: var(--space-8);">
    <div class="card-kid">
      <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: var(--space-6); flex-wrap: wrap; gap: var(--space-2);">
        <div>
          <h2 style="font-size: var(--fs-xl); margin-bottom: var(--space-1);">Jejak Keterampilan Belajar</h2>
          <p style="font-size: var(--fs-sm);">Perkembangan aktivitas dan daya nalar yang telah kamu asah:</p>
        </div>
        <a href="?page=progress" style="font-size: var(--fs-sm); color: var(--color-primary); font-weight: 700;">
          Detail Jejak Belajar &rarr;
        </a>
      </div>

      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: var(--space-5);">
        <?php foreach ($skills as $key => $sk): ?>
          <div style="background: var(--bg-surface-elevated); border: 2px solid var(--border-subtle); border-radius: var(--radius-lg); padding: var(--space-4);">
            <div style="display: flex; align-items: center; gap: var(--space-2); margin-bottom: var(--space-2);">
              <span style="font-size: 1.5rem;"><?= $sk['icon'] ?></span>
              <strong style="font-size: var(--fs-sm);"><?= e($sk['title']) ?></strong>
            </div>
            <div class="progress-bar-kid" style="height: 12px; margin-top: var(--space-2);">
              <div class="progress-fill-kid progress-fill-primary" style="width: <?= (int)$sk['percent'] ?>%;"></div>
            </div>
            <div style="text-align: right; font-size: var(--fs-xs); color: var(--text-muted); margin-top: 4px; font-weight: 700;">
              <?= (int)$sk['percent'] ?>%
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
