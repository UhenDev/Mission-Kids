<?php
/**
 * MISSION KIDS — Achievements & Badges Showcase
 */

declare(strict_types=1);

require __DIR__ . '/../../layouts/header.php';
?>

<div class="container" style="max-width: 900px;">
  <div style="text-align: center; margin-bottom: var(--space-8);">
    <div class="badge-pill badge-pill-secondary" style="margin-bottom: var(--space-2);">
      🏅 Koleksi Medali Prestasi
    </div>
    <h1 style="font-size: var(--fs-3xl); margin-bottom: var(--space-2);">Ruang Medali Petualang Cilik</h1>
    <p style="font-size: var(--fs-md); color: var(--text-muted);">
      Selesaikan tantangan di setiap dunia untuk membuka medali kehormatan dan bonus XP berharga!
    </p>
  </div>

  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: var(--space-6);">
    <?php foreach ($achievements as $ach): ?>
      <?php
        $isUnlocked = (bool)($ach['is_unlocked'] ?? false);
        $icon = match($ach['icon_name']) {
            'rocket' => '🚀',
            'calculator' => '🧮',
            'flask' => '🔬',
            'cpu' => '🤖',
            'trophy' => '🏆',
            default => '⭐'
        };
      ?>
      <div class="card-kid" style="<?= $isUnlocked ? 'border-color: #FCD34D; background: linear-gradient(135deg, #FFFBEB 0%, #FFFFFF 100%);' : 'opacity: 0.65; background: #F8FAFC;' ?>">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: var(--space-4);">
          <div style="width: 56px; height: 56px; border-radius: var(--radius-xl); background: <?= $isUnlocked ? '#FEF3C7' : '#E2E8F0' ?>; display: flex; align-items: center; justify-content: center; font-size: 2rem; box-shadow: 0 4px 10px rgba(0,0,0,0.06);">
            <?= $isUnlocked ? $icon : '🔒' ?>
          </div>
          <span class="badge-pill <?= $isUnlocked ? 'badge-pill-secondary' : 'badge-pill-primary' ?>">
            +<?= (int)$ach['xp_reward'] ?> XP
          </span>
        </div>

        <h3 style="font-size: var(--fs-lg); margin-bottom: var(--space-2); color: <?= $isUnlocked ? 'var(--text-main)' : 'var(--text-muted)' ?>;">
          <?= e($ach['title']) ?>
        </h3>
        <p style="font-size: var(--fs-sm); margin-bottom: var(--space-4);">
          <?= e($ach['description']) ?>
        </p>

        <div style="padding-top: var(--space-3); border-top: 1px solid var(--border-subtle); font-size: var(--fs-xs); font-weight: 700; color: <?= $isUnlocked ? '#059669' : 'var(--text-light)' ?>;">
          <?= $isUnlocked ? '✓ Terbuka pada ' . date('d M Y', strtotime($ach['unlocked_at'])) : 'Belum Terbuka' ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
