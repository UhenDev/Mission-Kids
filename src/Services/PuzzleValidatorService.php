<?php
/**
 * MISSION KIDS — Server-Side Puzzle Validator Service
 * Validates player solutions deterministically for all 9 interactive missions.
 * Protects game progression, XP, stars, and achievement rewards from client-side tampering.
 */

declare(strict_types=1);

class PuzzleValidatorService
{
    /**
     * Validate solution for a given mission slug against its config.
     *
     * @param string $slug Mission slug
     * @param mixed $payload Submitted solution payload
     * @param array|string|null $config Mission configuration (array or JSON string)
     * @return array{valid: bool, message: string}
     */
    public function validate(string $slug, mixed $payload, array|string|null $config = null): array
    {
        // 1. Strict Payload Structure Check
        if (!is_array($payload) || empty($payload)) {
            return [
                'valid' => false,
                'message' => 'Solusi tantangan belum dikirimkan atau tidak lengkap.'
            ];
        }

        // Normalize config to associative array
        $parsedConfig = [];
        if (is_array($config)) {
            $parsedConfig = $config;
        } elseif (is_string($config) && !empty($config)) {
            $parsedConfig = json_decode($config, true) ?: [];
        }

        return match ($slug) {
            'toko-kue' => $this->validateBakeryShop($payload, $parsedConfig),
            'jembatan-angka' => $this->validateNumberBridge($payload, $parsedConfig),
            'kota-pola' => $this->validateCrystalPattern($payload, $parsedConfig),
            'tanaman-layu' => $this->validatePlantSimulation($payload, $parsedConfig),
            'misteri-bayangan' => $this->validateShadowSimulation($payload, $parsedConfig),
            'perjalanan-air' => $this->validateWaterCycle($payload, $parsedConfig),
            'robot-pulang' => $this->validateRobotRunner($payload, $parsedConfig),
            'jalan-rahasia' => $this->validateSecretPath($payload, $parsedConfig),
            'robot-mengulang' => $this->validateRobotLoop($payload, $parsedConfig),
            default => [
                'valid' => false,
                'message' => "Tantangan misi '{$slug}' tidak dikenal oleh sistem."
            ]
        };
    }

    /**
     * Validate whether the submitted reflection answer matches the correct option in config.
     */
    public function validateReflection(array|string|null $config, ?string $reflectionAnswer): bool
    {
        if ($reflectionAnswer === null || trim($reflectionAnswer) === '') {
            return false;
        }

        $parsedConfig = [];
        if (is_array($config)) {
            $parsedConfig = $config;
        } elseif (is_string($config) && !empty($config)) {
            $parsedConfig = json_decode($config, true) ?: [];
        }

        $reflection = $parsedConfig['reflection'] ?? null;
        if (!is_array($reflection) || !isset($reflection['options']) || !isset($reflection['correct'])) {
            return false;
        }

        $correctIdx = (int)$reflection['correct'];
        $correctOption = $reflection['options'][$correctIdx] ?? null;
        if ($correctOption === null) {
            return false;
        }

        $submitted = trim($reflectionAnswer);
        $expected = trim((string)$correctOption);

        // Accept exact string match or option index match
        return ($submitted === $expected || $submitted === (string)$correctIdx);
    }

    // =========================================================================
    // 1. World 1: Toko Kue Donat Bibi Bella (match_sort)
    // =========================================================================
    private function validateBakeryShop(array $payload, array $config): array
    {
        if (!isset($payload['donuts']) || !isset($payload['change'])) {
            return ['valid' => false, 'message' => 'Data donat dan uang kembalian wajib diisi.'];
        }

        if (!is_numeric($payload['donuts']) || !is_numeric($payload['change'])) {
            return ['valid' => false, 'message' => 'Format donat atau kembalian harus berupa angka.'];
        }

        $donuts = (int)$payload['donuts'];
        $change = (int)$payload['change'];

        if ($donuts < 0 || $donuts > 50 || $change < 0 || $change > 50000) {
            return ['valid' => false, 'message' => 'Jumlah donat atau kembalian berada di luar rentang wajar.'];
        }

        $targetGoods = (int)($config['target_goods_count'] ?? 2);
        $targetChange = (int)($config['target_change'] ?? 1000);

        // Scenario: 2 donat @ 2000 = 4000. Bayar 5000 -> change = 1000
        $totalPrice = $donuts * 2000;
        $expectedChange = 5000 - $totalPrice;

        if ($donuts === $targetGoods && $change === $targetChange && $expectedChange === $targetChange) {
            return [
                'valid' => true,
                'message' => 'Tepat sekali! 2 donat seharga Rp 4.000 dengan uang Rp 5.000 mendapatkan kembalian Rp 1.000!'
            ];
        }

        return [
            'valid' => false,
            'message' => 'Hitungan kasir belum pas. Ingat: 2 donat = Rp 4.000, uang pembeli Rp 5.000, berapa kembaliannya?'
        ];
    }

