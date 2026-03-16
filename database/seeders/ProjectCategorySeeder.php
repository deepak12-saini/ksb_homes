<?php

namespace Database\Seeders;

use App\Models\ProjectCategory;
use Illuminate\Database\Seeder;

class ProjectCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Multi-Residential', 'slug' => 'multi-residential', 'sort_order' => 1],
            ['name' => 'Residential', 'slug' => 'residential', 'sort_order' => 2],
            ['name' => 'For Sale', 'slug' => 'for-sale', 'sort_order' => 3],
        ];

        foreach ($categories as $cat) {
            ProjectCategory::firstOrCreate(
                ['slug' => $cat['slug']],
                $cat
            );
        }
    }
}
