<?php

namespace App\Services;

class ExportService
{
    /**
     * Generic CSV streamer.
     *
     * @param string $filename  
     * @param array  $headers   
     * @param array  $rows
     */
    public static function streamCsv(string $filename, array $headers, array $rows): void
    {
        // Disable output buffering & clean extra whitespace
        if (ob_get_level()) {
            ob_end_clean();
        }

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        $out = fopen('php://output', 'w');

        // Add BOM for Excel UTF-8 support
        fprintf($out, chr(0xEF) . chr(0xBB) . chr(0xBF));

        fputcsv($out, $headers, ',', '"', "\\");

        foreach ($rows as $row) {
            fputcsv($out, $row, ',', '"', "\\");
        }

        fclose($out);
        exit;
    }

    /**
     * Generic TXT streamer (simple line-based export).
     *
     * @param string $filename
     * @param array  $headers
     * @param array  $rows
     */
    public static function streamTxt(string $filename, array $headers, array $rows): void
    {
        if (ob_get_level()) {
            ob_end_clean();
        }

        header('Content-Type: text/plain; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Pragma: no-cache');
        header('Expires: 0');

        // Header line
        echo implode(" | ", $headers) . PHP_EOL;
        echo str_repeat('=', 80) . PHP_EOL;

        // Each row on its own line
        foreach ($rows as $row) {
            // Convert arrays to strings safely
            $flat = array_map(function ($value) {
                if (is_array($value)) {
                    return implode(',', $value);
                }
                return (string) $value;
            }, $row);

            echo implode(" | ", $flat) . PHP_EOL;
        }

        exit;
    }
}
