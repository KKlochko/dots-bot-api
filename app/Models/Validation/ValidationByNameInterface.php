<?php

namespace App\Models\Validation;

interface ValidationByNameInterface {
    public static function isNameValid(string $name);

    public static function isExistByName(string $name);
}