    // =========================================================================
    // 2. World 1: Jembatan Angka yang Hilang (match_sort)
    // =========================================================================
    private function validateNumberBridge(array $payload, array $config): array
    {
        if (!isset($payload['selected_value'])) {
            return ['valid' => false, 'message' => 'Pilihan balok angka belum ditentukan.'];
        }

        if (!is_numeric($payload['selected_value'])) {
            return ['valid' => false, 'message' => 'Nilai balok angka harus berupa bilangan numerik.'];
        }

        $val = (int)$payload['selected_value'];
        $correctVal = (int)($config['correct_value'] ?? 15);
        $choices = $config['choices'] ?? [13, 14, 15, 16];

        if (!in_array($val, $choices, true)) {
            return ['valid' => false, 'message' => 'Pilihan balok tidak ada di daftar opsi yang tersedia.'];
        }

        if ($val === $correctVal) {
            return [
                'valid' => true,
                'message' => 'Benar! Pola deret melompat 4 (+4). 11 + 4 = 15! Jembatan tersambung!'
            ];
        }

        return [
            'valid' => false,
            'message' => 'Angka tersebut belum pas. Amati selisih lompatan angka dari 3 ke 7 (+4)!'
        ];
    }

    // =========================================================================
    // 3. World 1: Taman Lampu Kristal Berpola (match_sort)
    // =========================================================================
    private function validateCrystalPattern(array $payload, array $config): array
    {
        if (!isset($payload['selected_color']) || !is_string($payload['selected_color'])) {
            return ['valid' => false, 'message' => 'Pilihan warna kristal belum ditentukan.'];
        }

        $color = strtolower(trim($payload['selected_color']));
        $correctColor = strtolower(trim((string)($config['correct_value'] ?? 'blue')));

        $validOptions = ['blue', 'green', 'purple'];
        if (!in_array($color, $validOptions, true)) {
            return ['valid' => false, 'message' => 'Pilihan kristal tidak valid.'];
        }

        if ($color === $correctColor) {
            return [
                'valid' => true,
                'message' => 'Sempurna! Pola kristal berulang: Merah - Kuning - Biru! Lampu taman bersinar indah!'
            ];
        }

        return [
            'valid' => false,
            'message' => 'Warna kristal belum tepat. Lihat 3 kristal pertama: Merah, Kuning, lalu apa?'
        ];
    }

    // =========================================================================
    // 4. World 2: Dokter Tanaman: Bunga Matahari (simulation)
    // =========================================================================
    private function validatePlantSimulation(array $payload, array $config): array
    {
        if (!isset($payload['water']) || !isset($payload['sunlight'])) {
            return ['valid' => false, 'message' => 'Parameter air dan sinar matahari wajib disertakan.'];
        }

        if (!is_numeric($payload['water']) || !is_numeric($payload['sunlight'])) {
            return ['valid' => false, 'message' => 'Kadar air dan sinar matahari harus berupa angka numerik.'];
        }

        $water = (float)$payload['water'];
        $sunlight = (float)$payload['sunlight'];

        if ($water < 0 || $water > 100 || $sunlight < 0 || $sunlight > 100) {
            return ['valid' => false, 'message' => 'Nilai slider air atau sinar matahari berada di luar batas (0-100).'];
        }

        // Replicate frontend health formula accurately
        $waterScore = 0.0;
        if ($water >= 60 && $water <= 85) {
            $waterScore = 50.0;
        } elseif ($water > 85) {
            $waterScore = max(10.0, 50.0 - ($water - 85) * 2.0);
        } else {
            $waterScore = max(5.0, ($water / 60.0) * 50.0);
        }

        $sunScore = 0.0;
        if ($sunlight >= 65 && $sunlight <= 90) {
            $sunScore = 50.0;
        } elseif ($sunlight > 90) {
            $sunScore = max(10.0, 50.0 - ($sunlight - 90) * 2.0);
        } else {
            $sunScore = max(5.0, ($sunlight / 65.0) * 50.0);
        }

        $health = (int)round($waterScore + $sunScore);

        if ($health >= 85) {
            return [
                'valid' => true,
                'message' => 'Luar biasa! Bunga matahari mekar sempurna dengan air dan sinar matahari yang cukup!'
            ];
        }

        return [
            'valid' => false,
            'message' => 'Bunga masih belum segar. Pastikan air di sekitar 70% dan buka tirai sinar matahari!'
        ];
    }

