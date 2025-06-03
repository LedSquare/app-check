<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MoveDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'move {domainName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    protected $domainName;

    protected $dirs = [
        'migrations',
        'seeders',
        'factories',
    ];
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->domainName = $this->argument('domainName');
        $this->copyMigrations();
    }

    protected function copyMigrations(): void
    {
        $basePathMigrations = base_path() . '/database/migrations/';
        $migrationsList = [];

        foreach (scandir($basePathMigrations) as $file) {
            if ($file === '.' || $file === '..') continue;
            $migrationsList[] = $basePathMigrations . $file;
        }

        $fileFrom = array_pop($migrationsList);
        $fileBasename = basename($fileFrom);
        $fileTo = base_path() . "/app/Domains/$this->domainName/database/migrations/$fileBasename";

        rename($fileFrom, $fileTo);
    }
}
