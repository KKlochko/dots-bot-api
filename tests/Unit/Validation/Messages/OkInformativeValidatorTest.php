<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use App\Models\Validation\Messages\OkInformativeValidator;

class OkInformativeValidatorTest extends TestCase
{
    public function testIsValid(): void
    {
        $message = 'All fine';
        $validator = new OkInformativeValidator($message);

        $this->assertTrue($validator->isValid());
    }

    public function testGetMessage(): void
    {
        $message = 'All fine';
        $validator = new OkInformativeValidator($message);

        $this->assertEquals($validator->getMessage(), $message);
    }
}
