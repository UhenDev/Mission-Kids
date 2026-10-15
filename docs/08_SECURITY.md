# 08. KEAMANAN & PRIVASI DATA ANAK — MISSION KIDS

## 1. Standar Privasi Anak (Kepatuhan COPPA & GDPR-K)

Karena MISSION KIDS dirancang khusus untuk siswa Sekolah Dasar (*SD*), perlindungan data pribadi dan keselamatan anak diperlakukan dengan prioritas etika dan teknis tertinggi:
1. **Nol Pengumpulan Informasi Pribadi (*Zero Personally Identifiable Information / Zero PII*):** Platform hanya membutuhkan nama pengguna (*username*) dan kata sandi untuk masuk. Sistem tidak pernah meminta atau menyimpan nama lengkap asli, alamat email, nomor telepon, alamat rumah, maupun nama sekolah anak.
2. **Tanpa Ruang Obrolan Terbuka (*No Unmoderated Social Chat*):** Tidak ada fitur chat antar-pengguna yang berisiko disalahgunakan. Anak berinteraksi secara aman dan fokus hanya dengan materi misi serta sahabat belajarnya, MIKO.
3. **Bebas Pelacak Iklan Komersial (*Zero Third-Party Ad Trackers*):** Tidak ada skrip analitik komersial, piksel iklan, atau pelacakan perilaku pasar pihak ketiga.

---

## 2. Implementasi Keamanan Teknis

### 2.1 Enkripsi Kata Sandi & Penyimpanan Kredensial
- Kata sandi siswa dienkripsi menggunakan standar kriptografi modern PHP:
  ```php
  $hash = password_hash(trim($password), PASSWORD_DEFAULT);
  ```
- Kata sandi tidak pernah dicatat (*logged*) atau disimpan dalam bentuk teks polos (*plaintext*).
- Autentikasi divalidasi secara aman menggunakan fungsi resisten terhadap serangan *timing attack*:
  ```php
  password_verify(trim($password), $user['password_hash']);
  ```

### 2.2 Perlindungan dari Serangan SQL Injection (PDO Prepared Statements)
Seluruh interaksi ke basis data menggunakan parameterized queries via PHP Data Objects (PDO):
```php
$stmt = $pdo->prepare("SELECT id, username, password_hash FROM users WHERE username = :username LIMIT 1");
$stmt->execute([':username' => $username]);
$user = $stmt->fetch();
```
Penggabungan string manual (*concatenation*) pada kueri SQL dilarang secara mutlak di seluruh kode program.

### 2.3 Mitigasi Serangan Cross-Site Scripting (XSS)
Seluruh data masukan pengguna atau nilai dinamis yang ditampilkan ke antarmuka HTML wajib melewati fungsi sanitasi terpusat:
```php
function e(?string $value): string {
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
```
Header keamanan HTTP yang diterapkan mencakup:
- `X-Content-Type-Options: nosniff`
- `X-Frame-Options: SAMEORIGIN`
- `Content-Security-Policy: default-src 'self'; img-src 'self' data: https:; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com;`

### 2.4 Token Proteksi CSRF (Cross-Site Request Forgery)
Semua form dan aksi pengiriman data bermetode POST (Registrasi, Login, Penyelesaian Misi, Pembaruan Profil) wajib menyertakan token acak kriptografis yang diverifikasi terhadap sesi aktif:
```php
// Pembuatan Token
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

// Validasi Token
if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'] ?? '')) {
    http_response_code(403);
    die("Sesi keamanan kedaluwarsa. Silakan muat ulang halaman.");
}
```

### 2.5 Pengamanan Sesi PHP (Session Hardening)
Konfigurasi sesi PHP diatur dengan ketat sebelum `session_start()` dieksekusi:
- `session.cookie_httponly = 1` (Mencegah pencurian cookie sesi via JavaScript document.cookie).
- `session.cookie_samesite = 'Lax'` (Melindungi dari serangan lintas origin / CSRF).
- `session.use_strict_mode = 1` (Menolak ID sesi yang tidak diinisialisasi oleh server).
- Regenerasi ID sesi secara instan menggunakan `session_regenerate_id(true)` begitu pengguna berhasil masuk (*login*) untuk mencegah serangan *session fixation*.

### 2.6 Isolasi Kunci Rahasia AI di Sisi Server
Kunci API AI eksternal (Google Gemini / Groq / OpenAI) disimpan secara aman di sisi server (`config/config.php` atau environment variable). Klien browser tidak pernah menerima atau memiliki akses langsung ke kunci API, mencegah kebocoran kredensial komputasi awan.
