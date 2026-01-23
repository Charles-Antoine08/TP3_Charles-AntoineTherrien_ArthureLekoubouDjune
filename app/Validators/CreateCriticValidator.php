<?php

namespace App;

use Illuminate\Support\Facades\Validator;

class CreateCriticValidator
{
     public static function validate(array $args): void
    {
        Validator::make($args, [
            'film_id' => 'required|exists:films,id',
            'score'   => 'required|numeric|min:0|max:10',
            'comment' => 'required|string',
        ])->validate();
    }
}
