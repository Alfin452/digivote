<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\SuperAdmin;
use App\Models\EventAdmin;
use App\Models\Event;
use App\Models\Category;
use App\Models\Team;
use App\Models\PlatformSetting;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Platform Settings sesuai Brief
        $settings = [
            ['key' => 'platform_name', 'value' => 'DigiVote.id'], // [cite: 268]
            ['key' => 'fee_percent', 'value' => '5'], // [cite: 269]
            ['key' => 'xendit_webhook_secret', 'value' => ''], // [cite: 270]
            ['key' => 'default_price_per_vote', 'value' => '2000'], // [cite: 271]
        ];

        foreach ($settings as $setting) {
            PlatformSetting::create($setting);
        }

        // 2. Akun Super Admin Default
        SuperAdmin::create([
            'name' => 'Super Admin',
            'email' => 'super@digivote.id',
            'password' => Hash::make('password123'), // Password default untuk testing
            'is_active' => true,
        ]);

        // 3. Data Dummy Event & Admin Event untuk Testing Halaman Publik
        $event = Event::create([
            'slug' => 'pemilu-bem-2026',
            'name' => 'Pemilihan Presiden BEM 2026',
            'org' => 'Universitas',
            'description' => 'Voting untuk pemilihan Presiden BEM periode 2026/2027.',
            'price_per_vote' => 2000,
            'min_vote' => 1,
            'status' => 'live', // Kita set live agar bisa dites langsung [cite: 112]
            'started_at' => now(),
            'ended_at' => now()->addDays(7),
        ]);

        EventAdmin::create([
            'name' => 'Admin BEM',
            'email' => 'admin.bem@digivote.id',
            'password' => Hash::make('password123'),
            'event_id' => $event->id,
            'role' => 'event_admin',
        ]);

        // 4. Data Dummy Category & Teams (Kandidat)
        $category = Category::create([
            'event_id' => $event->id,
            'name' => 'Kandidat Presiden BEM',
            'sort_order' => 1,
        ]);

        Team::create([
            'event_id' => $event->id,
            'category_id' => $category->id,
            'number' => '01',
            'name' => 'Paslon Satu',
            'location' => 'Kampus A',
            'image_path' => null,
            'vote_count' => 0,
        ]);

        Team::create([
            'event_id' => $event->id,
            'category_id' => $category->id,
            'number' => '02',
            'name' => 'Paslon Dua',
            'location' => 'Kampus B',
            'image_path' => null,
            'vote_count' => 0,
        ]);
    }
}
