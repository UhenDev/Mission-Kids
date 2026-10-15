<?php
/**
 * MISSION KIDS — Student Home (Markas Petualang)
 * Refined, Cohesive, Child-Friendly Dashboard
 */

declare(strict_types=1);

require __DIR__ . '/../../layouts/header.php';
?>

<div class="container">
  <!-- Top Row: Profile Card & Quest Recommendation Card -->
  <div class="dashboard-top-row">
    <!-- Left Card: Profile & Level Summary -->
    <div class="dash-profile-card-mockup">
      <div style="display: flex; align-items: center; gap: var(--space-4); margin-bottom: var(--space-4);">
        <?php $heroChar = Avatar::get($profile['avatar_id'] ?? Avatar::DEFAULT_AVATAR); ?>
        <div class="welcome-avatar-disc" id="hero-avatar-disc" style="width: 64px; height: 64px; min-width: 64px; border-radius: 50%; overflow: hidden; padding: 0; border: 2.5px solid #3B82F6; box-shadow: 0 4px 14px rgba(37, 99, 235, 0.18);" title="Karakter: <?= e($heroChar['title']) ?>">
          <img src="<?= e($heroChar['thumb']) ?>" alt="<?= e($heroChar['name']) ?>" style="width: 100%; height: 100%; object-fit: cover; display: block;" onerror="this.outerHTML='<?= $heroChar['fallback_icon'] ?>';">
        </div>
        <div>
          <h1 style="font-family: var(--font-heading); font-size: var(--fs-xl); color: #0F172A; margin-bottom: 2px;">
            Halo, <?= e($profile['nickname']) ?>! 👋
          </h1>
          <p style="font-size: var(--fs-xs); color: var(--text-muted); margin: 0;">
            Karakter: <strong style="color: #1D4ED8;"><?= e($heroChar['title']) ?></strong> • Siap berpetualang?
          </p>
        </div>
      </div>

      <!-- Level & XP Progress Meter -->
      <div>
        <div style="display: flex; align-items: center; justify-content: space-between; font-size: var(--fs-xs); font-weight: 700; color: #1E3A8A; margin-bottom: 6px;">
          <span>Level <?= (int)$levelInfo['level'] ?> • <?= e($levelInfo['name']) ?></span>
          <span style="color: var(--text-muted);"><?= (int)$levelInfo['total_xp'] ?> / <?= (int)$levelInfo['next_min_xp'] ?> XP</span>
        </div>
        <div class="progress-bar-kid" style="height: 12px;">
          <div class="progress-fill-kid" style="width: <?= (int)$levelInfo['progress_percent'] ?>%; background: linear-gradient(90deg, #3B82F6, #1D4ED8);"></div>
        </div>
      </div>
    </div>

    <!-- Right Card: Rekomendasi Misi Hari Ini -->
    <?php if (!empty($recommendedMission)): ?>
      <div class="dash-quest-card-mockup">
        <div style="flex: 1;">
          <div class="badge-pill badge-pill-secondary" style="margin-bottom: var(--space-2); display: inline-flex; align-items: center; gap: 4px; font-size: 11px;">
            <span>🎯</span> Rekomendasi Misi Hari Ini
          </div>
          <h2 style="font-family: var(--font-heading); font-size: var(--fs-lg); font-weight: 800; color: #78350F; margin-bottom: 4px;">
            <?= e($recommendedMission['title']) ?>
          </h2>
          <p style="font-size: var(--fs-xs); color: #92400E; margin: 0; line-height: 1.4;">
            <?= e($recommendedMission['subtitle']) ?>
          </p>
        </div>

        <div>
          <a href="?page=mission&slug=<?= urlencode($recommendedMission['slug']) ?>" class="hero-cta-btn-pill shine-effect" id="btn-play-today" style="background: linear-gradient(135deg, #F59E0B, #D97706); box-shadow: 0 6px 20px rgba(245, 158, 11, 0.35); padding: 0.8rem 1.6rem; font-size: var(--fs-sm); white-space: nowrap;">
            <span>Mulai Misi</span>
            <span>➔</span>
          </a>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <!-- Main Bottom Row: Dunia Petualangan & Keterampilan Belajar -->
  <div class="dashboard-bottom-row">
    <!-- Left: Dunia Petualangan Grid -->
    <div>
      <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: var(--space-4);">
        <h2 style="font-family: var(--font-heading); font-size: var(--fs-xl); font-weight: 800; color: #0F172A; margin: 0;">
          Dunia Petualangan
        </h2>
        <a href="?page=worlds" class="btn-kid btn-kid-ghost" style="font-size: var(--fs-xs); padding: 0.35rem 0.9rem; min-height: 34px;">
          Lihat Peta Lengkap 🗺️
        </a>
      </div>

      <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: var(--space-3);">
        <?php foreach ($worlds as $idx => $w): ?>
          <?php 
            $thumb = match($w['slug']) {
              'number-city' => 'assets/images/number-city.jpg',
              'discovery-lab' => 'assets/images/discovery-lab.jpg',
              'thinking-lab' => 'assets/images/thinking-lab.jpg',
              'space-odyssey' => 'assets/images/space-odyssey.jpg',
              default => 'assets/images/discovery-lab.jpg'
            };
          ?>
          <a href="?page=worlds&world=<?= urlencode($w['slug']) ?>" class="world-card-h-item" style="text-decoration: none; color: inherit; border-radius: var(--radius-xl); overflow: hidden; border: 1.5px solid var(--border-subtle); background: #FFFFFF; transition: transform 0.2s ease, box-shadow 0.2s ease;" title="Buka Peta <?= $idx + 1 ?>: <?= e($w['title']) ?>">
            <div style="height: 100px; overflow: hidden; background: #F1F5F9; position: relative;">
              <img src="<?= $thumb ?>" alt="<?= e($w['title']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
              <span style="position: absolute; top: 6px; left: 6px; background: rgba(15, 23, 42, 0.75); color: #FFFFFF; font-size: 10px; font-weight: 800; padding: 2px 7px; border-radius: var(--radius-pill); backdrop-filter: blur(4px);">
                Peta <?= $idx + 1 ?>
              </span>
            </div>
            <div style="padding: var(--space-3);">
              <h3 style="font-family: var(--font-heading); font-size: var(--fs-xs); font-weight: 800; color: #0F172A; margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                <?= e($w['title']) ?>
              </h3>
              <div style="font-size: 10px; color: var(--text-muted); font-weight: 700;">
                <?= (int)$w['completed_missions'] ?>/<?= (int)$w['total_missions'] ?> selesai
              </div>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Right: Keterampilan Belajar -->
    <div>
      <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: var(--space-4);">
        <h2 style="font-family: var(--font-heading); font-size: var(--fs-xl); font-weight: 800; color: #0F172A; margin: 0;">
          Keterampilan Belajar
        </h2>
        <a href="?page=progress" style="font-size: var(--fs-xs); color: var(--color-primary); font-weight: 700; text-decoration: none;">
          Detail Jejak Belajar &rarr;
        </a>
      </div>

      <div style="background: #FFFFFF; border: 2px solid #E2E8F0; border-radius: 20px; padding: var(--space-5); box-shadow: 0 6px 18px rgba(15, 23, 42, 0.04);">
        <div style="font-size: var(--fs-xs); color: var(--text-light); margin-bottom: var(--space-3); font-weight: 600;">
          Jejak Keterampilan Belajar kamu terus berkembang:
        </div>
        <div style="display: flex; flex-direction: column; gap: var(--space-4);">
          <?php foreach ($skills as $key => $sk): ?>
            <div>
              <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 4px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                  <span style="font-size: 1.2rem;"><?= $sk['icon'] ?></span>
                  <strong style="font-size: var(--fs-xs); color: #1E293B;"><?= e($sk['title']) ?></strong>
                </div>
                <span style="font-size: var(--fs-xs); font-weight: 800; color: #2563EB;"><?= (int)$sk['percent'] ?>%</span>
              </div>
              <div class="progress-bar-kid" style="height: 8px;">
                <div class="progress-fill-kid" style="width: <?= (int)$sk['percent'] ?>%; background: linear-gradient(90deg, #38BDF8, #2563EB);"></div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
