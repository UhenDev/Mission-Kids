<?php
/**
 * MISSION KIDS — Unit Tests for PuzzleValidatorService
 * Comprehensive testing of all 9 mission puzzle validators, edge cases, and reflection validation.
 */

declare(strict_types=1);

require_once __DIR__ . '/src/Services/PuzzleValidatorService.php';

echo "\n======================================================\n";
echo "  MISSION KIDS: PUZZLE VALIDATOR UNIT TEST SUITE\n";
echo "======================================================\n\n";

$validator = new PuzzleValidatorService();
$passed = 0;
$total = 0;

function assertVal(string $name, bool $condition, string $details = ''): void {
    global $passed, $total;
    $total++;
    if ($condition) {
        $passed++;
        echo "  [PASS] {$name}\n";
    } else {
        echo "  [FAIL] {$name} - {$details}\n";
    }
}

// -----------------------------------------------------------------------------
// 1. Mission 1: Toko Kue Donat (toko-kue)
// -----------------------------------------------------------------------------
$cfg1 = ['target_goods_count' => 2, 'target_change' => 1000];

$res = $validator->validate('toko-kue', ['donuts' => 2, 'change' => 1000], $cfg1);
assertVal('Misi 1: Solusi tepat (2 donat, 1000 koin)', $res['valid'] === true);

$res = $validator->validate('toko-kue', ['donuts' => 1, 'change' => 1000], $cfg1);
assertVal('Misi 1: Donat kurang ditolak', $res['valid'] === false);

$res = $validator->validate('toko-kue', ['donuts' => 2, 'change' => 500], $cfg1);
assertVal('Misi 1: Kembalian salah ditolak', $res['valid'] === false);

$res = $validator->validate('toko-kue', ['donuts' => -5, 'change' => 1000], $cfg1);
assertVal('Misi 1: Nilai negatif ditolak', $res['valid'] === false);

$res = $validator->validate('toko-kue', ['donuts' => 'abc', 'change' => 1000], $cfg1);
assertVal('Misi 1: Nilai non-numerik ditolak', $res['valid'] === false);

// -----------------------------------------------------------------------------
// 2. Mission 2: Jembatan Angka (jembatan-angka)
// -----------------------------------------------------------------------------
$cfg2 = ['correct_value' => 15, 'choices' => [13, 14, 15, 16]];

$res = $validator->validate('jembatan-angka', ['selected_value' => 15], $cfg2);
assertVal('Misi 2: Balok angka 15 diterima', $res['valid'] === true);

$res = $validator->validate('jembatan-angka', ['selected_value' => 13], $cfg2);
assertVal('Misi 2: Balok angka salah (13) ditolak', $res['valid'] === false);

$res = $validator->validate('jembatan-angka', ['selected_value' => 999], $cfg2);
assertVal('Misi 2: Angka di luar opsi choices ditolak', $res['valid'] === false);

$res = $validator->validate('jembatan-angka', ['selected_value' => 'invalid'], $cfg2);
assertVal('Misi 2: Nilai non-numerik ditolak', $res['valid'] === false);

// -----------------------------------------------------------------------------
// 3. Mission 3: Kota Pola (kota-pola)
// -----------------------------------------------------------------------------
$cfg3 = ['correct_value' => 'blue', 'choices' => ['blue', 'green', 'purple']];

$res = $validator->validate('kota-pola', ['selected_color' => 'blue'], $cfg3);
assertVal('Misi 3: Kristal biru diterima', $res['valid'] === true);

$res = $validator->validate('kota-pola', ['selected_color' => 'green'], $cfg3);
assertVal('Misi 3: Kristal hijau ditolak', $res['valid'] === false);

$res = $validator->validate('kota-pola', ['selected_color' => 'black'], $cfg3);
assertVal('Misi 3: Warna di luar palet ditolak', $res['valid'] === false);

