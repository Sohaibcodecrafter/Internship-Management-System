<?php
ob_start();

function getDB(): PDO {
    static $pdo = null;
    if ($pdo === null) {
        $host   = 'sql308.infinityfree.com';
        $dbname = 'if0_42140889_ims_db';
        $user   = 'if0_42140889';
        $pass   = 'Y8vmCxICEuPuR46';

        try {
            $pdo = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
                $user,
                $pass,
                [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ]
            );
        } catch (PDOException $e) {
            die("DB Connection failed: " . $e->getMessage());
        }
    }
    return $pdo;
}
