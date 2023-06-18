<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    protected Category $test_category;

    protected $test_items = [
        [
            'uuid' => 'b7301b09-fc1c-4d0d-a556-ed70fc8e41f7',
            'name' => 'Pizza Polo',
            'url' => 'pizza-polo',
            'description' => 'Nunc porta vulputate tellus.',
            'price' => 79.99,
            'image' => null,
            'category_id' => null
        ],
        [
            'uuid' => 'b7301b09-fc1c-4d0d-a556-ed70fc9e40f7',
            'name' => 'Pizza Cezar',
            'url' => 'pizza-cezar',
            'description' => 'Sed bibendum.',
            'price' => 99.99,
            'image' => null,
            'category_id' => null
        ]
    ];

    public function setTestCategory()
    {
        $this->test_category = Category::firstOrCreate([
            'name' => 'Pizza',
        ]);

        $this->test_category['company_id'] = $this->test_category->id;

        // Set category_id for all items
        $size = count($this->test_items);
        for ($i = 0; $i < $size; $i++)
            $this->test_items[$i]['category_id'] = $this->test_category->id;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->setTestCategory();
        
        foreach($this->test_items as $test_item)
            Item::factory()->create($test_item);
    }
}
