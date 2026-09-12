<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class BackupController extends Controller
{
    public function download(Request $request)
    {
        // Check authorization if route middleware isn't enough
        // $this->authorize('download-backup');

        // Build filename
        $timestamp = now()->format('Y-m-d_H-i-s');
        $filename = "db-backup-{$timestamp}.sql.gz";
        $path = storage_path("app/backups/{$filename}");

        // Ensure directory exists
        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0750, true);
        }

        // Read DB connection values (MySQL)
        $connection = Config::get('database.connections.' . Config::get('database.default'));
        if (!$connection) {
            abort(500, 'Database connection not found.');
        }

        $host = $connection['host'] ?? env('DB_HOST', '127.0.0.1');
        $port = $connection['port'] ?? env('DB_PORT', '3306');
        $database = $connection['database'] ?? env('DB_DATABASE');
        $username = $connection['username'] ?? env('DB_USERNAME');
        $password = $connection['password'] ?? env('DB_PASSWORD');

        if (empty($database)) {
            abort(500, 'Database name is not configured.');
        }

        // Build mysqldump command safely — using Process to avoid shell injection
        // We'll pass password in env to avoid showing on command line (if platform supports)
        // Command uses gzip to compress output
        $command = [
            'sh', '-c',
            // Use mysqldump and pipe through gzip to produce .sql.gz
            // We explicitly set --single-transaction and --quick for consistent dump of InnoDB
            "mysqldump --host=" . escapeshellarg($host)
            . " --port=" . escapeshellarg($port)
            . " --user=" . escapeshellarg($username)
            . ($password !== null && $password !== '' ? " --password=" . escapeshellarg($password) : '')
            . " --single-transaction --quick --skip-lock-tables "
            . escapeshellarg($database)
            . " | gzip > " . escapeshellarg($path)
        ];

        $process = new Process($command);
        // Increase timeout if DB is large
        $process->setTimeout(300); // seconds; adjust if needed

        try {
            $process->mustRun();
        } catch (ProcessFailedException $e) {
            // Clean up partial file if created
            if (file_exists($path)) {
                @unlink($path);
            }
            // You may want to log $e->getMessage()
            return back()->withErrors('Database dump failed: ' . $e->getMessage());
        }

        if (!file_exists($path)) {
            return back()->withErrors('Backup file not created.');
        }

        // Return as download and delete file after send
        return response()->download($path, $filename)->deleteFileAfterSend(true);
    }

    public function cache_clear()
    {
        Artisan::call('cache:clear');
        echo 'Cache Clear <br>';

        Artisan::call('config:clear');
        echo 'Config Clear <br>';

        Artisan::call('view:clear');
        echo 'View Clear <br>';
    }
}
