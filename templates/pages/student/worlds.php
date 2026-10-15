<?php
/**
 * MISSION KIDS — Worlds & Adventure Map
 * Per-Map Question Isolation Architecture
 */

declare(strict_types=1);

require __DIR__ . '/../../layouts/header.php';

$activeWorldSlug = $activeWorldSlug ?? ($selectedWorld['slug'] ?? ($worlds[0]['slug'] ?? 'number-city'));
?>

<div class="container">
  <!-- Page Header -->
  <div style="text-align: center; margin-bottom: var(--space-6);">
    <div class="badge-pill badge-pill-primary" style="margin-bottom: var(--space-2);">
      🗺️ Peta Petualangan Belajar
    </div>
    <h1 style="font-size: var(--fs-3xl); margin-bottom: var(--space-2);">Pilih Peta Petualanganmu</h1>
    <p style="font-size: var(--fs-md); max-width: 650px; margin: 0 auto; color: var(--text-muted);">
      Setiap peta memiliki kumpulan soal dan tantangan uniknya sendiri. Pilih salah satu peta di bawah untuk menyelesaikan misi!
    </p>
  </div>

  <!-- =========================================================================
       1. INTERACTIVE MAP SELECTOR (PETA 1 - PETA 4)
       ========================================================================= -->
  <nav class="map-selector-nav" aria-label="Pilihan Peta Petualangan">
    <div class="map-selector-grid" id="map-tabs-container" role="tablist">
      <?php foreach ($worlds as $idx => $w): ?>
        <?php
          $petaNum = $idx + 1;
          $isActive = ($w['slug'] === $activeWorldSlug);
          $icon = match($w['slug']) {
            'number-city' => '🧮',
            'discovery-lab' => '🌿',
            'thinking-lab' => '🤖',
            'space-odyssey' => '🚀',
            default => '⭐'
          };
          $themeClass = match($w['slug']) {
            'number-city' => 'theme-number',
            'discovery-lab' => 'theme-discovery',
            'thinking-lab' => 'theme-thinking',
            'space-odyssey' => 'theme-space',
            default => 'theme-discovery'
          };
        ?>
        <a 
          href="?page=worlds&world=<?= urlencode($w['slug']) ?>" 
          class="map-tab-btn <?= $themeClass ?> <?= $isActive ? 'active' : '' ?>" 
          id="tab-peta-<?= $petaNum ?>"
          data-map-slug="<?= e($w['slug']) ?>"
          data-peta-num="<?= $petaNum ?>"
          role="tab"
          aria-selected="<?= $isActive ? 'true' : 'false' ?>"
          aria-controls="map-panel-<?= e($w['slug']) ?>"
          tabindex="0"
        >
          <div class="map-tab-top-row">
            <span class="map-number-badge">Peta <?= $petaNum ?></span>
            <span class="map-tab-icon" aria-hidden="true"><?= $icon ?></span>
          </div>

          <div class="map-tab-title"><?= e($w['title']) ?></div>
          <div class="map-tab-subtitle"><?= e($w['subtitle']) ?></div>

          <div class="map-tab-progress-wrap">
            <div class="map-tab-progress-text">
              <span><?= (int)$w['completed_missions'] ?>/<?= (int)$w['total_missions'] ?> Soal</span>
              <span><?= (int)$w['progress_percent'] ?>%</span>
            </div>
            <div class="progress-bar-kid" style="height: 6px;">
              <div class="progress-fill-kid" style="width: <?= (int)$w['progress_percent'] ?>%;"></div>
            </div>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </nav>

  <!-- =========================================================================
       2. ISOLATED MAP QUESTIONS PANELS (ONLY THE ACTIVE MAP IS SHOWN)
       ========================================================================= -->
  <div id="map-panels-container">
    <?php foreach ($worlds as $idx => $w): ?>
      <?php
        $petaNum = $idx + 1;
        $isActive = ($w['slug'] === $activeWorldSlug);
        $themeClass = match($w['slug']) {
          'number-city' => 'theme-number',
          'discovery-lab' => 'theme-discovery',
          'thinking-lab' => 'theme-thinking',
          'space-odyssey' => 'theme-space',
          default => 'theme-discovery'
        };
        $icon = match($w['slug']) {
          'number-city' => '🧮',
          'discovery-lab' => '🌿',
          'thinking-lab' => '🤖',
          'space-odyssey' => '🚀',
          default => '⭐'
        };
      ?>
      <section 
        id="map-panel-<?= e($w['slug']) ?>" 
        class="map-questions-panel <?= $isActive ? 'active' : '' ?> adventure-map-shell <?= $themeClass ?>" 
        data-map-slug="<?= e($w['slug']) ?>"
        data-peta-num="<?= $petaNum ?>"
        role="tabpanel"
        aria-labelledby="tab-peta-<?= $petaNum ?>"
        style="<?= $isActive ? 'display: block;' : 'display: none;' ?> margin-bottom: var(--space-10);"
      >
        <!-- Map Banner Header -->
        <div class="map-banner-header">
          <div class="map-banner-left">
            <div class="map-banner-icon-disc world-badge-icon" aria-hidden="true">
              <?= $icon ?>
            </div>
            <div>
              <span class="map-banner-peta-pill badge-pill-primary">
                📍 Peta <?= $petaNum ?> • <?= (int)$w['total_missions'] ?> Soal Belajar
              </span>
              <h2 class="map-banner-title"><?= e($w['title']) ?></h2>
              <p class="map-banner-subtitle"><?= e($w['subtitle']) ?></p>
            </div>
          </div>

          <div class="map-banner-progress-box">
            <div style="font-size: var(--fs-sm); font-weight: 800; color: #1E3A8A;">
              Progres Peta: <?= (int)$w['completed_missions'] ?> dari <?= (int)$w['total_missions'] ?> Selesai
            </div>
            <div style="width: 160px;">
              <div class="progress-bar-kid" style="height: 10px;">
                <div class="progress-fill-kid" style="width: <?= (int)$w['progress_percent'] ?>%;"></div>
              </div>
            </div>
          </div>
        </div>

        <!-- Strict Question List for this Map Only -->
        <div class="adventure-trail" id="trail-<?= e($w['slug']) ?>">
          <?php foreach ($w['missions'] as $index => $m): ?>
            <?php
              $nodeStatus = $m['progress_status'];
              $isLocked = ($nodeStatus === 'locked');
              $isCompleted = ($nodeStatus === 'completed');
              $isAvailable = ($nodeStatus === 'available');
              $questionNumber = $index + 1;
            ?>
            <div class="mission-map-node <?= $nodeStatus ?>" id="mission-node-<?= e($m['slug']) ?>">
              <div class="node-left-col">
                <div class="node-number-circle" aria-label="Soal nomor <?= $questionNumber ?>">
                  <?= $isCompleted ? '✓' : $questionNumber ?>
                </div>
                <div class="node-meta">
                  <div style="display: flex; align-items: center; gap: var(--space-2); flex-wrap: wrap;">
                    <h3 style="margin: 0;"><?= e($m['title']) ?></h3>
                    <?php if ($isCompleted): ?>
                      <span style="color: #F59E0B; font-size: var(--fs-sm);" title="<?= (int)$m['stars'] ?> Bintang">
                        <?= str_repeat('⭐', max(1, (int)$m['stars'])) ?>
                      </span>
                    <?php endif; ?>
                    <span class="badge-pill badge-pill-secondary" style="font-size: 10px; padding: 2px 7px;">
                      +<?= (int)$m['xp_reward'] ?> XP
                    </span>
                  </div>
                  <p style="margin: 4px 0 0 0;"><?= e($m['subtitle']) ?></p>
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
</div>

