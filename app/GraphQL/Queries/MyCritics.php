<?php

namespace App\GraphQL\Queries;

use App\Models\Critic;
use Illuminate\Support\Facades\Auth;

class MyCritics
{

    public function __invoke($_, array $args)
    {
        return Critic::where('user_id', Auth::id())->get();
    }
}
