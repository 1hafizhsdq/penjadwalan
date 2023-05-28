<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid as RamseyUuid;

class Schedule extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'id' => 'string',
    ];

    protected $keyType = 'string';
    
    public $incrementing = false;
    protected $primaryKey = 'id';

    public static function boot() {
        parent::boot();
        static::creating(function($obj){
            $obj->id = RamseyUuid::uuid4()->toString();
        });
    }

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    
    public function project(){
        return $this->belongsTo(Project::class,'project_id');
    }
    
    public function activity(){
        return $this->hasMany(Activity::class,'schedule_id');
    }
}
