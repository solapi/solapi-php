<?php
/**
 * PHPUnit Bootstrap
 *
 * 1. Composer autoloader 로드
 * 2. .env 파일 환경 변수 로드
 */

// Composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// .env 파일 로드 (존재할 경우)
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // 주석 무시
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        // KEY=VALUE 형식 파싱
        if (strpos($line, '=') !== false) {
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value, " \t\n\r\0\x0B\"'");

            if (!getenv($name)) {
                putenv("$name=$value");
            }
        }
    }
}
