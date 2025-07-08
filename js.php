<?php
$botToken = '5441940388:AAGMwLVf99E87OMVr4RQ9IXOGkohds5KQn0';
$chatId   = '1975187896';

// === CORS untuk menerima dari JS ===
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200); exit;
}

$data = json_decode(file_get_contents('php://input'), true);
$ip = $_SERVER['REMOTE_ADDR'];
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
$time = date("Y-m-d H:i:s");

$msg = "📥 *New Visit*\n".
       "🕒 `$time`\n".
       "🌐 IP: `$ip`\n".
       "🔗 URL: `{$data['url']}`\n".
       "📱 Agent: `$userAgent`";

file_get_contents("https://api.telegram.org/bot$botToken/sendMessage?" . http_build_query([
  'chat_id' => $chatId,
  'text' => $msg,
  'parse_mode' => 'Markdown'
]));

// === Respon ke JS ===
echo json_encode(["status" => "ok"]);
