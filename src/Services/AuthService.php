<?php
/**
 * MISSION KIDS — Authentication & Profile Service
 */

declare(strict_types=1);

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../Helpers/Session.php';

class AuthService
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function register(string $username, string $password, string $nickname, string $avatarId = 'astro_cat'): array
    {
        $username = strtolower(trim($username));
        $nickname = trim($nickname);

        if (strlen($username) < 3) {
            return ['success' => false, 'error' => 'Nama pengguna minimal 3 karakter ya!'];
        }
        if (strlen($password) < 4) {
            return ['success' => false, 'error' => 'Kata sandi minimal 4 karakter agar mudah diingat!'];
        }
        if (empty($nickname)) {
            $nickname = ucfirst($username);
        }

        // Check if username exists
        $stmt = $this->db->prepare("SELECT id FROM users WHERE username = :username LIMIT 1");
        $stmt->execute([':username' => $username]);
        if ($stmt->fetch()) {
            return ['success' => false, 'error' => 'Nama panggilan ini sudah dipakai sahabat lain. Coba nama lain ya!'];
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        try {
            $this->db->beginTransaction();

            $stmtUser = $this->db->prepare("INSERT INTO users (username, password_hash, role) VALUES (:username, :password_hash, 'student')");
            $stmtUser->execute([
                ':username' => $username,
                ':password_hash' => $passwordHash,
            ]);
            $userId = (int)$this->db->lastInsertId();

            $stmtProfile = $this->db->prepare("INSERT INTO profiles (user_id, nickname, avatar_id, current_level, total_xp) VALUES (:user_id, :nickname, :avatar_id, 1, 0)");
            $stmtProfile->execute([
                ':user_id' => $userId,
                ':nickname' => $nickname,
                ':avatar_id' => $avatarId,
            ]);

            // Unlock Mission 1 in each world for new student
            $missions = $this->db->query("SELECT id, world_id, sort_order FROM missions WHERE sort_order = 1")->fetchAll();
            $stmtProg = $this->db->prepare("INSERT INTO mission_progress (user_id, mission_id, status) VALUES (:user_id, :mission_id, 'available')");
            foreach ($missions as $m) {
                $stmtProg->execute([':user_id' => $userId, ':mission_id' => $m['id']]);
            }

            $this->db->commit();

            // Establish Session
            Session::regenerate();
            Session::set('user_id', $userId);
            Session::set('username', $username);
            Session::set('nickname', $nickname);
            Session::set('avatar_id', $avatarId);

            return ['success' => true, 'user_id' => $userId];
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            return ['success' => false, 'error' => 'Gagal mendaftar: ' . $e->getMessage()];
        }
    }

    public function login(string $username, string $password): array
    {
        $username = strtolower(trim($username));

        $stmt = $this->db->prepare("SELECT u.id, u.username, u.password_hash, p.nickname, p.avatar_id, p.current_level, p.total_xp FROM users u LEFT JOIN profiles p ON u.id = p.user_id WHERE u.username = :username LIMIT 1");
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password_hash'])) {
            return ['success' => false, 'error' => 'Nama pengguna atau kata sandi belum pas. Coba cek lagi ya!'];
        }

        Session::regenerate();
        Session::set('user_id', (int)$user['id']);
        Session::set('username', $user['username']);
        Session::set('nickname', $user['nickname'] ?? ucfirst($user['username']));
        Session::set('avatar_id', $user['avatar_id'] ?? 'astro_cat');

        return ['success' => true, 'user' => $user];
    }

    public function getStudentProfile(int $userId): ?array
    {
        $stmt = $this->db->prepare("SELECT u.id, u.username, p.nickname, p.avatar_id, p.current_level, p.total_xp, p.preferred_world_id, p.created_at FROM users u JOIN profiles p ON u.id = p.user_id WHERE u.id = :id LIMIT 1");
        $stmt->execute([':id' => $userId]);
        $profile = $stmt->fetch();
        return $profile ?: null;
    }

    public function updateProfile(int $userId, array $data): bool
    {
        $fields = [];
        $params = [':user_id' => $userId];

        if (!empty($data['nickname'])) {
            $fields[] = "nickname = :nickname";
            $params[':nickname'] = trim($data['nickname']);
        }
        if (!empty($data['avatar_id'])) {
            $fields[] = "avatar_id = :avatar_id";
            $params[':avatar_id'] = $data['avatar_id'];
        }
        if (!empty($data['preferred_world_id'])) {
            $fields[] = "preferred_world_id = :preferred_world_id";
            $params[':preferred_world_id'] = (int)$data['preferred_world_id'];
        }

        if (empty($fields)) {
            return false;
        }

        $sql = "UPDATE profiles SET " . implode(', ', $fields) . " WHERE user_id = :user_id";
        $stmt = $this->db->prepare($sql);
        $res = $stmt->execute($params);

        if ($res) {
            if (!empty($data['nickname'])) Session::set('nickname', trim($data['nickname']));
            if (!empty($data['avatar_id'])) Session::set('avatar_id', $data['avatar_id']);
        }

        return $res;
    }
}