<!-- Map Switching & URL PushState Persistence -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  const tabs = document.querySelectorAll('.map-tab-btn');
  const panels = document.querySelectorAll('.map-questions-panel');

  function switchMap(targetSlug, shouldPushState = true) {
    if (!targetSlug) return;

    let targetFound = false;

    // 1. Update tab buttons
    tabs.forEach(tab => {
      const slug = tab.getAttribute('data-map-slug');
      if (slug === targetSlug) {
        tab.classList.add('active');
        tab.setAttribute('aria-selected', 'true');
        targetFound = true;
      } else {
        tab.classList.remove('active');
        tab.setAttribute('aria-selected', 'false');
      }
    });

    if (!targetFound && tabs.length > 0) {
      targetSlug = tabs[0].getAttribute('data-map-slug');
      tabs[0].classList.add('active');
      tabs[0].setAttribute('aria-selected', 'true');
    }

    // 2. Strictly isolate questions: hide all panels, show only target panel
    panels.forEach(panel => {
      const panelSlug = panel.getAttribute('data-map-slug');
      if (panelSlug === targetSlug) {
        panel.style.display = 'block';
        panel.classList.add('active');
      } else {
        panel.style.display = 'none';
        panel.classList.remove('active');
      }
    });

    // 3. Update browser URL & Session via query parameter so reload stays on exact map
    if (shouldPushState && window.history && window.history.pushState) {
      const url = new URL(window.location.href);
      url.searchParams.set('page', 'worlds');
      url.searchParams.set('world', targetSlug);
      window.history.pushState({ world: targetSlug }, '', url.toString());
    }
  }

  // Attach click listener to each map tab
  tabs.forEach(tab => {
    tab.addEventListener('click', (e) => {
      e.preventDefault();
      const slug = tab.getAttribute('data-map-slug');
      if (window.SoundFX && typeof window.SoundFX.playTap === 'function') {
        window.SoundFX.playTap();
      }
      switchMap(slug, true);
    });

    tab.addEventListener('keydown', (e) => {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        const slug = tab.getAttribute('data-map-slug');
        switchMap(slug, true);
      }
    });
  });

  // Handle browser Back / Forward buttons
  window.addEventListener('popstate', (e) => {
    const urlParams = new URLSearchParams(window.location.search);
    const worldParam = urlParams.get('world') || 'number-city';
    switchMap(worldParam, false);
  });
});
</script>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
