<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Collages extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable=['government_id','name','info'];
    public function government(){
        return $this->belongsTo(governments::class,'government_id')->withTrashed();
    }
//    public function years()
//    {
//        return $this->hasMany(Collages_years::class,'collage_id');
//    }
    public function years()
    {
        return $this->belongsToMany(years::class,Collages_years::class,
            'collage_id','year_id');
//        ->withPivot('created_at','updated_at','deleted_at')->as('middle_table')
    }
}
