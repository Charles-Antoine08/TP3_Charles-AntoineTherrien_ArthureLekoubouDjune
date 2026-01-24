<?php

namespace App\GraphQL\Mutations;

use App\Models\Critic;

class UpdateCritic
{
     public function __invoke($_, array $args)
    {
        $critic = Critic::findOrFail($args['id']);

        $critic->update([
            'score'   => $args['score'],
            'comment' => $args['comment'],
        ]);

        return $critic;
    }
}
