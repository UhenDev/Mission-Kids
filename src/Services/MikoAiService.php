<?php
/**
 * MISSION KIDS — MIKO AI Companion Service
 * Contextual educational hints with dual-layer fallback guarantee.
 */

declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';

class MikoAiService
{
    private PDO $db;
    private array $config;

    public function __construct()
    {
        $this->db = Database::getConnection();
        $this->config = require __DIR__ . '/../../config/config.php';
    }

    public function getScaffoldedHint(string $missionSlug, int $hintLevel, int $attemptCount, array $currentState = [], string $nickname = 'Sahabat Cilik'): array
    {
        $hintLevel = max(1, min(3, $hintLevel));

        // 1. Fetch mission metadata & fallback configuration
        $stmt = $this->db->prepare("SELECT m.*, w.title as world_title FROM missions m JOIN worlds w ON m.world_id = w.id WHERE m.slug = :slug LIMIT 1");
        $stmt->execute([':slug' => $missionSlug]);
        $mission = $stmt->fetch();

        if (!$mission) {
            return [
                'success' => true,
                'hint_text' => 'Halo ' . $nickname . '! MIKO ada di sini untuk menemanimu. Coba baca instruksi misinya sekali lagi pelan-pelan ya!',
                'source' => 'default',
                'hint_level' => $hintLevel,
            ];
        }

        $configData = json_decode($mission['config_json'], true) ?: [];
        $fallbackHints = $configData['hints'] ?? [];

        // Find fallback text matching level
        $fallbackText = '';
        foreach ($fallbackHints as $h) {
            if ((int)$h['level'] === $hintLevel) {
                $fallbackText = $h['text'];
                break;
            }
        }
        if (empty($fallbackText) && !empty($fallbackHints[0]['text'])) {
            $fallbackText = $fallbackHints[0]['text'];
        }

        // 2. Try External AI API if configured
        $apiKey = $this->config['ai']['api_key'] ?? '';
        if (!empty($apiKey) && function_exists('curl_init')) {
            $aiHint = $this->callGeminiApi($mission, $hintLevel, $attemptCount, $currentState, $nickname, $apiKey);
            if (!empty($aiHint)) {
                return [
                    'success' => true,
                    'hint_text' => $aiHint,
                    'source' => 'llm',
                    'hint_level' => $hintLevel,
                ];
            }
        }

        // 3. Guaranteed Deterministic Fallback
        return [
            'success' => true,
            'hint_text' => $fallbackText ?: 'Semangat ' . $nickname . '! Amati setiap benda di layar, lalu coba ubah satu persatu!',
            'source' => 'fallback',
            'hint_level' => $hintLevel,
        ];
    }

    private function callGeminiApi(array $mission, int $hintLevel, int $attemptCount, array $currentState, string $nickname, string $apiKey): ?string
    {
        $model = (string)($this->config['ai']['model'] ?? 'gemini-2.5-flash');
        $url = 'https://generativelanguage.googleapis.com/v1beta/models/' . urlencode($model) . ':generateContent?key=' . urlencode($apiKey);

        $levelGuidance = match ($hintLevel) {
            1 => "Level 1 (Konseptual): Ajukan pertanyaan pemicu rasa ingin tahu anak tanpa menyebut alat/angka spesifik. Jangan bocorkan jawaban.",
            2 => "Level 2 (Spesifik): Arahkan perhatian anak ke objek atau alat tertentu yang perlu digeser/diubah.",
            default => "Level 3 (Aksi Terbimbing): Berikan instruksi langkah praktis yang membimbing anak mencapai target tanpa menekan tombol untuknya.",
        };

        $systemInstruction = "Kamu adalah MIKO, robot pendamping belajar yang ceria, ramah, dan penuh kasih untuk anak SD di MISSION KIDS.
ATURAN UTAMA:
- Bicara dalam Bahasa Indonesia yang ramah anak, hangat, dan positif.
- Panjang jawaban WAJIB 2 sampai 3 kalimat pendek.
- Target pengguna: {$nickname}.
- Konteks Misi: {$mission['title']} ({$mission['learning_objective']}).
- Tingkat Petunjuk: {$levelGuidance}
- Percobaan ke: {$attemptCount}.
- Status saat ini: " . json_encode($currentState, JSON_UNESCAPED_UNICODE) . "
- JANGAN PERNAH meminta data pribadi seperti nama lengkap, nomor HP, atau alamat.
- Puji rasa ingin tahu anak dan beri semangat!";

        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $systemInstruction . "\n\nBerikan petunjuk sekarang untuk {$nickname}:"]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.6,
                'maxOutputTokens' => 150,
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_TIMEOUT, (int)($this->config['ai']['timeout_seconds'] ?? 4));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200 && $response) {
            $data = json_decode($response, true);
            $candidateText = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
            if (!empty($candidateText)) {
                return trim($candidateText);
            }
        }

        return null;
    }
}
