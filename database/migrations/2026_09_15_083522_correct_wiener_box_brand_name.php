<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->renameBrand('Weiner Box', 'Wiener Box', 'owner@weinerbox.test', 'owner@wienerbox.test');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->renameBrand('Wiener Box', 'Weiner Box', 'owner@wienerbox.test', 'owner@weinerbox.test');
    }

    private function renameBrand(string $from, string $to, string $oldEmail, string $newEmail): void
    {
        $connection = DB::connection(config('lunar.database.connection'));
        $prefix = config('lunar.database.table_prefix', 'lunar_');
        $connection->table($prefix.'channels')->where('name', $from)->update(['name' => $to]);
        $connection->table($prefix.'staff')->where('first_name', $from)->update(['first_name' => $to]);
        if (! $connection->table($prefix.'staff')->where('email', $newEmail)->exists()) {
            $connection->table($prefix.'staff')->where('email', $oldEmail)->update(['email' => $newEmail]);
        }
    }
};
