<?php
/**
 * MISSION KIDS — Student Learning Journey & Progress View
 */

declare(strict_types=1);

require __DIR__ . '/../../layouts/header.php';
?>

<div class="container" style="max-width: 900px;">
  <div style="text-align: center; margin-bottom: var(--space-8);">
    <div class="badge-pill badge-pill-accent" style="margin-bottom: var(--space-2);">
      📊 Jejak Belajar & Daya Nalar
    </div>
    <h1 style="font-size: var(--fs-3xl); margin-bottom: var(--space-2);">Perjalanan Keterampilan Cilik</h1>
    <p style="font-size: var(--fs-md); color: var(--text-muted); max-width: 650px; margin: 0 auto;">
      Lihat bagaimana rasa ingin tahu, kemampuan berhitung, eksperimen sains, dan logika berpikirmu terus bertumbuh!
    </p>
  </div>

  <!-- Skill Progress Cards -->
  <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(min(100%, 280px), 1fr)); gap: var(--space-6); margin-bottom: var(--space-10);">
    <div class="card-kid">
      <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: var(--space-3);">
        <div style="display: flex; align-items: center; gap: var(--space-3);">
          <span style="font-size: 2rem;">🧮</span>
          <div>
            <h3 style="font-size: var(--fs-lg);">Numerasi & Pola Bilangan</h3>
            <p style="font-size: var(--fs-xs);">Berhitung, belanja koin, deret lompat, dan keteraturan visual.</p>
          </div>
        </div>
        <span style="font-family: var(--font-heading); font-size: var(--fs-xl); color: #D97706;">
          <?= (int)$skills['numeracy']['percent'] ?>%
        </span>
      </div>
      <div class="progress-bar-kid">
        <div class="progress-fill-kid" style="width: <?= (int)$skills['numeracy']['percent'] ?>%;"></div>
      </div>
    </div>

    <div class="card-kid">
      <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: var(--space-3);">
        <div style="display: flex; align-items: center; gap: var(--space-3);">
          <span style="font-size: 2rem;">🔬</span>
          <div>
            <h3 style="font-size: var(--fs-lg);">Pemikiran Ilmiah & Sains Alam</h3>
            <p style="font-size: var(--fs-xs);">Eksperimen sebab-akibat tumbuhan, optika bayangan, dan siklus air.</p>
          </div>
        </div>
        <span style="font-family: var(--font-heading); font-size: var(--fs-xl); color: #059669;">
          <?= (int)$skills['science']['percent'] ?>%
        </span>
      </div>
      <div class="progress-bar-kid">
        <div class="progress-fill-kid progress-fill-accent" style="width: <?= (int)$skills['science']['percent'] ?>%;"></div>
      </div>
    </div>

    <div class="card-kid">
      <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: var(--space-3);">
        <div style="display: flex; align-items: center; gap: var(--space-3);">
          <span style="font-size: 2rem;">🤖</span>
          <div>
            <h3 style="font-size: var(--fs-lg);">Logika Komputasional & Robot</h3>
            <p style="font-size: var(--fs-xs);">Perancangan urutan langkah (sequence), rintangan, dan perulangan.</p>
          </div>
        </div>
        <span style="font-family: var(--font-heading); font-size: var(--fs-xl); color: #4F46E5;">
          <?= (int)$skills['logic']['percent'] ?>%
        </span>
      </div>
      <div class="progress-bar-kid">
        <div class="progress-fill-kid progress-fill-primary" style="width: <?= (int)$skills['logic']['percent'] ?>%;"></div>
      </div>
    </div>

    <div class="card-kid">
      <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: var(--space-3);">
        <div style="display: flex; align-items: center; gap: var(--space-3);">
          <span style="font-size: 2rem;">💡</span>
          <div>
            <h3 style="font-size: var(--fs-lg);">Pemecahan Masalah & Refleksi</h3>
            <p style="font-size: var(--fs-xs);">Ketahanan mencoba, keterbukaan pada petunjuk, dan konsolidasi makna.</p>
          </div>
        </div>
        <span style="font-family: var(--font-heading); font-size: var(--fs-xl); color: #2563EB;">
          <?= (int)$skills['problem_solving']['percent'] ?>%
        </span>
      </div>
      <div class="progress-bar-kid">
        <div class="progress-fill-kid progress-fill-primary" style="width: <?= (int)$skills['problem_solving']['percent'] ?>%;"></div>
      </div>
    </div>
  </div>

  <!-- Educational Purpose Note -->
  <div style="background: #F0FDF4; border: 2px dashed #86EFAC; border-radius: var(--radius-xl); padding: var(--space-5); text-align: center; color: #166534; font-size: var(--fs-sm);">
    📌 <strong>Catatan Edukatif:</strong> Persentase di atas adalah rekaman jejak petualangan belajar dan aktivitas nyata yang kamu selesaikan di MISSION KIDS, bukan diagnosis kaku hasil ujian. Teruslah bereksplorasi dengan ceria!
  </div>
</div>

<?php require __DIR__ . '/../../layouts/footer.php'; ?>
