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

        $profile = $this->auth->getStudentProfile($userId);
        $nickname = $profile['nickname'] ?? 'Sahabat Cilik';

        $hintResult = $this->mikoAi->getScaffoldedHint($missionSlug, $hintLevel, $attemptCount, $currentState, $nickname);
        echo json_encode($hintResult);
    }

    private function handleCompleteMission(int $userId, array $body): void
    {
        $missionId = (int)($body['mission_id'] ?? 0);
        $hintsUsed = (int)($body['hints_used'] ?? 0);
        $reflectionAnswer = !empty($body['reflection_answer']) ? (string)$body['reflection_answer'] : null;

        if ($missionId <= 0) {
            http_response_code(400);
            echo json_encode(['success' => false, 'error' => 'Data misi tidak valid.']);
            return;
        }

        $result = $this->missionProgress->completeMission($userId, $missionId, $hintsUsed, $reflectionAnswer);
        echo json_encode($result);
    }

    private function handleRecordAttempt(int $userId, array $body): void
    {
        $missionId = (int)($body['mission_id'] ?? 0);
        $hintsUsed = (int)($body['hints_used'] ?? 0);
        $isSuccess = (bool)($body['is_success'] ?? false);
        $reflectionAnswer = !empty($body['reflection_answer']) ? (string)$body['reflection_answer'] : null;

        if ($missionId > 0) {
            $this->missionProgress->recordAttempt($userId, $missionId, $hintsUsed, $isSuccess, $reflectionAnswer);
        }

        echo json_encode(['success' => true]);
    }

    private function handleUpdateProfile(int $userId, array $body): void
    {
        $nickname = (string)($body['nickname'] ?? '');
        $avatarId = (string)($body['avatar_id'] ?? '');

        $success = $this->auth->updateProfile($userId, [
            'nickname' => $nickname,
            'avatar_id' => $avatarId
        ]);

        echo json_encode(['success' => $success]);
    }
}
