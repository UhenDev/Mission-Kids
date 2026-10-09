# 08. SECURITY & CHILD PRIVACY PLAN — MISSION KIDS

## 1. Child Privacy Standards (COPPA & GDPR-K Alignment)
Because MISSION KIDS is dedicated to primary school children (SD), data privacy and child safety are treated with the highest ethical and technical priority:
1. **Zero PII Collection:** The platform requires only a friendly username and password. We do not ask for real full names, email addresses, phone numbers, home addresses, or school names.
2. **No Unmoderated Social Chat:** There is no open, unmoderated multi-user chatroom or forum. Children interact purely with their missions and their AI companion MIKO.
3. **No Third-Party Ad Trackers:** Zero ad pixels, analytics trackers, or commercial profiling scripts.

---

## 2. Technical Security Implementations

### 2.1 Password Hashing & Credential Storage
- User passwords are encrypted using modern PHP cryptographic standards:
  ```php
  $hash = password_hash($password, PASSWORD_DEFAULT);
  ```
- Passwords are never logged or stored in plaintext. Password authentication is strictly validated via `password_verify($password, $user['password_hash'])`.

### 2.2 SQL Injection Protection (PDO Prepared Statements)
All database interactions use PHP Data Objects (PDO) with parameterized queries:
```php
$stmt = $pdo->prepare("SELECT id, username, password_hash FROM users WHERE username = :username LIMIT 1");
$stmt->execute([':username' => $username]);
$user = $stmt->fetch();
```
String concatenation in SQL queries is categorically banned across the entire codebase.

### 2.3 Cross-Site Scripting (XSS) Mitigation
All user-generated and external strings rendered into HTML views pass through a centralized sanitization helper:
```php
function e(?string $value): string {
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
```
HTTP security headers include:
- `X-Content-Type-Options: nosniff`
- `X-Frame-Options: SAMEORIGIN`
- `Content-Security-Policy: default-src 'self'; img-src 'self' data: https:; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com;`

### 2.4 CSRF (Cross-Site Request Forgery) Tokens
All state-modifying POST requests (Registration, Login, Profile updates) include a cryptographically random token verified against the active session:
```php
// Generation
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

// Verification
if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
    http_response_code(403);
    die("Sesi keamanan kedaluwarsa. Silakan muat ulang halaman.");
}
```

### 2.5 Session Hardening
PHP sessions are configured with strict flags before `session_start()`:
- `session.cookie_httponly = 1` (Precludes JavaScript document.cookie theft)
- `session.cookie_samesite = 'Lax'` (Mitigates cross-site origin attacks)
- `session.use_strict_mode = 1`
- Immediate invocation of `session_regenerate_id(true)` upon successful user authentication to eliminate session fixation vulnerabilities.

### 2.6 Server-Side AI Secret Isolation
The external AI API key (e.g. Gemini / LLM key) is kept strictly in server-side configuration (`config/config.php` or environment variable). The frontend client never has access to the raw key, preventing credential leakage.
