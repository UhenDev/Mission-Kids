<?php
/**
 * MISSION KIDS — Mission Navigation & Game Controller
 */

declare(strict_types=1);

require_once __DIR__ . '/../Services/AuthService.php';
require_once __DIR__ . '/../Services/MissionProgressService.php';
require_once __DIR__ . '/../Services/GamificationService.php';
require_once __DIR__ . '/../Helpers/Security.php';
require_once __DIR__ . '/../Helpers/Session.php';

class MissionController
{
    private AuthService $auth;
    private MissionProgressService $missionProgress;
    private GamificationService $gamification;

    public function __construct()
    {
        $this->auth = new AuthService();
        $this->missionProgress = new MissionProgressService();
        $this->gamification = new GamificationService();
    }

    public function showWorlds(): void
    {
        $userId = Session::getUserId();
        if (!$userId) {
            header('Location: ?page=login');
            exit;
        }

        $profile = $this->auth->getStudentProfile($userId);
        $levelInfo = $this->gamification->calculateLevel((int)$profile['total_xp']);
        $worlds = $this->missionProgress->getWorldsWithProgress($userId);

        // Map selection & isolation mechanism (supports slug, map_id, world_id, and peta index)
        $requestedParam = trim((string)($_GET['world'] ?? $_GET['map'] ?? $_GET['map_id'] ?? $_GET['world_id'] ?? Session::get('selected_map_slug', '')));

        $selectedWorld = null;
        $selectedWorldIndex = 0;

        if ($requestedParam !== '') {
            $normalizedParam = strtolower($requestedParam);
            $petaIndex = match($normalizedParam) {
                '1', 'peta-1', 'peta1' => 1,
                '2', 'peta-2', 'peta2' => 2,
                '3', 'peta-3', 'peta3' => 3,
                '4', 'peta-4', 'peta4' => 4,
                default => null
            };

            foreach ($worlds as $idx => $w) {
                if ($petaIndex !== null && ($idx + 1) === $petaIndex) {
                    $selectedWorld = $w;
                    $selectedWorldIndex = $idx;
                    break;
                }
                if ($w['slug'] === $normalizedParam || (string)$w['id'] === $normalizedParam || (string)$w['sort_order'] === $normalizedParam) {
                    $selectedWorld = $w;
                    $selectedWorldIndex = $idx;
                    break;
                }
            }
        }

        if (!$selectedWorld && !empty($worlds)) {
            $selectedWorld = $worlds[0];
            $selectedWorldIndex = 0;
        }

        if ($selectedWorld) {
            Session::set('selected_map_slug', $selectedWorld['slug']);
            Session::set('selected_map_id', $selectedWorld['id']);
        }

        $activeWorldSlug = $selectedWorld['slug'] ?? 'number-city';
        $activeMapNumber = $selectedWorldIndex + 1;

        $pageTitle = "Peta Petualangan " . ($selectedWorld['title'] ?? 'Dunia') . " — MISSION KIDS";
        require __DIR__ . '/../../templates/pages/student/worlds.php';
    }

    public function play(string $slug): void
    {
        $userId = Session::getUserId();
        if (!$userId) {
            header('Location: ?page=login');
            exit;
        }

        $profile = $this->auth->getStudentProfile($userId);
        $levelInfo = $this->gamification->calculateLevel((int)($profile['total_xp'] ?? 0));
        $mission = $this->missionProgress->getMissionBySlug($slug, $userId);

        if (!$mission) {
            header('Location: ?page=worlds');
            exit;
        }

        $csrfToken = Security::generateCsrfToken();
        $pageTitle = "Misi: " . $mission['title'] . " — MISSION KIDS";
        require __DIR__ . '/../../templates/pages/student/mission_play.php';
    }
}
