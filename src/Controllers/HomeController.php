<?php
/**
 * MISSION KIDS — Home & Student Experience Controller
 */

declare(strict_types=1);

require_once __DIR__ . '/../Services/AuthService.php';
require_once __DIR__ . '/../Services/MissionProgressService.php';
require_once __DIR__ . '/../Services/GamificationService.php';
require_once __DIR__ . '/../Helpers/Security.php';
require_once __DIR__ . '/../Helpers/Session.php';

class HomeController
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

    public function landing(): void
    {
        if (Session::isLoggedIn()) {
            header('Location: ?page=home');
            exit;
        }

        $pageTitle = "MISSION KIDS — Petualangan Misimu Dimulai di Sini.";
        require __DIR__ . '/../../templates/pages/landing.php';
    }

    public function studentHome(): void
    {
        $userId = Session::getUserId();
        if (!$userId) {
            header('Location: ?page=login');
            exit;
        }

        $profile = $this->auth->getStudentProfile($userId);
        if (!$profile) {
            Session::destroy();
            header('Location: ?page=login');
            exit;
        }

        $levelInfo = $this->gamification->calculateLevel((int)$profile['total_xp']);
        $worlds = $this->missionProgress->getWorldsWithProgress($userId);

        // Find "Mission of the Day" / Recommended: first available uncompleted mission
        $recommendedMission = null;
        foreach ($worlds as $w) {
            foreach ($w['missions'] as $m) {
                if ($m['progress_status'] === 'available') {
                    $recommendedMission = $m;
                    $recommendedMission['world_title'] = $w['title'];
                    $recommendedMission['theme_color'] = $w['theme_color'];
                    break 2;
                }
            }
        }
        // If all completed or none found, pick Mission 1 in World 1
        if (!$recommendedMission && !empty($worlds[0]['missions'][0])) {
            $recommendedMission = $worlds[0]['missions'][0];
            $recommendedMission['world_title'] = $worlds[0]['title'];
            $recommendedMission['theme_color'] = $worlds[0]['theme_color'];
        }

        $skills = $this->gamification->getSkillProgress($userId);
        $recentAchievements = $this->gamification->getUserAchievements($userId);

        $pageTitle = "Markas Petualang — MISSION KIDS";
        require __DIR__ . '/../../templates/pages/student/home.php';
    }

    public function achievements(): void
    {
        $userId = Session::getUserId();
        if (!$userId) {
            header('Location: ?page=login');
            exit;
        }

        $profile = $this->auth->getStudentProfile($userId);
        $levelInfo = $this->gamification->calculateLevel((int)$profile['total_xp']);
        $achievements = $this->gamification->getUserAchievements($userId);

        $pageTitle = "Koleksi Medali & Prestasi — MISSION KIDS";
        require __DIR__ . '/../../templates/pages/student/achievements.php';
    }

    public function progress(): void
    {
        $userId = Session::getUserId();
        if (!$userId) {
            header('Location: ?page=login');
            exit;
        }

        $profile = $this->auth->getStudentProfile($userId);
        $levelInfo = $this->gamification->calculateLevel((int)$profile['total_xp']);
        $skills = $this->gamification->getSkillProgress($userId);
        $worlds = $this->missionProgress->getWorldsWithProgress($userId);

        $pageTitle = "Jejak Perkembangan Belajar — MISSION KIDS";
        require __DIR__ . '/../../templates/pages/student/progress.php';
    }
}
