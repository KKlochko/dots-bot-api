<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use App\Models\Validation\Messages\UpperRangeInformativeValidator;
use App\Models\Validation\Messages\OkInformativeValidator;
use App\Models\Validation\Validators\UpperRangeValidator;
use App\Models\Validation\Validators\OkValidator;

class UpperRangeInformativeValidatorTest extends TestCase
{
    protected $messages = [
        'ok' => 'valid',
        'error' => 'invalid',
    ];

    public function dataProvider() {
        return [
            'Valid Case for 10' => [
                'value' => 10,
                'limit' => 10,
                'isValid' => true,
                'message' => $this->messages['ok'],
            ],
            'Valid Case for 255' => [
                'value' => 0,
                'limit' => 255,
                'isValid' => true,
                'message' => $this->messages['ok'],
            ],
            'Invalid Case for 10' => [
                'value' => 11,
                'limit' => 10,
                'isValid' => false,
                'message' => $this->messages['error'],
            ],
            'Invalid Case for 255' => [
                'value' => 256,
                'limit' => 255,
                'isValid' => false,
                'message' => $this->messages['error'],
            ],
        ];
    }

    public function setUpValidator(int $value, int $rangeLimit): UpperRangeInformativeValidator
    {
        $upperRangeValidator = new UpperRangeValidator($value, $rangeLimit, new OkValidator());

        return new UpperRangeInformativeValidator(
            $this->messages['error'],
            $upperRangeValidator,
            new OkInformativeValidator($this->messages['ok']),
        );
    }

    /**
     * @dataProvider dataProvider
     */
    public function testGetMessage(int $value, int $limit, bool $isValid, string $message): void
    {
        $validator = $this->setUpValidator($value, $limit);

        $this->assertEquals($validator->isValid(), $isValid);
        $this->assertEquals($validator->getMessage(), $message);
    }
}
