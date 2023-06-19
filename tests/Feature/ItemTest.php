<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Item;

class ItemTest extends TestCase
{
    /* Item validation */

    public function test_item_with_empty_name(): void
    {
        $json = Item::validate_with_name('');

        $this->assertEquals($json['error'], 'The item name is empty, please, write the name!!!');
    }

    public function test_not_existing_item_with_name(): void
    {
        $name = '404 Item';

        $json = Item::validate_with_name($name);

        $this->assertEquals($json['error'], 'A item with the name does not exist!!!');
    }

    public function test_valid_item_with_name(): void
    {
        $name = 'Pizza Polo';

        $json = Item::validate_with_name($name);

        $this->assertEquals($json['ok'], 'A item with the name is valid.');
    }
}
