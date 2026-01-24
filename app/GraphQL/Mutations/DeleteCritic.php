<?php

namespace App\GraphQL\Mutations;

use App\Models\Critic;

class DeleteCritic
{
     public function __invoke($_, array $args)
    {
        $critic = Critic::findOrFail($args['id']);
        $critic->delete();

        return true;
    }
}
