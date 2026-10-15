<?php
/**
 * Test API complete_mission via HTTP cURL with active session
 */

$cookieFile = __DIR__ . '/cookies.txt';

$payload = json_encode([
    'mission_id' => 4, // Tanaman Layu
    'hints_used' => 0,
    'reflection_answer' => 'Akar tanaman bisa membusuk dan tanaman sulit bernapas.'
]);

$ch = curl_init('http://127.0.0.1:8080/?page=api&action=complete_mission');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: {$httpCode}\n";
echo "Response: {$response}\n";
