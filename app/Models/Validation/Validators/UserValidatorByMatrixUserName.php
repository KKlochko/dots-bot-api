<?php

namespace App\Models\Validation\Validators;

use App\Models\Validation\Validators\NextValidatorByName;
use App\Models\User;

class UserValidatorByMatrixUserName extends NextValidatorByName
{
    public function isCurrentValid(): bool
    {
        $count = User::where('matrix_username', $this->getName())->count();

        return $count != 0;
    }
}

