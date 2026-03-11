<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Quests',
                'slug'        => 'quests',
                'icon'        => '⚔️',
                'description' => 'Walkthroughs and tips for main story quests and side missions.',
            ],
            [
                'name'        => 'Character Builds',
                'slug'        => 'character-builds',
                'icon'        => '🧙',
                'description' => 'Optimised class builds, multiclassing guides, and feat recommendations.',
            ],
            [
                'name'        => 'Strategies',
                'slug'        => 'strategies',
                'icon'        => '🗺️',
                'description' => 'Tactical combat strategies and encounter-specific advice.',
            ],
            [
                'name'        => 'Gameplay Tips',
                'slug'        => 'gameplay-tips',
                'icon'        => '💡',
                'description' => 'General tips, hidden secrets, and quality-of-life advice for all players.',
            ],
        ];

        foreach ($categories as $data) {
            Category::firstOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
