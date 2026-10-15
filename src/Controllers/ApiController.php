<?php
/**
 * MISSION KIDS — JSON API Controller
 */

declare(strict_types=1);

require_once __DIR__ . '/../Services/AuthService.php';
require_once __DIR__ . '/../Services/MissionProgressService.php';
require_once __DIR__ . '/../Services/MikoAiService.php';
require_once __DIR__ . '/../Services/GamificationService.php';
require_once __DIR__ . '/../Helpers/Security.php';
require_once __DIR__ . '/../Helpers/Session.php';
require_once __DIR__ . '/../Helpers/Avatar.php';

class ApiController
{
    private AuthService $auth;
    private MissionProgressService $missionProgress;
    private MikoAiService $mikoAi;
    private GamificationService $gamification;

    public function __construct()
    {
        $this->auth = new AuthService();
        $this->missionProgress = new MissionProgressService();
        $this->mikoAi = new MikoAiService();
        $this->gamification = new GamificationService();
    }

    public function handleRequest(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        Security::setSecurityHeaders();

        $action = $_GET['action'] ?? '';
        
        // Allow dynamic neural TTS generation for both guests and students
        if ($action === 'miko_tts') {
            $this->handleMikoTts();
            return;
        }

        $userId = Session::getUserId();

        if (!$userId) {
            http_response_code(401);
            echo json_encode(['success' => false, 'error' => 'Silakan masuk terlebih dahulu ya!']);
            exit;
        }

        $inputRaw = file_get_contents('php://input');
        $body = json_decode($inputRaw, true) ?: [];

        // Validate CSRF for state-modifying POST requests
        $csrfToken = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? ($body['csrf_token'] ?? null);
        if (in_array($action, ['complete_mission', 'record_attempt', 'update_profile'], true)) {
            if (!Security::validateCsrfToken($csrfToken)) {
                http_response_code(403);
                echo json_encode(['success' => false, 'error' => 'Sesi keamanan kedaluwarsa atau tidak valid. Silakan muat ulang halaman ya!']);
                exit;
            }
        }

        switch ($action) {
            case 'get_hint':
                $this->handleGetHint($userId, $body);
                break;

            case 'complete_mission':
                $this->handleCompleteMission($userId, $body);
                break;

            case 'record_attempt':
                $this->handleRecordAttempt($userId, $body);
                break;

            case 'update_profile':
                $this->handleUpdateProfile($userId, $body);
                break;

            default:
                http_response_code(400);
                echo json_encode(['success' => false, 'error' => 'Aksi API tidak dikenal.']);
                exit;
        }
    }

    private function handleGetHint(int $userId, array $body): void
    {
        $missionSlug = (string)($body['mission_slug'] ?? '');
        $hintLevel = (int)($body['hint_level'] ?? 1);
        $attemptCount = (int)($body['attempt_count'] ?? 0);
        $currentState = (array)($body['current_state'] ?? []);

        // Track hints delivered in session to prevent client-side hint spoofing
        if (!empty($missionSlug)) {
            $mikoHints = (array)Session::get('miko_hints', []);
            $prev = (int)($mikoHints[$missionSlug] ?? 0);
            $mikoHints[$missionSlug] = max($prev, $hintLevel);
            Session::set('miko_hints', $mikoHints);
        }

        $profile = $this->auth->getStudentProfile($userId);
        $nickname = $profile['nickname'] ?? 'Sahabat Cilik';

        $hintResult = $this->mikoAi->getScaffoldedHint($missionSlug, $hintLevel, $attemptCount, $currentState, $nickname);
        echo json_encode($hintResult);
    }