// -----------------------------------------------------------------------------
// 4. Mission 4: Tanaman Layu (tanaman-layu)
// -----------------------------------------------------------------------------
$cfg4 = ['target_ranges' => ['water' => ['min' => 60, 'max' => 85], 'sunlight' => ['min' => 65, 'max' => 90]]];

$res = $validator->validate('tanaman-layu', ['water' => 75, 'sunlight' => 80], $cfg4);
assertVal('Misi 4: Air 75% & Matahari 80% mekar sempurna (health >= 85)', $res['valid'] === true);

$res = $validator->validate('tanaman-layu', ['water' => 20, 'sunlight' => 20], $cfg4);
assertVal('Misi 4: Tanaman layu kekeringan ditolak', $res['valid'] === false);

$res = $validator->validate('tanaman-layu', ['water' => 150, 'sunlight' => 80], $cfg4);
assertVal('Misi 4: Nilai slider di luar batas (150%) ditolak', $res['valid'] === false);

$res = $validator->validate('tanaman-layu', ['water' => 'banyak', 'sunlight' => 80], $cfg4);
assertVal('Misi 4: Format teks ditolak', $res['valid'] === false);

// -----------------------------------------------------------------------------
// 5. Mission 5: Misteri Bayangan (misteri-bayangan)
// -----------------------------------------------------------------------------
$cfg5 = ['target_scale' => ['min' => 75, 'max' => 85]];

$res = $validator->validate('misteri-bayangan', ['torch_distance' => 55], $cfg5);
assertVal('Misi 5: Jarak senter 55 cm menghasilkan skala pas (81)', $res['valid'] === true);

$res = $validator->validate('misteri-bayangan', ['torch_distance' => 80], $cfg5);
assertVal('Misi 5: Senter terlalu jauh (80 cm, skala 58) ditolak', $res['valid'] === false);

$res = $validator->validate('misteri-bayangan', ['torch_distance' => 10], $cfg5);
assertVal('Misi 5: Jarak di luar batas panggung (< 15 cm) ditolak', $res['valid'] === false);

// -----------------------------------------------------------------------------
// 6. Mission 6: Perjalanan Air (perjalanan-air)
// -----------------------------------------------------------------------------
$cfg6 = ['slots' => ['Tahap 1', 'Tahap 2', 'Tahap 3']];

$res = $validator->validate('perjalanan-air', ['sequence' => [1, 2, 3]], $cfg6);
assertVal('Misi 6: Urutan siklus air tepat [1, 2, 3]', $res['valid'] === true);

$res = $validator->validate('perjalanan-air', ['sequence' => [3, 2, 1]], $cfg6);
assertVal('Misi 6: Urutan terbalik [3, 2, 1] ditolak', $res['valid'] === false);

$res = $validator->validate('perjalanan-air', ['sequence' => [1, 2]], $cfg6);
assertVal('Misi 6: Slot belum lengkap (hanya 2 elemen) ditolak', $res['valid'] === false);

// -----------------------------------------------------------------------------
// 7. Mission 7: Robot Pulang (robot-pulang)
// -----------------------------------------------------------------------------
$cfg7 = ['grid_size' => 4, 'target' => ['x' => 2, 'y' => 2]];

// Rute aman: Maju 2x ke (2,0), Putar Kanan menghadap down, Maju 2x ke (2,2)
$safeQueue = ['FORWARD', 'FORWARD', 'TURN_RIGHT', 'FORWARD', 'FORWARD'];
$res = $validator->validate('robot-pulang', ['command_queue' => $safeQueue], $cfg7);
assertVal('Misi 7: Rute Botty sah sampai ke stasiun (2,2)', $res['valid'] === true);

// Rute menabrak rintangan di (1,1): Maju 1x ke (1,0), Putar Kanan, Maju 1x ke (1,1) -> Crash!
$crashQueue = ['FORWARD', 'TURN_RIGHT', 'FORWARD'];
$res = $validator->validate('robot-pulang', ['command_queue' => $crashQueue], $cfg7);
assertVal('Misi 7: Rute menabrak batu di (1,1) ditolak', $res['valid'] === false);