    // =========================================================================
    // 5. World 2: Misteri Teater Bayangan Kelinci (simulation)
    // =========================================================================
    private function validateShadowSimulation(array $payload, array $config): array
    {
        $rawDist = $payload['torch_distance'] ?? $payload['torch_dist'] ?? null;
        if ($rawDist === null) {
            return ['valid' => false, 'message' => 'Jarak senter belum ditentukan.'];
        }

        if (!is_numeric($rawDist)) {
            return ['valid' => false, 'message' => 'Jarak senter harus berupa bilangan numerik.'];
        }

        $dist = (float)$rawDist;
        if ($dist < 15 || $dist > 100) {
            return ['valid' => false, 'message' => 'Jarak senter di luar rentang panggung (15 cm - 100 cm).'];
        }

        // Frontend formula: shadowSize = Math.round(130 - (torch_dist * 0.9))
        $shadowScale = (int)round(130.0 - ($dist * 0.9));

        if ($shadowScale >= 75 && $shadowScale <= 85) {
            return [
                'valid' => true,
                'message' => 'Sempurna! Ukuran bayangan kelinci pas menutupi garis layar target!'
            ];
        }

        return [
            'valid' => false,
            'message' => 'Ukuran bayangan belum pas dengan target pentas. Geser senter lebih dekat!'
        ];
    }

    // =========================================================================
    // 6. World 2: Petualangan Tetes Air di Awan (match_sort)
    // =========================================================================
    private function validateWaterCycle(array $payload, array $config): array
    {
        $seq = $payload['sequence'] ?? $payload['slots'] ?? null;
        if (!is_array($seq)) {
            return ['valid' => false, 'message' => 'Urutan siklus air harus berupa daftar tahapan.'];
        }

        if (count($seq) !== 3) {
            return ['valid' => false, 'message' => 'Semua 3 kotak siklus air harus terisi lengkap.'];
        }

        $intSeq = array_map(fn($v) => is_numeric($v) ? (int)$v : 0, $seq);

        if ($intSeq === [1, 2, 3]) {
            return [
                'valid' => true,
                'message' => 'Hebat! Urutan siklus air tepat: Menguap -> Membentuk Awan -> Hujan Turun!'
            ];
        }

        return [
            'valid' => false,
            'message' => 'Urutan siklus air belum tepat. Ingat: air harus menguap dulu sebelum menjadi awan!'
        ];
    }

    // =========================================================================
    // 7. World 3: Robot Botty Pulang ke Rumah (sequence_logic)
    // =========================================================================
    private function validateRobotRunner(array $payload, array $config): array
    {
        $queue = $payload['command_queue'] ?? $payload['queue'] ?? null;
        if (!is_array($queue) || empty($queue)) {
            return ['valid' => false, 'message' => 'Antrean kartu perintah robot masih kosong.'];
        }

        if (count($queue) > 30) {
            return ['valid' => false, 'message' => 'Jumlah perintah melebihi batas maksimal kapasitas memori Botty.'];
        }

        $curX = 0;
        $curY = 0;
        $curDir = 'right';

        $dirMap = [
            'right' => ['dx' => 1, 'dy' => 0, 'right' => 'down', 'left' => 'up'],
            'down'  => ['dx' => 0, 'dy' => 1, 'right' => 'left', 'left' => 'right'],
            'left'  => ['dx' => -1, 'dy' => 0, 'right' => 'up', 'left' => 'down'],
            'up'    => ['dx' => 0, 'dy' => -1, 'right' => 'right', 'left' => 'left']
        ];

        $obstacles = [
            ['x' => 1, 'y' => 1],
            ['x' => 0, 'y' => 2]
        ];

        foreach ($queue as $cmdRaw) {
            $cmd = is_string($cmdRaw) 
                ? strtoupper(trim($cmdRaw)) 
                : (is_array($cmdRaw) ? strtoupper(trim((string)($cmdRaw['type'] ?? ''))) : '');

            if (!in_array($cmd, ['FORWARD', 'TURN_RIGHT', 'TURN_LEFT'], true)) {
                return ['valid' => false, 'message' => "Perintah '{$cmd}' tidak dikenal oleh sistem robot Botty!"];
            }

            if ($cmd === 'FORWARD') {
                $curX += $dirMap[$curDir]['dx'];
                $curY += $dirMap[$curDir]['dy'];
            } elseif ($cmd === 'TURN_RIGHT') {
                $curDir = $dirMap[$curDir]['right'];
            } elseif ($cmd === 'TURN_LEFT') {
                $curDir = $dirMap[$curDir]['left'];
            }

            // Boundary check: grid 4x4 (0 to 3)
            if ($curX < 0 || $curX > 3 || $curY < 0 || $curY > 3) {
                return ['valid' => false, 'message' => 'Botty keluar dari arena! Kurangi langkah majunya ya!'];
            }

            // Obstacle check
            foreach ($obstacles as $ob) {
                if ($curX === $ob['x'] && $curY === $ob['y']) {
                    return ['valid' => false, 'message' => 'Aduh! Botty menabrak batu rintangan. Coba belokkan arah Botty!'];
                }
            }
        }

        // Target position: (2, 2)
        if ($curX === 2 && $curY === 2) {
            return [
                'valid' => true,
                'message' => 'Horeee! Botty berhasil sampai ke stasiun daya baterai tepat waktu!'
            ];
        }

        return [
            'valid' => false,
            'message' => 'Botty belum sampai ke stasiun daya (⚡). Tambahkan langkah maju atau belokan!'
        ];
    }