    private function handleCompleteMission(int $userId, array $body): void
    {
        $missionId = (int)($body['mission_id'] ?? 0);
        $clientHintsUsed = (int)($body['hints_used'] ?? 0);
        $reflectionAnswer = !empty($body['reflection_answer']) ? (string)$body['reflection_answer'] : null;
        $solutionPayload = isset($body['solution_payload']) && is_array($body['solution_payload']) 
            ? $body['solution_payload'] 
            : null;

        if ($missionId <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Data misi tidak valid.']);
            return;
        }

        $mission = $this->missionProgress->getMissionById($missionId);
        if (!$mission) {
            http_response_code(404);
            echo json_encode(['success' => false, 'error' => 'Misi tidak ditemukan.']);
            return;
        }

        // Compare client hints_used with hints tracked on server session
        $mikoHints = (array)Session::get('miko_hints', []);
        $serverHints = (int)($mikoHints[$mission['slug']] ?? 0);
        $effectiveHintsUsed = max($clientHintsUsed, $serverHints);

        $result = $this->missionProgress->completeMission($userId, $missionId, $effectiveHintsUsed, $reflectionAnswer, $solutionPayload);
        
        if (!$result['success']) {
            if (!empty($result['validation_failed'])) {
                http_response_code(422);
            } else {
                http_response_code(403);
            }
        } else {
            // Clean up session hint tracking for this completed mission
            unset($mikoHints[$mission['slug']]);
            Session::set('miko_hints', $mikoHints);
        }

        echo json_encode($result);
    }

    private function handleRecordAttempt(int $userId, array $body): void
    {
        $missionId = (int)($body['mission_id'] ?? 0);
        $hintsUsed = (int)($body['hints_used'] ?? 0);
        $isSuccess = (bool)($body['is_success'] ?? false);
        $reflectionAnswer = !empty($body['reflection_answer']) ? (string)$body['reflection_answer'] : null;

        if ($missionId > 0) {
            $mission = $this->missionProgress->getMissionById($missionId);
            if ($mission && $this->missionProgress->isMissionAvailable($userId, $mission)) {
                $this->missionProgress->recordAttempt($userId, $missionId, $hintsUsed, $isSuccess, $reflectionAnswer);
                echo json_encode(['success' => true]);
                return;
            }
        }

        http_response_code(403);
        echo json_encode(['success' => false, 'error' => 'Misi tidak tersedia atau masih terkunci.']);
    }

    private function handleUpdateProfile(int $userId, array $body): void
    {
        $nickname = (string)($body['nickname'] ?? '');
        $rawAvatar = (string)($body['avatar_id'] ?? '');
        $avatarId = ($rawAvatar !== '' && Avatar::isValid($rawAvatar)) ? $rawAvatar : '';

        $profileData = ['nickname' => $nickname];
        if ($avatarId !== '') {
            $profileData['avatar_id'] = $avatarId;
        }

        $success = $this->auth->updateProfile($userId, $profileData);

        echo json_encode(['success' => $success]);
    }

    private function handleMikoTts(): void
    {
        $inputRaw = file_get_contents('php://input');
        $body = json_decode($inputRaw, true) ?: [];
        $text = trim((string)($body['text'] ?? ($_GET['text'] ?? '')));
        $clean = strip_tags($text);
        if (mb_strlen($clean) > 500) {
            $clean = mb_substr($clean, 0, 500);
        }
        if (empty($clean)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Teks tidak boleh kosong.']);
            exit;
        }

        $hash = md5($clean);
        $cacheDir = __DIR__ . '/../../public/audio/miko/cache';
        $cacheFile = "{$cacheDir}/{$hash}.mp3";

        if (!is_dir($cacheDir)) {
            @mkdir($cacheDir, 0777, true);
        }

        if (file_exists($cacheFile) && filesize($cacheFile) > 1000) {
            echo json_encode(['success' => true, 'audio_url' => "/audio/miko/cache/{$hash}.mp3"]);
            exit;
        }

        // Run python generator script
        $cliScript = __DIR__ . '/../../generate_tts_cli.py';
        $escaped = escapeshellarg($clean);
        $cmd = "python \"{$cliScript}\" {$escaped}";
        $output = @shell_exec($cmd);

        if (file_exists($cacheFile) && filesize($cacheFile) > 1000) {
            echo json_encode(['success' => true, 'audio_url' => "/audio/miko/cache/{$hash}.mp3"]);
            exit;
        }

        // Fallback response if python not available
        echo json_encode(['success' => false, 'error' => 'Tidak dapat memproses TTS neural saat ini.']);
    }
}
