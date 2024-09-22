<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collages_years extends Model
{
    use HasFactory;

    protected $fillable = ['year_id', 'collage_id'];

    public function year()
    {
        return $this->belongsTo(years::class, 'year_id');
    }
    public function collage(){
        return $this->belongsTo(collages::class, 'collage_id');
    }
}
