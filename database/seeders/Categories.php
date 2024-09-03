<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Categories extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        
        $categories = [
            'Bills',
            'Groceries',
            'Subscriptions',
            'Travel',
            'Misc',
            'Business',
            'Income',
            'Entertainment',
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create([
                'name' => $category,
                'colour' => '#'.substr(md5(rand()), 0, 6),
                'user_id' => 1,
            ]);
        }
    }
}
