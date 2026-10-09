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

        $pageTitle = "Peta Petualangan Dunia — MISSION KIDS";
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
        $levelInfo = $this->gamification->calculateLevel((int)$profile['total_xp']);
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
