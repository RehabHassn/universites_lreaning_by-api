<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class subjects extends Model
{
    use HasFactory;
    use softDeletes;
    protected $fillable = ['user_id','year_id','name','info'];
    public function user(){
        return $this->belongsTo(User::class,'user_id');

    }
    public function year(){
        return $this->belongsTo(Collages_years::class,'year_id');
    }
    public function image()
    {
        return $this->morphOne(images::class,'imageable');
    }
}
