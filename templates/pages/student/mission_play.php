<?php
/**
 * MISSION KIDS — Mission Gameplay Interface
 * Hosts the 7-Step Mission Lifecycle & Interactive Engine
 */

declare(strict_types=1);

require __DIR__ . '/../../layouts/header.php';
?>

<div class="container" style="max-width: 1040px;">
  <!-- Mission Shell -->
  <div class="mission-shell" id="mission-shell" data-slug="<?= e($mission['slug']) ?>" data-id="<?= (int)$mission['id'] ?>">
    
    <!-- Top Bar -->
    <div class="mission-topbar">
      <div class="mission-breadcrumbs">
        <a href="?page=worlds" style="color: var(--color-primary);">&larr; Peta</a>
        <span>/</span>
        <span><?= e($mission['world_title']) ?></span>
        <span>/</span>
        <strong><?= e($mission['title']) ?></strong>
      </div>

      <!-- 7-Step Stepper -->
      <div class="mission-steps-stepper" id="mission-stepper">
        <div class="step-node active" data-step="story">1. Cerita</div>
        <div class="step-node" data-step="learn">2. Konsep</div>
        <div class="step-node" data-step="challenge">3. Tantangan</div>
        <div class="step-node" data-step="reflection">4. Refleksi</div>
        <div class="step-node" data-step="reward">5. Hadiah</div>
      </div>
    </div>

    <!-- STAGE 1: STORY -->
    <div class="stage-panel active" id="stage-story">
      <div class="story-card-inner">
        <div class="badge-pill badge-pill-primary story-badge-category">
          Tantangan Misi: <?= e($mission['world_title']) ?>
        </div>
        <h1 class="story-title"><?= e($mission['title']) ?></h1>
        <p style="font-size: var(--fs-md); color: var(--text-muted);">
          <?= e($mission['subtitle']) ?>
        </p>

        <div class="story-dialogue-box">
          <?= e($mission['config']['scenario'] ?? 'Bantu sahabat kita menyelesaikan teka-teki ini bersama MIKO!') ?>
        </div>

        <button type="button" class="btn-kid btn-kid-primary" id="btn-story-next" style="padding: 0.9rem 2.2rem; font-size: var(--fs-lg);">
          Pelajari Caranya &rarr;
        </button>
      </div>
    </div>

    <!-- STAGE 2: LEARN -->
    <div class="stage-panel" id="stage-learn">
      <div class="story-card-inner">
        <div class="badge-pill badge-pill-accent story-badge-category">
          Tahap 2: Rahasia Konsep
        </div>
        <h2 class="story-title">Fokus Pembelajaran</h2>
        
        <div style="background: #EFF6FF; border: 2px solid #BFDBFE; border-radius: var(--radius-xl); padding: var(--space-6); margin: var(--space-6) 0; text-align: left;">
          <h3 style="font-size: var(--fs-lg); color: var(--color-primary); margin-bottom: var(--space-2);">
            🎯 Tujuan Belajarmu:
          </h3>
          <p style="font-size: var(--fs-md); color: var(--text-main); margin-bottom: var(--space-4);">
            <?= e($mission['learning_objective']) ?>
          </p>

          <div style="background: #FFFFFF; border-radius: var(--radius-lg); padding: var(--space-4); border: 1px solid #DBEAFE;">
            <strong style="color: #1E40AF; display: block; margin-bottom: var(--space-1);">💡 Petunjuk Eksplorasi:</strong>
            <p style="font-size: var(--fs-sm); color: var(--text-muted); margin: 0;">
              Di layar berikutnya, kamu bisa menggeser tombol, memindahkan benda, atau menyusun langkah secara bebas. Amati apa yang berubah ketika kamu beraksi!
            </p>
          </div>
        </div>

        <div style="display: flex; gap: var(--space-3); justify-content: center;">
          <button type="button" class="btn-kid btn-kid-ghost" id="btn-learn-back">
            &larr; Baca Cerita Lagi
          </button>
          <button type="button" class="btn-kid btn-kid-primary" id="btn-learn-next" style="padding: 0.9rem 2.2rem; font-size: var(--fs-lg);">
            Mulai Tantangan Interaktif! ⚡
          </button>
        </div>
      </div>
    </div>

    <!-- STAGE 3: INTERACTIVE CHALLENGE -->
    <div class="stage-panel" id="stage-challenge">
      <div class="challenge-layout">
        <!-- Interactive Viewport Canvas -->
        <div class="interactive-viewport" id="interactive-viewport">
          <!-- Dynamic Content rendered by JS Engine based on interaction_type -->
          <div id="canvas-game-area" style="width: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center;">
            Memuat arena tantangan...
          </div>
        </div>

        <!-- Controls Tray -->
        <div class="interactive-control-panel">
          <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid var(--border-subtle); padding-bottom: var(--space-3);">
            <strong style="font-family: var(--font-heading); font-size: var(--fs-md);">
              Panel Aksi Petualang
            </strong>
            <span class="badge-pill badge-pill-secondary" id="attempt-badge">
              Percobaan 1
            </span>
          </div>

          <!-- Dynamic Controls injected by JS -->
          <div id="controls-tray-area"></div>

          <!-- Hint & Execution Action Buttons -->
          <div style="display: flex; flex-direction: column; gap: var(--space-3); margin-top: var(--space-4); padding-top: var(--space-4); border-top: 1px solid var(--border-subtle);">
            <button type="button" class="btn-kid btn-kid-primary" id="btn-check-solution" style="width: 100%; font-size: var(--fs-md);">
              Periksa Hasil Jawaban ✨
            </button>
            <button type="button" class="btn-kid btn-kid-ghost" id="btn-request-hint" style="width: 100%; font-size: var(--fs-sm); border-color: #38BDF8; color: #0284C7;">
              💡 Minta Petunjuk MIKO (Level <span id="hint-level-display">1</span>)
            </button>
          </div>

          <!-- In-canvas Feedback Message Box -->
          <div id="in-canvas-feedback" style="display: none; border-radius: var(--radius-lg); padding: var(--space-3); font-size: var(--fs-sm); font-weight: 700; text-align: center;"></div>
        </div>
      </div>
    </div>

    <!-- STAGE 4: REFLECTION -->
    <div class="stage-panel" id="stage-reflection">
      <div class="story-card-inner">
        <div class="badge-pill badge-pill-accent story-badge-category">
          Tahap 4: Refleksi Cerdas
        </div>
        <h2 class="story-title">Apa yang Kamu Pelajari?</h2>
        <p style="font-size: var(--fs-md); color: var(--text-muted);">
          Hebat! Kamu berhasil memecahkan tantangan tadi. Sekarang mari renungkan sejenak:
        </p>

        <div style="background: #FFFFFF; border: 2px solid var(--border-interactive); border-radius: var(--radius-xl); padding: var(--space-6); margin: var(--space-6) 0; text-align: left;">
          <h3 id="reflection-question-text" style="font-size: var(--fs-lg); margin-bottom: var(--space-4); color: var(--text-main);">
            Pertanyaan refleksi...
          </h3>

          <div class="reflection-options-list" id="reflection-options-tray">
            <!-- Dynamically populated options -->
          </div>
        </div>

        <button type="button" class="btn-kid btn-kid-primary" id="btn-submit-reflection" disabled style="padding: 0.9rem 2.2rem; font-size: var(--fs-lg);">
          Kirim Refleksi & Buka Hadiah! 🎁
        </button>
      </div>
    </div>

    <!-- STAGE 5: CELEBRATION & REWARDS -->
    <div class="stage-panel" id="stage-reward">
      <div class="celebration-box">
        <div style="font-size: 3.5rem;">🎉</div>
        <h1 style="font-size: var(--fs-3xl); color: var(--color-primary); margin-bottom: var(--space-2);">
          MISI BERHASIL DITUNTASKAN!
        </h1>
        <p style="font-size: var(--fs-lg); color: var(--text-muted);">
          Luar biasa, <?= e(Session::get('nickname', 'Kapten')) ?>! MIKO bangga dengan ketekunanmu!
        </p>

        <!-- Stars Row -->
        <div class="stars-row" id="reward-stars-tray">
          ⭐ ⭐ ⭐
        </div>

        <!-- XP Breakdown -->
        <div class="xp-breakdown-list" id="xp-breakdown-tray">
          <div class="xp-breakdown-item">
            <span>Misi Selesai</span>
            <span>+100 XP</span>
          </div>
        </div>

        <!-- Newly Unlocked Achievements Alert (if any) -->
        <div id="unlocked-badge-alert" style="display: none; background: #D1FAE5; border: 2px solid #6EE7B7; border-radius: var(--radius-xl); padding: var(--space-4); margin-bottom: var(--space-6);">
          <strong style="color: #065F46; font-size: var(--fs-md);">🏅 Medali Baru Terbuka!</strong>
          <p id="unlocked-badge-desc" style="color: #047857; font-size: var(--fs-sm); margin-top: 4px;"></p>
        </div>

        <div style="display: flex; gap: var(--space-4); justify-content: center; flex-wrap: wrap;">
          <a href="?page=worlds" class="btn-kid btn-kid-primary" style="padding: 0.9rem 2.2rem; font-size: var(--fs-md);" id="btn-next-mission-link">
            Lanjut Petualangan Peta 🗺️
          </a>
          <button type="button" class="btn-kid btn-kid-ghost" onclick="location.reload();" style="padding: 0.9rem 1.6rem; font-size: var(--fs-md);">
            Mainkan Ulang 🔄
          </button>
        </div>
      </div>
    </div>

  </div>
</div>

<!-- Raw Mission Configuration Data for Frontend Engine -->
<script id="mission-config-json" type="application/json">
<?= $mission['config_json'] ?>
</script>

<script>
window.CURRENT_MISSION = {
  id: <?= (int)$mission['id'] ?>,
  slug: <?= json_encode($mission['slug']) ?>,
  title: <?= json_encode($mission['title']) ?>,
  type: <?= json_encode($mission['interaction_type']) ?>,
  config: JSON.parse(document.getElementById('mission-config-json').textContent),
  csrf_token: <?= json_encode($csrfToken) ?>
};
</script>

<!-- Load Mission Engine Scripts -->
<script src="js/engine/InteractionHandler.js"></script>
<script src="js/engine/MikoCompanion.js"></script>
<script src="js/engine/MissionEngine.js"></script>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
