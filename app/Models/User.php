<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $timestamps = false;

    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'name',
        'phone',
        'photoUrl',
    ];

    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'phone' => 'string',
        'photoUrl' => 'string',
    ];

    public function account()
    {
        return $this->belongsTo(Authentication::class, 'id', 'id');
    }
}
