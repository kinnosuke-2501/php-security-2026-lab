<?php
// 全ラボ共通のデータベース接続ヘルパー。
// docker-compose.yml の environment で渡した接続情報を使います。
function db(): mysqli {
    static $conn = null;
    if ($conn === null) {
        $conn = new mysqli(
            getenv('DB_HOST') ?: 'db',
            getenv('DB_USER') ?: 'labuser',
            getenv('DB_PASS') ?: 'labpass',
            getenv('DB_NAME') ?: 'vulnlab'
        );
        if ($conn->connect_errno) {
            die('DB接続エラー: ' . $conn->connect_error);
        }
        $conn->set_charset('utf8mb4');
    }
    return $conn;
}

function pdo(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $host = getenv('DB_HOST') ?: 'db';
        $name = getenv('DB_NAME') ?: 'vulnlab';
        $pdo = new PDO(
            "mysql:host=$host;dbname=$name;charset=utf8mb4",
            getenv('DB_USER') ?: 'labuser',
            getenv('DB_PASS') ?: 'labpass',
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }
    return $pdo;
}
