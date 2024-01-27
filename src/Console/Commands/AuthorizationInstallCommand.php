<?php

namespace Sonphvl\Authorization\Console\Commands;

use Illuminate\Console\Command;

class AuthorizationInstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'authorization:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Authorization package';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Publish migrations
        $this->call('vendor:publish', [
            '--tag' => 'authorization-migrations',
            '--force' => true,
        ]);

        $this->info('Authorization package installed successfully.');
    }
}
