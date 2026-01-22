<?php

namespace Database\Seeders;

use App\Models\{Film, FilmStatistic};
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\{File, Log};
use Throwable;

class FilmStatisticsSeeder extends Seeder
{
    public function run(): void
    {
        try {
            $path = database_path('seeders/data_source.json');

            if (!File::exists($path)) {
                throw new Exception('Fichier data_source.json introuvable');
            }

            $json = json_decode(File::get($path), true);

            if (!isset($json['data']) || !is_array($json['data'])) {
                throw new Exception('Structure JSON invalide : clé data absente');
            }

            foreach ($json['data'] as $filmData) {

                if (
                    !isset($filmData['id']) ||
                    !isset($filmData['reviews']) ||
                    !is_array($filmData['reviews'])
                ) {
                    throw new Exception(
                        'Structure JSON invalide pour le film ID ' . ($filmData['id'] ?? 'inconnu')
                    );
                }

                $film = Film::find($filmData['id']);

                if (!$film) {
                    throw new Exception("Film ID {$filmData['id']} introuvable en base");
                }

                $totalVotes = 0;
                $weightedScore = 0;

                foreach ($filmData['reviews'] as $review) {
                    if (!isset($review['score'], $review['votes'])) {
                        throw new Exception(
                            "Review invalide pour le film ID {$filmData['id']}"
                        );
                    }

                    $weightedScore += $review['score'] * $review['votes'];
                    $totalVotes += $review['votes'];
                }


                $score = null;
                $votes = null;

                if ($totalVotes > 0) {
                    $score = round($weightedScore / $totalVotes, 2);
                    $votes = $totalVotes;
                }

                FilmStatistic::updateOrCreate(
                    ['film_id' => $film->id],
                    [
                        'score' => $score,
                        'votes' => $votes,
                    ]
                );
            }

        } catch (Throwable $e) {
            Log::error('[FilmStatisticsSeeder] ' . $e->getMessage());
            throw $e;
        }
    }
}
