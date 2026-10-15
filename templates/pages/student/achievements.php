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
      <div class="card-kid" style="<?= $isUnlocked ? 'border: 2.5px solid var(--color-dark-outline); box-shadow: 0 7px 0 var(--color-dark-outline); background: linear-gradient(135deg, #FEF9C3 0%, #FFFFFF 100%);' : 'opacity: 0.7; background: #F8FAFC; border: 2.5px solid #CBD5E1;' ?>">
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: var(--space-4);">
          <div style="width: 58px; height: 58px; border-radius: var(--radius-xl); background: <?= $isUnlocked ? '#FEF08A' : '#E2E8F0' ?>; border: 2px solid var(--color-dark-outline); box-shadow: 0 3px 0 var(--color-dark-outline); display: flex; align-items: center; justify-content: center; font-size: 2rem;">
            <?= $isUnlocked ? $icon : '🔒' ?>
          </div>
          <span class="badge-pill <?= $isUnlocked ? 'badge-pill-secondary' : 'badge-pill-primary' ?>">
            +<?= (int)$ach['xp_reward'] ?> XP
          </span>
        </div>

        <h3 style="font-family: var(--font-heading); font-size: var(--fs-lg); font-weight: 800; margin-bottom: var(--space-2); color: <?= $isUnlocked ? 'var(--color-heading-navy)' : 'var(--text-muted)' ?>;">
          <?= e($ach['title']) ?>
        </h3>
        <p style="font-size: var(--fs-sm); font-weight: 600; margin-bottom: var(--space-4);">
          <?= e($ach['description']) ?>
        </p>

        <div style="padding-top: var(--space-3); border-top: 2px dashed #CBD5E1; font-family: var(--font-heading); font-size: var(--fs-xs); font-weight: 800; color: <?= $isUnlocked ? '#047857' : 'var(--text-light)' ?>;">
          <?= $isUnlocked ? '✓ Terbuka pada ' . date('d M Y', strtotime($ach['unlocked_at'])) : 'Belum Terbuka' ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