// Rute keluar arena: Maju 5x ke arah kanan -> out of bounds (x=5)
$outQueue = ['FORWARD', 'FORWARD', 'FORWARD', 'FORWARD', 'FORWARD'];
$res = $validator->validate('robot-pulang', ['command_queue' => $outQueue], $cfg7);
assertVal('Misi 7: Rute keluar arena batas grid ditolak', $res['valid'] === false);

// Perintah tidak dikenal
$badCmdQueue = ['FORWARD', 'FLY_ROCKET', 'FORWARD'];
$res = $validator->validate('robot-pulang', ['command_queue' => $badCmdQueue], $cfg7);
assertVal('Misi 7: Perintah tidak dikenal (FLY_ROCKET) ditolak', $res['valid'] === false);

// -----------------------------------------------------------------------------
// 8. Mission 8: Sensor Pintu Jalan Rahasia (jalan-rahasia)
// -----------------------------------------------------------------------------
$cfg8 = ['condition' => 'JIKA lampu Hijau -> Buka Jembatan Bawah'];

$res = $validator->validate('jalan-rahasia', ['chosen_path' => 'bawah'], $cfg8);
assertVal("Misi 8: Memilih jalur aman 'bawah' diterima", $res['valid'] === true);

$res = $validator->validate('jalan-rahasia', ['chosen_path' => 'atas'], $cfg8);
assertVal("Misi 8: Memilih jalur licin 'atas' ditolak", $res['valid'] === false);

$res = $validator->validate('jalan-rahasia', ['chosen_path' => 'tengah'], $cfg8);
assertVal("Misi 8: Pilihan tidak dikenal ditolak", $res['valid'] === false);

// -----------------------------------------------------------------------------
// 9. Mission 9: Robot Pintar Kartu Mengulang (robot-mengulang)
// -----------------------------------------------------------------------------
$cfg9 = ['target_block' => ['loop_times' => 4, 'actions' => ['JUMP', 'FORWARD']]];

$res = $validator->validate('robot-mengulang', ['loop_count' => 4, 'actions' => ['Lompat', 'Maju']], $cfg9);
assertVal('Misi 9: Loop 4x dengan Lompat + Maju diterima', $res['valid'] === true);

$res = $validator->validate('robot-mengulang', ['loop_count' => 4, 'actions' => ['JUMP', 'FORWARD']], $cfg9);
assertVal('Misi 9: Format aksi kode [JUMP, FORWARD] diterima', $res['valid'] === true);

$res = $validator->validate('robot-mengulang', ['loop_count' => 2, 'actions' => ['Lompat', 'Maju']], $cfg9);
assertVal('Misi 9: Loop count salah (2x) ditolak', $res['valid'] === false);

$res = $validator->validate('robot-mengulang', ['loop_count' => 4, 'actions' => ['Lompat']], $cfg9);
assertVal('Misi 9: Aksi tidak lengkap (hanya Lompat) ditolak', $res['valid'] === false);

// -----------------------------------------------------------------------------
// 10. Mission 10: Peluncuran Roket (roket-angkasa)
// -----------------------------------------------------------------------------
$cfg10 = [
    'target_ranges' => [
        'fuel' => ['min' => 70, 'max' => 85],
        'angle' => ['min' => 45, 'max' => 60]
    ]
];
$res = $validator->validate('roket-angkasa', ['fuel' => 75, 'angle' => 50], $cfg10);
assertVal('Misi 10: Bahan bakar 75% & sudut 50° diterima', $res['valid'] === true);

$res = $validator->validate('roket-angkasa', ['fuel' => 50, 'angle' => 50], $cfg10);
assertVal('Misi 10: Bahan bakar kurang (50%) ditolak', $res['valid'] === false);

$res = $validator->validate('roket-angkasa', ['fuel' => 75, 'angle' => 30], $cfg10);
assertVal('Misi 10: Sudut luncur terlalu rendah (30°) ditolak', $res['valid'] === false);

