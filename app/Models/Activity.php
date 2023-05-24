<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid as RamseyUuid;

class Activity extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'id' => 'string',
    ];

    protected $keyType = 'string';

    public $incrementing = false;

    public static function boot() {
        parent::boot();
        static::creating(function($obj){
            $obj->id = RamseyUuid::uuid4()->toString();
        });
    }
}
