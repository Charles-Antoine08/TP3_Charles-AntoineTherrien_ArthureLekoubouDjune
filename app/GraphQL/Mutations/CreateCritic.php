<?php

namespace App\GraphQL\Mutations;

use App\CreateCriticValidator;
use App\Models\{Critic, FilmStatistic};
use Illuminate\Support\Facades\{Auth, Validator};

class CreateCritic
{
    public function __invoke($_, array $args): Critic
    {
        CreateCriticValidator::validate($args);

        $critic = Critic::create([
            'film_id' => $args['film_id'],
            'score'   => $args['score'],
            'comment' => $args['comment'],
            'user_id' => Auth::id(),
        ]);


        $stats = FilmStatistic::where('film_id', $args['film_id'])->first();

        if ($stats) {
            $totalVotes = $stats->votes + 1;
            $newScore = (
                ($stats->score * $stats->votes) + $args['score']
            ) / $totalVotes;

            $stats->update([
                'score' => round($newScore, 2),
                'votes' => $totalVotes,
            ]);
        }

        return $critic;
    }
}
