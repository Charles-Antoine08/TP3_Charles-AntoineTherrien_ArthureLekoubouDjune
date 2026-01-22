<?php

namespace App\Models;

use App\Models\Film;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FilmStatistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'film_id',
        'score',
        'votes',
    ];

    public function film()
    {
        return $this->belongsTo(Film::class);
    }
}
