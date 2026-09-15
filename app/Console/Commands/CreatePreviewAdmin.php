<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Lunar\Admin\Models\Staff;

class CreatePreviewAdmin extends Command
{
    protected $signature = 'wiener:preview-admin';

    protected $description = 'Create a local-only admin with a randomly generated password saved privately';

    public function handle(): int
    {
        if (! app()->environment('local')) {
            $this->error('This command is only available in the local environment.');

            return self::FAILURE;
        }
        if (Staff::where('email', 'owner@wienerbox.test')->exists()) {
            $this->info('The local owner account already exists. Credentials are in storage/app/private/preview-admin.json.');

            return self::SUCCESS;
        }
        $password = Str::password(24, symbols: false);
        Staff::create(['first_name' => 'Wiener Box', 'last_name' => 'Owner', 'email' => 'owner@wienerbox.test', 'password' => $password, 'admin' => true]);
        $path = storage_path('app/private/preview-admin.json');
        File::ensureDirectoryExists(dirname($path));
        File::put($path, json_encode(['url' => url('/admin'), 'email' => 'owner@wienerbox.test', 'password' => $password], JSON_PRETTY_PRINT));
        chmod($path, 0600);
        $this->info('Local admin created. Open storage/app/private/preview-admin.json for credentials.');

        return self::SUCCESS;
    }
}
