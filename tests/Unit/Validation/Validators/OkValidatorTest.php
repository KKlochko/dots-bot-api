<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use App\Models\Validation\Validators\OkValidator;

class OkValidatorTest extends TestCase
{
    public function testIsValid(): void
    {
        $validator = new OkValidator();

        $this->assertTrue($validator->isValid());
    }
}
