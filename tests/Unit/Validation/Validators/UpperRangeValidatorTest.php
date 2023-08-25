<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use App\Models\Validation\Validators\UpperRangeValidator;
use App\Models\Validation\Validators\OkValidator;

class UpperRangeValidatorTest extends TestCase
{
    public function dataProvider() {
        return [
            'Valid Case for 10' => [
                'value' => 10,
                'limit' => 10,
                'isValid' => true,
            ],
            'Valid Case for 255' => [
                'value' => 0,
                'limit' => 255,
                'isValid' => true,
            ],
            'Invalid Case for 255' => [
                'value' => 11,
                'limit' => 10,
                'isValid' => false,
            ],
            'Invalid Case for 255' => [
                'value' => 256,
                'limit' => 255,
                'isValid' => false,
            ],
        ];
    }

    public function setUpValidator(int $value, int $rangeLimit): UpperRangeValidator
    {
        return new UpperRangeValidator($value, $rangeLimit, new OkValidator());
    }

    /**
     * @dataProvider dataProvider
     */
    public function testGetMessage(int $value, int $limit, bool $isValid): void
    {
        $validator = $this->setUpValidator($value, $limit);

        $this->assertEquals($validator->isValid(), $isValid);
    }
}
