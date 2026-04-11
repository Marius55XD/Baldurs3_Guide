<?php

namespace Database\Seeders;

use App\Models\Guide;
use App\Models\GuidePurchase;
use App\Models\User;
use Illuminate\Database\Seeder;

class GuidePurchaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'gvidonas02@gmx.com'],
            [
                'name' => 'Gvidonas Buikys',
                // Imported from the SQL dump.
                'password' => '$2y$12$0VfwW3ZKc6kHFc7t5v/eku9jLgKYUCC8ffEomRe0lejAkfB8zqX.m',
                'role' => 'user',
            ]
        );

        $purchases = [
            [
                'guide_slug' => 'confront-the-elder-brain-final-act-3-quest-guide',
                'amount' => 4.99,
                'paid_at' => '2026-04-11 14:36:10',
            ],
            [
                'guide_slug' => 'rescue-the-druid-halsin-grove-quest-guide',
                'amount' => 4.99,
                'paid_at' => '2026-04-11 14:36:29',
            ],
        ];

        foreach ($purchases as $purchase) {
            $guide = Guide::where('slug', $purchase['guide_slug'])->first();
            if (!$guide) {
                continue;
            }

            GuidePurchase::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'guide_id' => $guide->id,
                ],
                [
                    'amount' => $purchase['amount'],
                    'paid_at' => $purchase['paid_at'],
                ]
            );
        }
    }
}
