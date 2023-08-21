<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use App\Models\Validation\ValidationStatus;
use App\Models\Validation\Messages\BaseMessages;

class BaseMessagesTest extends TestCase
{
    protected array $messages = [
        'found' => 'ok',
        'not_found' => '404',
        'invalid_name' => 'invalid name',
    ];

    protected BaseMessages $base_messages;

    public function dataProvider() {
        return [
            'Invalid Case' => [
                'status' => ValidationStatus::INVALID_NAME,
                'expected_message' => $this->messages['invalid_name'],
            ],
            'Not Found Case' => [
                'status' => ValidationStatus::NOT_FOUND,
                'expected_message' => $this->messages['not_found'],
            ],
            'Found Case' => [
                'status' => ValidationStatus::FOUND,
                'expected_message' => $this->messages['found'],
            ]
        ];
    }

    public function setUp(): void
    {
        $this->base_messages = new BaseMessages($this->messages);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testGetMessage($status, string $expected_message): void
    {
        $message = $this->base_messages->getMessage($status);

        $this->assertEquals($expected_message, $message);
    }
}
