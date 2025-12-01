<?php

namespace App\Helpers;

use App\Config\Database;
use PDO;

class RateLimiter
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connection();
    }

    public function check(string $endpoint, int $maxAttempts, int $seconds): bool
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';

        $stmt = $this->db->prepare("
            SELECT * FROM rate_limits
            WHERE ip = ? AND endpoint = ?
        ");
        $stmt->execute([$ip, $endpoint]);
        $record = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($record) {
            $lastTime = strtotime($record['last_attempt']);
            $timeDiff = time() - $lastTime;

            if ($timeDiff > $seconds) {
                // reset
                $stmt = $this->db->prepare("
                    UPDATE rate_limits SET attempts = 1, last_attempt = NOW()
                    WHERE id = ?
                ");
                $stmt->execute([$record['id']]);
                return true;
            }

            if ($record['attempts'] >= $maxAttempts) {
                return false; // deny
            }

            // increment attempts
            $stmt = $this->db->prepare("
                UPDATE rate_limits SET attempts = attempts + 1, last_attempt = NOW()
                WHERE id = ?
            ");
            $stmt->execute([$record['id']]);
            return true;
        }

        // first attempt
        $stmt = $this->db->prepare("
            INSERT INTO rate_limits (ip, endpoint, attempts)
            VALUES (?, ?, 1)
        ");
        $stmt->execute([$ip, $endpoint]);
        return true;
    }
}
