<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Facades\{Auth, Validator};
use App\Models\{Critic, FilmStatistic};

class CreateCritic
{
    /**
     * Create a new class instance.
     */
    public function __invoke($_, array $args)
    {
        Validator::make($args, [
            'film_id' => 'required|exists:films,id',
            'score'   => 'required|numeric|min:0|max:10',
            'comment' => 'required|string',
        ])->validate();

        Critic::create([
            'film_id' => $args['film_id'],
            'score'   => $args['score'],
            'comment' => $args['comment'],
            'user_id' => Auth::id(),
        ]);

        $stats = FilmStatistic::where('film_id', $args['film_id'])->first();

        $totalVotes = $stats->votes + 1;
        $newScore = (
            ($stats->score * $stats->votes) + $args['score']
        ) / $totalVotes;

        $stats->update([
            'score' => round($newScore, 2),
            'votes' => $totalVotes,
        ]);

        return $stats;
    }
}
