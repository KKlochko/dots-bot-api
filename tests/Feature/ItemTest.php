<?php

namespace Tests\Feature;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Item;

class ItemTest extends TestCase
{
    /* Item methods */

    public function test_item_belong_right_company(): void
    {
        $right_company_name = 'testCompany';
        $company = Company::where('name', $right_company_name)->first();

        $item_name = 'Pizza Polo';
        $item = Item::where('name', $item_name)->first();

        $is_belong = $item->isBelong($company);

        $this->assertTrue($is_belong);
    }

    public function test_item_belong_wrong_company(): void
    {
        $wrong_company_name = 'testCompany2';
        $company = Company::where('name', $wrong_company_name)->first();

        $item_name = 'Pizza Polo';
        $item = Item::where('name', $item_name)->first();

        $is_belong = $item->isBelong($company);

        $this->assertFalse($is_belong);
    }
}
