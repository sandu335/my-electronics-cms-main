<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class BackupSite extends Command
{
    protected $signature = 'site:backup {--path=storage/backups}';
    protected $description = 'Create a simple backup of DB (if sqlite) and public/images';

    public function handle(): int
    {
        $path = $this->option('path') ?: storage_path('backups');
        if (! is_dir($path)) {
            mkdir($path, 0755, true);
        }

        $ts = date('Ymd_His');
        $dir = rtrim($path, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $ts;
        mkdir($dir, 0755, true);

        $this->info("Creating backup in $dir");

        // sqlite
        if (file_exists(database_path('database.sqlite'))) {
            copy(database_path('database.sqlite'), $dir . DIRECTORY_SEPARATOR . 'database.sqlite');
            $this->info('Copied sqlite database');
        }

        // images
        $images = public_path('images');
        if (is_dir($images)) {
            $archive = $dir . DIRECTORY_SEPARATOR . 'images.tar.gz';
            $cmd = "tar -czf " . escapeshellarg($archive) . " -C " . escapeshellarg(public_path()) . " images";
            @exec($cmd);
            $this->info('Archived images');
        }

        $this->info('Backup finished');
        return 0;
    }
}
