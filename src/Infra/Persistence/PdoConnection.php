<?php
namespace Infra\Persistence;

use PDO;

final class PdoConnection
{
    private static ?PDO $instance = null;

    private function __construct() {}              // забороняємо new
    private function __clone() {}                  // забороняємо clone
    public function __wakeup(): void               // має бути public
    {
        throw new \Exception('Cannot unserialize singleton');
    }

    public static function getInstance(): PDO
    {
        if (self::$instance === null) {
            // .env уже завантажено у config/env.php
            $host = $_ENV['DB_HOST'] ?? 'db';
            $port = $_ENV['DB_PORT'] ?? '3306';
            $db   = $_ENV['DB_NAME'] ?? 'gymdb';
            $user = $_ENV['DB_USER'] ?? 'gymuser';
            $pass = $_ENV['DB_PASS'] ?? 'gympass';

            $dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";

            self::$instance = new PDO($dsn, $user, $pass, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        }

        return self::$instance;
    }
}