// -----------------------------------------------------------------------------
// 11. Mission 11: Koordinat Rasi Bintang (rasi-bintang)
// -----------------------------------------------------------------------------
$cfg11 = ['correct_value' => '4,6'];
$res = $validator->validate('rasi-bintang', ['selected_value' => '4,6'], $cfg11);
assertVal('Misi 11: Koordinat tepat (4,6) diterima', $res['valid'] === true);

$res = $validator->validate('rasi-bintang', ['selected_value' => '6,4'], $cfg11);
assertVal('Misi 11: Koordinat terbalik (6,4) ditolak', $res['valid'] === false);

// -----------------------------------------------------------------------------
// 12. Mission 12: Rover Mars (rover-mars)
// -----------------------------------------------------------------------------
$cfg12 = [];
$res = $validator->validate('rover-mars', ['commands' => ['DOWN', 'RIGHT', 'RIGHT']], $cfg12);
assertVal('Misi 12: Rute aman [DOWN, RIGHT, RIGHT] diterima', $res['valid'] === true);

$res = $validator->validate('rover-mars', ['commands' => ['BAWAH', 'KANAN', 'KANAN']], $cfg12);
assertVal('Misi 12: Rute bahasa lokal [BAWAH, KANAN, KANAN] diterima', $res['valid'] === true);

$res = $validator->validate('rover-mars', ['commands' => ['RIGHT', 'DOWN', 'RIGHT']], $cfg12);
assertVal('Misi 12: Rute menabrak kawah meteor di (1,0) ditolak', $res['valid'] === false);

$res = $validator->validate('rover-mars', ['commands' => ['DOWN', 'RIGHT']], $cfg12);
assertVal('Misi 12: Rute belum sampai tujuan (2,1) ditolak', $res['valid'] === false);

// -----------------------------------------------------------------------------
// 13. Global Payload Integrity & Edge Cases
// -----------------------------------------------------------------------------
$res = $validator->validate('toko-kue', [], $cfg1);
assertVal('Edge Case: Payload array kosong ditolak', $res['valid'] === false);

$res = $validator->validate('toko-kue', 'bukan_array', $cfg1);
assertVal('Edge Case: Payload string primitif ditolak', $res['valid'] === false);

$res = $validator->validate('misi-hantu', ['any' => 'data']);
assertVal('Edge Case: Slug misi fiktif ditolak', $res['valid'] === false);

// -----------------------------------------------------------------------------
// 14. Reflection Answer Validation
// -----------------------------------------------------------------------------
$refCfg = [
    'reflection' => [
        'question' => 'Mengapa penting memeriksa uang kembalian?',
        'options' => [
            'Agar kita tahu jumlah uang yang kita miliki tetap tepat dan jujur.',
            'Agar kasir memberikan donat gratis.',
            'Supaya bisa buang koin.'
        ],
        'correct' => 0
    ]
];

$validRef = $validator->validateReflection($refCfg, 'Agar kita tahu jumlah uang yang kita miliki tetap tepat dan jujur.');
assertVal('Refleksi: Jawaban tepat diverifikasi valid', $validRef === true);

$validRefIdx = $validator->validateReflection($refCfg, '0');
assertVal('Refleksi: Jawaban index 0 diverifikasi valid', $validRefIdx === true);

$wrongRef = $validator->validateReflection($refCfg, 'Agar kasir memberikan donat gratis.');
assertVal('Refleksi: Jawaban salah diverifikasi tidak valid', $wrongRef === false);

$emptyRef = $validator->validateReflection($refCfg, '');
assertVal('Refleksi: Jawaban kosong diverifikasi tidak valid', $emptyRef === false);

echo "\n======================================================\n";
echo "  UNIT TEST SUMMARY: {$passed} / {$total} PASSED\n";
echo "======================================================\n\n";

if ($passed === $total) {
    exit(0);
} else {
    exit(1);
}
