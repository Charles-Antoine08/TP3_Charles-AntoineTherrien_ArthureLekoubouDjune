<?php

namespace App\GraphQL\Mutations;

use Illuminate\Support\Facades\DB;
use App\Models\{Actor, Film};

class CreateActor
{
     public function __invoke($_, array $args): Actor
    {
        return DB::transaction(function () use ($args) {

            $actor = Actor::create([
                'first_name' => $args['input']['first_name'],
                'last_name'  => $args['input']['last_name'],
                'birthdate'  => $args['input']['birthdate'],
            ]);

            if (!empty($args['input']['film_id'])) {
                $actor->films()->attach($args['input']['film_id']);
            }


            if (!empty($args['input']['film_update'])) {
                foreach ($args['input']['film_update'] as $update) {
                    Film::where('id', $update['film_id'])
                        ->update(['image' => $update['image']]);
                }
            }

            return $actor;
        });
    }
}