    // =========================================================================
    // 8. World 3: Sensor Pintu Jalan Rahasia (sequence_logic)
    // =========================================================================
    private function validateSecretPath(array $payload, array $config): array
    {
        $chosen = $payload['chosen_path'] ?? null;
        if (!is_string($chosen)) {
            // Also accept target_path array if sent from automated runner
            if (isset($payload['target_path']) && is_array($payload['target_path'])) {
                $expectedPath = ['DOWN', 'FORWARD', 'FORWARD', 'UP', 'FORWARD'];
                if ($payload['target_path'] === $expectedPath) {
                    return [
                        'valid' => true,
                        'message' => 'Pilihan cerdas! Sensor hijau membuka jalan aman melewati jembatan bawah!'
                    ];
                }
            }
            return ['valid' => false, 'message' => 'Pilihan jalur aman belum ditentukan.'];
        }

        $choice = strtolower(trim($chosen));

        if ($choice === 'bawah') {
            return [
                'valid' => true,
                'message' => 'Pilihan cerdas! Sensor hijau membuka jalan aman melewati jembatan bawah!'
            ];
        }

        if ($choice === 'atas') {
            return [
                'valid' => false,
                'message' => 'Hati-hati! Jembatan atas menyala merah karena ada minyak licin!'
            ];
        }

        return ['valid' => false, 'message' => 'Pilihan jalur tidak dikenal.'];
    }

    // =========================================================================
    // 9. World 3: Robot Pintar Kartu Mengulang (sequence_logic)
    // =========================================================================
    private function validateRobotLoop(array $payload, array $config): array
    {
        $rawLoop = $payload['loop_count'] ?? $payload['loopCount'] ?? null;
        $rawActions = $payload['actions'] ?? null;

        if ($rawLoop === null || !is_numeric($rawLoop)) {
            return ['valid' => false, 'message' => 'Jumlah perulangan loop belum diatur.'];
        }

        if (!is_array($rawActions) || empty($rawActions)) {
            return ['valid' => false, 'message' => 'Aksi di dalam kartu perulangan masih kosong.'];
        }

        $loopCount = (int)$rawLoop;

        // Normalize action labels (accept both Indonesian and English)
        $normalizedActions = array_map(function($act) {
            $a = strtoupper(trim((string)$act));
            if ($a === 'LOMPAT' || $a === 'JUMP') return 'JUMP';
            if ($a === 'MAJU' || $a === 'FORWARD') return 'FORWARD';
            return $a;
        }, $rawActions);

        $hasJump = in_array('JUMP', $normalizedActions, true);
        $hasForward = in_array('FORWARD', $normalizedActions, true);

        if ($loopCount === 4 && $hasJump && $hasForward) {
            return [
                'valid' => true,
                'message' => 'Luar biasa! Kartu [Ulangi 4x: (Lompat, Maju)] berhasil mengantar robot ke puncak tangga!'
            ];
        }

        return [
            'valid' => false,
            'message' => "Atur jumlah perulangan menjadi 4x dan masukkan aksi 'Lompat' serta 'Maju'!"
        ];
    }
}
