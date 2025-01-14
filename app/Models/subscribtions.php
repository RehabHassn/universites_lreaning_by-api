<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subscribtions extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','subject_id','price','discount','isLoked','note'];
    public function user(){
        return $this->belongsTo(User::class,'user_id','id')
            ->withTrashed();
    }
    public function subject(){
        return $this->belongsTo(subjects::class,'subject_id','id')
            ->withTrashed();
    }
}
