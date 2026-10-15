<?php
/**
 * MISSION KIDS — Avatar Character Management Helper
 * Defines the 8 dynamic 3D kid human avatars with consistent art direction
 */

declare(strict_types=1);

class Avatar
{
    public const DEFAULT_AVATAR = 'kian';

    /**
     * Complete metadata for the 8 official 3D human kid characters
     */
    public static function all(): array
    {
        return [
            'kian' => [
                'id' => 'kian',
                'name' => 'Kian',
                'role' => 'Si Penjelajah',
                'title' => 'Kian — Si Penjelajah',
                'desc' => 'Penasaran, berani, dan selalu siap mencoba petualangan baru!',
                'image' => 'assets/images/avatars/kian.png',
                'thumb' => 'assets/images/avatars/kian-thumb.png',
                'alt' => 'Kian, anak penjelajah berjaket biru dengan tas kecil',
                'fallback_icon' => '👦',
            ],
            'sera' => [
                'id' => 'sera',
                'name' => 'Sera',
                'role' => 'Si Ilmuwan',
                'title' => 'Sera — Si Ilmuwan',
                'desc' => 'Cerdas, teliti, serta suka belajar dan bereksperimen sains!',
                'image' => 'assets/images/avatars/sera.png',
                'thumb' => 'assets/images/avatars/sera-thumb.png',
                'alt' => 'Sera, anak ilmuwan perempuan berkacamata dengan pakaian kuning dan tablet',
                'fallback_icon' => '👧',
            ],
            'raka' => [
                'id' => 'raka',
                'name' => 'Raka',
                'role' => 'Si Atlet',
                'title' => 'Raka — Si Atlet',
                'desc' => 'Disiplin, aktif, berenergi tinggi, dan pantang menyerah!',
                'image' => 'assets/images/avatars/raka.png',
                'thumb' => 'assets/images/avatars/raka-thumb.png',
                'alt' => 'Raka, anak atletik dengan topi merah dan jaket olahraga merah',
                'fallback_icon' => '🏃',
            ],
            'nara' => [
                'id' => 'nara',
                'name' => 'Nara',
                'role' => 'Si Seniman',
                'title' => 'Nara — Si Seniman',
                'desc' => 'Kreatif, penuh imajinasi warna-warni, dan gemar berkarya seni!',
                'image' => 'assets/images/avatars/nara.png',
                'thumb' => 'assets/images/avatars/nara-thumb.png',
                'alt' => 'Nara, anak seniman perempuan dengan apron toska dan palet lukis',
                'fallback_icon' => '🎨',
            ],
            'dika' => [
                'id' => 'dika',
                'name' => 'Dika',
                'role' => 'Si Petualang',
                'title' => 'Dika — Si Petualang',
                'desc' => 'Berani, berpikir positif, dan gemar menjelajahi keajaiban dunia!',
                'image' => 'assets/images/avatars/dika.png',
                'thumb' => 'assets/images/avatars/dika-thumb.png',
                'alt' => 'Dika, anak petualang dengan rompi outdoor, celana krem, dan kamera',
                'fallback_icon' => '🧭',
            ],
            'bayu' => [
                'id' => 'bayu',
                'name' => 'Bayu',
                'role' => 'Si Teknolog',
                'title' => 'Bayu — Si Teknolog',
                'desc' => 'Logis, inovatif, dan sangat tertarik dengan teknologi canggih!',
                'image' => 'assets/images/avatars/bayu.png',
                'thumb' => 'assets/images/avatars/bayu-thumb.png',
                'alt' => 'Bayu, anak teknolog berpakaian kasual pink-ungu membawa tablet digital',
                'fallback_icon' => '💻',
            ],
            'fajar' => [
                'id' => 'fajar',
                'name' => 'Fajar',
                'role' => 'Si Penemu',
                'title' => 'Fajar — Si Penemu',
                'desc' => 'Rasa ingin tahu tinggi, cermat mengamati dan memecahkan teka-teki!',
                'image' => 'assets/images/avatars/fajar.png',
                'thumb' => 'assets/images/avatars/fajar-thumb.png',
                'alt' => 'Fajar, anak penemu berkacamata dengan jas lab dan kaca pembesar canggih',
                'fallback_icon' => '🔬',
            ],
            'luna' => [
                'id' => 'luna',
                'name' => 'Luna',
                'role' => 'Si Pemimpin',
                'title' => 'Luna — Si Pemimpin',
                'desc' => 'Ramah, percaya diri, suka bekerja sama dan menginspirasi sahabat!',
                'image' => 'assets/images/avatars/luna.png',
                'thumb' => 'assets/images/avatars/luna-thumb.png',
                'alt' => 'Luna, anak perempuan pemimpin berjaket ungu, topi petualang, dan melambaikan tangan',
                'fallback_icon' => '⭐',
            ],
        ];
    }

    /**
     * Map legacy or non-standard IDs to one of the 8 canonical characters
     */
    public static function normalize(string $avatarId): string
    {
        $id = strtolower(trim($avatarId));
        $all = self::all();
        if (isset($all[$id])) {
            return $id;
        }

        // Backward compatibility map
        $legacyMap = [
            'astro_cat' => 'kian',
            'super_bear' => 'raka',
            'clever_fox' => 'sera',
            'star_owl' => 'fajar',
            'rocket_boy' => 'kian',
            'wonder_girl' => 'luna',
            'botty_bot' => 'bayu',
            'happy_dino' => 'dika',
        ];

        return $legacyMap[$id] ?? self::DEFAULT_AVATAR;
    }

    public static function get(string $avatarId): array
    {
        $normalized = self::normalize($avatarId);
        $all = self::all();
        return $all[$normalized] ?? $all[self::DEFAULT_AVATAR];
    }

    public static function isValid(string $avatarId): bool
    {
        $id = strtolower(trim($avatarId));
        $all = self::all();
        if (isset($all[$id])) {
            return true;
        }

        // Also accept legacy IDs to prevent breaking existing tests
        $legacy = ['astro_cat', 'super_bear', 'clever_fox', 'star_owl', 'rocket_boy', 'wonder_girl', 'botty_bot', 'happy_dino'];
        return in_array($id, $legacy, true);
    }

    /**
     * Render thumbnail avatar HTML (compact circle/badge for navbar & home cards)
     */
    public static function renderThumbnail(string $avatarId, int $size = 40, string $extraClass = '', string $title = ''): string
    {
        $data = self::get($avatarId);
        $safeTitle = htmlspecialchars($title ?: $data['title'], ENT_QUOTES, 'UTF-8');
        $safeAlt = htmlspecialchars($data['alt'], ENT_QUOTES, 'UTF-8');
        $thumbUrl = htmlspecialchars($data['thumb'], ENT_QUOTES, 'UTF-8');

        return sprintf(
            '<img src="%s" alt="%s" class="avatar-thumb-circle %s" style="width: %dpx; height: %dpx; border-radius: 50%%; object-fit: cover; display: inline-block; vertical-align: middle; border: 2px solid #DBEAFE; background: #EFF6FF;" title="%s" loading="lazy">',
            $thumbUrl,
            $safeAlt,
            htmlspecialchars($extraClass, ENT_QUOTES, 'UTF-8'),
            $size,
            $size,
            $safeTitle
        );
    }
}
