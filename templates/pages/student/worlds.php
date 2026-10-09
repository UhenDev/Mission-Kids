<?php
/**
 * MISSION KIDS — Worlds & Adventure Map
 */

declare(strict_types=1);

require __DIR__ . '/../../layouts/header.php';
?>

<div class="container">
  <div style="text-align: center; margin-bottom: var(--space-8);">
    <div class="badge-pill badge-pill-primary" style="margin-bottom: var(--space-2);">
      🗺️ Peta Petualangan Belajar
    </div>
    <h1 style="font-size: var(--fs-3xl); margin-bottom: var(--space-2);">Jelajahi Misi dan Buka Rahasia Dunia</h1>
    <p style="font-size: var(--fs-md); max-width: 650px; margin: 0 auto;">
      Selesaikan setiap misi secara berurutan untuk membuka tantangan berikutnya dan mengumpulkan XP!
    </p>
  </div>

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
    ?>
    <section id="world-<?= e($w['slug']) ?>" class="adventure-map-shell <?= $themeClass ?>" style="margin-bottom: var(--space-10);">
      <!-- World Section Header -->
      <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid var(--border-subtle); padding-bottom: var(--space-4); margin-bottom: var(--space-6); flex-wrap: wrap; gap: var(--space-3);">
        <div style="display: flex; align-items: center; gap: var(--space-3);">
          <div style="font-size: 2.5rem;"><?= $icon ?></div>
          <div>
            <h2 style="font-size: var(--fs-2xl); margin-bottom: 2px;"><?= e($w['title']) ?></h2>
            <p style="font-size: var(--fs-sm);"><?= e($w['subtitle']) ?></p>
          </div>
        </div>

        <div style="display: flex; align-items: center; gap: var(--space-3);">
          <div style="font-size: var(--fs-sm); font-weight: 700; color: var(--text-muted);">
            Progres: <?= (int)$w['completed_missions'] ?>/<?= (int)$w['total_missions'] ?> Selesai
          </div>
          <div style="width: 120px;">
            <div class="progress-bar-kid">
              <div class="progress-fill-kid" style="width: <?= (int)$w['progress_percent'] ?>%;"></div>
            </div>
          </div>
        </div>
      </div>

      <!-- Adventure Trail Nodes -->
      <div class="adventure-trail">
        <?php foreach ($w['missions'] as $index => $m): ?>
          <?php
            $nodeStatus = $m['progress_status'];
            $isLocked = ($nodeStatus === 'locked');
            $isCompleted = ($nodeStatus === 'completed');
            $isAvailable = ($nodeStatus === 'available');
          ?>
          <div class="mission-map-node <?= $nodeStatus ?>" id="mission-node-<?= e($m['slug']) ?>">
            <div class="node-left-col">
              <div class="node-number-circle">
                <?= $isCompleted ? '✓' : ($index + 1) ?>
              </div>
              <div class="node-meta">
                <div style="display: flex; align-items: center; gap: var(--space-2);">
                  <h3><?= e($m['title']) ?></h3>
                  <?php if ($isCompleted): ?>
                    <span style="color: #F59E0B; font-size: var(--fs-sm);">
                      <?= str_repeat('⭐', max(1, (int)$m['stars'])) ?>
                    </span>
                  <?php endif; ?>
                </div>
                <p><?= e($m['subtitle']) ?></p>
                <div style="font-size: var(--fs-xs); color: var(--color-primary); font-weight: 700; margin-top: 4px;">
                  🎯 <?= e($m['learning_objective']) ?>
                </div>
              </div>
            </div>

            <div>
              <?php if ($isCompleted): ?>
                <a href="?page=mission&slug=<?= urlencode($m['slug']) ?>" class="btn-kid btn-kid-accent" style="font-size: var(--fs-sm); padding: 0.5rem 1.2rem;">
                  Main Lagi 🔄
                </a>
              <?php elseif ($isAvailable): ?>
                <a href="?page=mission&slug=<?= urlencode($m['slug']) ?>" class="btn-kid btn-kid-primary" style="font-size: var(--fs-sm); padding: 0.6rem 1.4rem;">
                  Mulai Misi ⚡
                </a>
              <?php else: ?>
                <span class="btn-kid btn-kid-ghost" style="font-size: var(--fs-sm); padding: 0.5rem 1.2rem; cursor: not-allowed; opacity: 0.7;">
                  🔒 Terkunci
                </span>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>
  <?php endforeach; ?>
</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
