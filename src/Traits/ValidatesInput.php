<?php

namespace Vicimus\Support\Traits;

use Illuminate\Validation\Factory;
use Vicimus\Support\Exceptions\ValidationException;

trait ValidatesInput
{
    public function validate(array $rules)
    {
        /** @var Factory $factory */
        $factory = app('validator');
        $validator = $factory->make(request()->all(), $rules);

        if ($validator->fails()) {
            throw new ValidationException();
        }
    }
}
