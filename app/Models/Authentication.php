<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Authentication extends Model
{
    public $timestamps = false;

    protected $table = 'authentication';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'email',
        'password',
        'username',
        'verified',
        'status',
        'resettable',
        'roles_mask',
        'registered',
        'last_login',
        'force_logout',
    ];

    protected $casts = [
        'id' => 'integer',
        'email' => 'string',
        'password' => 'string',
        'username' => 'string',
        'verified' => 'boolean',
        'status' => 'boolean',
        'resettable' => 'boolean',
        'roles_mask' => 'integer',
        'registered' => 'integer',
        'last_login' => 'integer',
        'force_logout' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }
}
